# Table Gateways

A Table Gateway is a data-access class. It receives method calls from a Service, runs SQL against the database, and returns rows, IDs, or scalars back to that Service.

Gateways are **not** workflow elements. They sit below [Actions](actions.md) and Services, outside the Route → Pack → Access → Action → Preparer → View pipeline. Actions inject Services; Services inject Gateways.

There is no framework base class named `TableGateway`. Gateways are plain PHP classes that follow a naming and injection convention.

## Role in the stack

```
Route List → Route → Pack → Access → Action → Service → Gateway → DB wrapper (PDO)
                                              ↓
                                         Preparer → View
```

| Layer | Responsibility |
|-------|----------------|
| **Action** | Request-facing logic; fills `$this->prepare` |
| **Service** | Business rules, orchestration, transactions |
| **Gateway** | SQL for one table (or a small related set) |
| **DB wrapper** | PDO connection, `query()`, transactions |

Keep HTTP and view concerns out of Gateways. Keep SQL out of Services and Actions.

## Defining a Gateway

Inject `PithPostgresWrapper`, store it, and expose methods that run SQL:

```php
namespace FooOrganization\FooProject;

use Pith\Framework\PithPostgresWrapper;
use Pith\Framework\PithException;

class QuoteGateway
{
    private PithPostgresWrapper $database;

    public function __construct(PithPostgresWrapper $database)
    {
        $this->database = $database;
    }

    /**
     * @throws PithException
     */
    public function getQuotes(): array
    {
        $sql = 'SELECT * FROM pith_test_quotes WHERE quote_id < 100';

        $results = $this->database->query($sql);

        $has_results = is_array($results) && (count($results) > 0);

        return $has_results ? $results : [];
    }
}
```

Prefer **one Gateway per table**. Name the class `{Entity}Gateway` and the Service property `{entity}_gateway` (for example `UserGateway` / `$user_gateway`).

Place Gateway files under a `gateways/` folder in the pack (or a feature `model/` folder in older packs). Map that folder into the pack namespace with PSR-4 so PHP-DI can autowire it. There is no Gateway registry.

## How Services call Gateways

Type-hint Gateways on the Service constructor. PHP-DI builds both:

```php
class QuoteService
{
    private QuoteGateway $quote_gateway;

    public function __construct(QuoteGateway $quote_gateway)
    {
        $this->quote_gateway = $quote_gateway;
    }

    public function getQuotes(): array
    {
        $quotes = [];

        try {
            $quotes = $this->quote_gateway->getQuotes();
        } catch (PithException $e) {
            // Handle or log
        }

        return $quotes;
    }
}
```

The Action calls the Service, not the Gateway:

```php
class QuotesAction extends PithAction
{
    private QuoteService $quote_service;

    public function __construct(QuoteService $quote_service)
    {
        $this->quote_service = $quote_service;
    }

    public function runAction()
    {
        $this->prepare->quotes = $this->quote_service->getQuotes();
    }
}
```

## Talking to the database

New code should use `PithPostgresWrapper` (env: `PITH_POSTGRES_DSN`, `PITH_POSTGRES_USERNAME`, `PITH_POSTGRES_PASSWORD`). Older packs may still inject legacy `PithDatabaseWrapper` (MariaDB/MySQL). Both expose a similar `query()` API and a public `$pdo` handle.

Gateways use **raw SQL + PDO**. Doctrine is used for migrations, not as a runtime ORM. Return associative arrays and scalars—not entity objects.

### SELECT with `query()`

`$database->query($sql, ...$params)` auto-connects, runs the statement, and returns `FETCH_ASSOC` rows. Positional `?` placeholders are bound from the extra arguments:

```php
$sql = '
    SELECT *
    FROM pith_users
    WHERE username = ?
       OR username_lower = ?
    ';

$results = $this->database->query($sql, $name, $name_lower);
```

With one argument only, `query($sql)` runs without parameters. Query failures throw `PithException` (codes 6002 / 6003 / 6004).

### INSERT / UPDATE with PDO

When you need `lastInsertId()` or `rowCount()`, prepare on `$this->database->pdo` with named placeholders:

