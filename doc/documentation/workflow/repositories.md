# Repositories

A Repository is a data-orchestration class used on more complicated features. It receives method calls from a [Service](services.md), talks to one [Table Gateway](table-gateways.md) (or a few Gateways for closely related tables), and returns rows, IDs, or shaped results back to that Service.

Repositories are **not** workflow elements. They sit between Services and Gateways, outside the Route → Pack → Access → Action → Preparer → View pipeline. Actions inject Services. Simple features keep Services talking to Gateways directly. Complicated features insert Repositories so Services inject Repositories, and Repositories inject Gateways.

> **Status:** Repositories are a planned object type. They are not yet added to this framework. Today, and for simple features going forward, Services call Gateways directly. Add a Repository only when a feature’s data access would otherwise bloat the Service.

There is no framework base class named `PithRepository`. Repositories are plain PHP classes that follow a naming and injection convention.

## Role in the stack

**Simple features** keep the existing path:

```
Route List → Route → Pack → Access → Action → Service → Gateway → DB wrapper (PDO)
                                              ↓
                                         Preparer → View
```

**Complicated features** insert a Repository when the Service would otherwise grow too large with Gateway wiring and data-shaping:

```
Route List → Route → Pack → Access → Action → Service → Repository → Gateway → DB wrapper (PDO)
                                              ↓
                                         Preparer → View
```

| Layer | Responsibility |
|-------|----------------|
| **Action** | Request-facing logic; fills `$this->prepare` |
| **Service** | Business rules, validation, orchestration, transactions |
| **Repository** | Optional data-access façade for complicated features; calls one Gateway, or a few for closely related tables |
| **Gateway** | SQL for one table (or a small related set) |
| **DB wrapper** | PDO connection, `query()`, transactions |

Keep HTTP and view concerns out of Repositories. Keep SQL out of Repositories—call Gateways for that. Keep business rules in Services. Actions should call Services, not Repositories or Gateways. Prefer Service → Gateway for simple features; use Service → Repository → Gateway when the middle layer keeps the Service lean.

## When to use a Repository

Gateways stay close to one table and raw SQL. Services stay close to domain rules. For many features, Service → Gateway is enough.

Add a Repository when the feature is complicated enough that the Service would become bloated without something in between—too many Gateways, too much data-shaping, or too much coordination of closely related tables mixed into business rules.

Use a Repository when:

- The Service would otherwise inject and orchestrate many Gateway calls for one domain area
- Several closely related tables are always loaded or written together, and a thin multi-Gateway façade keeps the Service clearer
- Data-access plumbing is crowding out business rules in the Service

Skip a Repository when:

- The feature is simple and Service → Gateway stays readable
- One or two Gateway calls are enough and do not obscure the Service’s domain logic

Prefer **one Gateway** per Repository when possible. Use **only a few Gateways** when the tables are tightly related (for example user + user access levels). Do not turn a Repository into a catch-all for unrelated tables—that orchestration belongs in the Service.

## Defining a Repository

Inject one Gateway (or a few related Gateways) through the constructor, store them, and expose methods that fetch or persist data for the Service:

```php
namespace FooOrganization\FooProject;

use Pith\Framework\PithException;

class QuoteRepository
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

With a few closely related Gateways:

```php
class UserRepository
{
    private UserGateway            $user_gateway;
    private UserAccessLevelGateway $user_access_level_gateway;

    public function __construct(
        UserGateway $user_gateway,
        UserAccessLevelGateway $user_access_level_gateway
    ) {
        $this->user_gateway              = $user_gateway;
        $this->user_access_level_gateway = $user_access_level_gateway;
    }

    public function findUserRowByUsernameLower(string $username_lower): ?array
    {
        return $this->user_gateway->findUserRowByUsernameLower($username_lower);
    }

    public function getUserAccessLevels(int $user_id): array
    {
        return $this->user_access_level_gateway->getUserAccessLevels($user_id);
    }
}
```

Name the class `{Domain}Repository` and the Service property `{domain}_repository` (for example `UserRepository` / `$user_repository`).

Place Repository files under a `repositories/` folder in the pack, next to `services/` and `gateways/`. Map that folder into the pack namespace with PSR-4 so PHP-DI can autowire it. There is no Repository registry.

## How Services call Repositories

On complicated features, type-hint Repositories on the Service constructor instead of (or alongside) Gateways. PHP-DI builds both:

```php
class QuoteService
{
    private QuoteRepository $quote_repository;

    public function __construct(QuoteRepository $quote_repository)
    {
        $this->quote_repository = $quote_repository;
    }

    public function getQuotes(): array
    {
        return $this->quote_repository->getQuotes();
    }
}
```

The Action still calls the Service, not the Repository:

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

## How Repositories call Gateways

Type-hint Gateways on the Repository constructor. Call Gateway methods for SQL; keep multi-step domain rules and transactions in the Service:

```php
class UserRepository
{
    private UserGateway $user_gateway;

    public function __construct(UserGateway $user_gateway)
    {
        $this->user_gateway = $user_gateway;
    }

    public function findUsernameResults(string $name, string $name_lower): array
    {
        return $this->user_gateway->findUsernameResults($name, $name_lower);
    }

    public function createUser(
        string $postfix_chars,
        string $username,
        string $username_lower,
        string $email_address,
        string $password_hash
    ): int {
        return $this->user_gateway->createUser(
            $postfix_chars,
            $username,
            $username_lower,
            $email_address,
            $password_hash
        );
    }
}
```

### Transactions

Start, commit, and roll back on the DB wrapper from the **Service** (not the Repository or Gateway) when a workflow touches multiple steps or tables:

- `$database->startTransaction()`
- `$database->commitTransaction()`
- `$database->rollbackTransaction()`

See [Table Gateways](table-gateways.md) for SQL patterns and the Postgres wrapper API. See [Services](services.md) for transaction ownership and domain return style.

## What belongs in a Repository

| Good fit | Better elsewhere |
|----------|------------------|
| Data-access work that would bloat a complicated Service | Simple Service → Gateway features (no Repository needed) |
| Façade over one Gateway | Business rules / validation → Service |
| Thin coordination of a few related Gateways | Unrelated multi-feature orchestration → Service |
| Returning rows, IDs, or simple shaped data | Raw SQL → Gateway |
| Mapping Gateway exceptions into empty data when appropriate | Filling `$prepare` / HTTP shaping → Action |
| | Transforms with no DB → [Utility](utilities.md) |

A Repository may inject **another Repository** only when composition clearly helps; prefer keeping Repositories narrow. Do not inject Services or Actions into a Repository.

## Return style

Repositories typically return the same shapes Gateways do—`array`, `int`, `?array`, `bool`—or lightly shaped collections. Domain outcome flags (`is_available`, `fail_reason`) usually stay in the Service. Gateway SELECT failures often throw `PithException`; Repositories or Services catch those and map them to empty data or a domain `fail_reason`.

## Where they live

| Generation | Layout |
|------------|--------|
| Planned pack layout | `…/repositories/` next to `services/` and `gateways/` under the pack |

A Pack does not register Repositories. PSR-4 + constructor type-hints are enough.

Simple features keep Services injecting Gateways directly, as documented in [Services](services.md) and [Table Gateways](table-gateways.md). Add `repositories/` only for packs or features that need the extra layer.

## Conventions

- Name classes `*Repository`; Service properties `{domain}_repository`.
- Keep Service → Gateway for simple features; add Service → Repository → Gateway only when the Service would otherwise become bloated.
- Inject one Gateway, or only a few Gateways for closely related tables.
- Put data-access façades in Repositories; put SQL in Gateways; put business rules in Services.
- Keep transactions and multi-step domain workflows in Services.
- Keep HTTP and view concerns out of Repositories.
- Keep Repositories PSR-4 autoloadable; type-hinting them on a Service is registration.

## Related pieces

| Piece | Role |
|-------|------|
| Repository (`*Repository`) | Optional data-access façade for complicated features; calls one or a few Gateways |
| [Services](services.md) (`*Service`) | Business logic; calls Gateways (simple) or Repositories (complicated), plus Utilities |
| [Table Gateways](table-gateways.md) (`*Gateway`) | SQL / table access |
| [Utilities](utilities.md) (`*Utility`) | Transforms / validation / helpers; no SQL |
| [Actions](actions.md) (`PithAction`) | Injects Services; fills `$prepare` |
| [Packs](packs.md) (`PithPack`) | Feature tree; may add `repositories/` beside `services/` and `gateways/` when needed |
| [Routes](routes.md) | Wire Action FQCNs; never touch Repositories or Gateways |
| `PithPostgresWrapper` | Current Postgres PDO wrapper (transactions from Services) |

## Important source files

Repositories are not implemented in this framework yet. For the layers they sit between, see:

- `src/plugins/user-system-5/src/user-system-5-pack/services/UserService.php`
- `src/plugins/user-system-5/src/user-system-5-pack/gateways/UserGateway.php`
- `src/plugins/user-system-5/src/user-system-5-pack/gateways/UserAccessLevelGateway.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/model/test-quotes/TestQuoteService.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/model/test-quotes/TestQuoteGateway.php`