```php
$sql = '
    INSERT INTO pith_users
        (postfix_chars, username, username_lower, primary_email_address, password_hash)
    VALUES
        (:postfix_chars, :username, :username_lower, :primary_email_address, :password_hash)
    ';

$statement = $this->database->pdo->prepare($sql);
$statement->execute([
    ':postfix_chars'         => $postfix_chars,
    ':username'              => $username,
    ':username_lower'        => $username_lower,
    ':primary_email_address' => $email_address,
    ':password_hash'         => $password_hash,
]);

$inserted_id = $this->database->pdo->lastInsertId() ?: 0;
if ($inserted_id === 0) {
    throw new Exception('Failed to insert to the User table.');
}

return (int) $inserted_id;
```

Call `$this->database->connectOnce()` before direct PDO use if the connection may not be open yet. `query()` already connects.

### Transactions

Start, commit, and roll back on the wrapper from the **Service** (not the Gateway) when a workflow touches multiple tables or steps:

- `$database->startTransaction()`
- `$database->commitTransaction()`
- `$database->rollbackTransaction()`

## Common method patterns

| Pattern | Example | Typical return |
|---------|---------|----------------|
| Find list | `findUsernameResults`, `getQuotes` | `array` (empty if none) |
| Find one ID | `findUserIdByUsernameLower` | `int` (`0` if missing) |
| Find one row | `findUserRowByUsernameLower` | `?array` |
| Insert + id | `createUser` | `int` inserted id; throw on failure |
| Update check | flag / mark methods | `bool` via `rowCount()` |
| Projected join | `getUserAccessLevels` | shaped `array` |

Method names are verb-first and specific about the SQL intent (`findUserIdByUsernameLower`, `getNewestLoginCredentialRowForUserByUserId`).

Services often catch `PithException` from Gateway SELECTs and map them to domain fail reasons. INSERT/UPDATE helpers commonly throw a plain `Exception` when the write did not take effect.

## Where they live

| Generation | Layout |
|------------|--------|
| Current packs (user-system-5) | `…/gateways/` next to `services/` under the pack |
| user-system-3 | `…/user-system-models/gateways/` + `services/` |
| Older shared-infrastructure | `…/model/{feature}/` with Gateway + Service co-located |

A Pack does not register Gateways. PSR-4 + constructor type-hints are enough.

## Conventions

- Name classes `*Gateway`; Service properties `{entity}_gateway`.
- Prefer one Gateway per table.
- Inject `PithPostgresWrapper` as `$database` for new code.
- Prefer `$database->query($sql, …)` for SELECT; use `$database->pdo` for INSERT/UPDATE when you need insert ids or row counts.
- Keep transactions and multi-step workflows in Services.
- Return arrays and scalars, not domain entities.
- Keep Gateways PSR-4 autoloadable; type-hinting them on a Service is registration.

## Related pieces

| Piece | Role |
|-------|------|
| Gateway (`*Gateway`) | SQL / table access |
| Service (`*Service`) | Business logic; calls Gateways |
| [Actions](actions.md) (`PithAction`) | Injects Services; fills `$prepare` |
| [Packs](packs.md) (`PithPack`) | Feature tree that often contains `gateways/` and `services/` |
| `PithPostgresWrapper` | Current Postgres PDO wrapper |
| `PithDatabaseWrapper` | Legacy MariaDB/MySQL wrapper |
| `PithDatabaseWrapperHelper` | Arg flattening and query helpers |
| [Routes](routes.md) | Wire Action FQCNs; never touch Gateways |

## Important source files

- `src/framework/external/framework-engine-components/PithPostgresWrapper.php`
- `src/framework/external/framework-engine-components/PithDatabaseWrapper.php`
- `src/framework/internal/helpers/PithDatabaseWrapperHelper.php`
- `src/plugins/user-system-5/src/user-system-5-pack/gateways/UserGateway.php`
- `src/plugins/user-system-5/src/user-system-5-pack/gateways/UserAccessLevelGateway.php`
- `src/plugins/user-system-5/src/user-system-5-pack/services/UserService.php`
- `src/plugins/user-system-5/src/user-system-5-pack/endpoints/is-username-available/IsUsernameAvailableAction.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/model/test-quotes/TestQuoteGateway.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/model/test-quotes/TestQuoteService.php`
