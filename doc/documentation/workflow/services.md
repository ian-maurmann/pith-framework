# Services

A Service is a business-logic class. It receives method calls from an [Action](actions.md), talks to [Table Gateways](table-gateways.md) (and utilities), and returns data or structured results back to that Action.

Services are **not** workflow elements. They sit below Actions, outside the Route → Pack → Access → Action → Preparer → View pipeline. Actions inject Services; Services inject Gateways.

There is no framework base class named `PithService`. Services are plain PHP classes that follow a naming and injection convention.

## Role in the stack

```
Route List → Route → Pack → Access → Action → Service → Gateway → DB wrapper (PDO)
                                              ↓
                                         Preparer → View
```

| Layer | Responsibility |
|-------|----------------|
| **Action** | Request-facing logic; fills `$this->prepare` |
| **Service** | Business rules, validation, orchestration, transactions |
| **Gateway** | SQL for one table (or a small related set) |
| **DB wrapper** | PDO connection, `query()`, transactions |

Keep HTTP and view concerns out of Services. Keep SQL out of Services—call Gateways for that. Actions should call Services, not Gateways.

## Defining a Service

Inject Gateways (and any utilities) through the constructor, store them, and expose methods that apply domain rules:

```php
namespace FooOrganization\FooProject;

use Pith\Framework\PithException;

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

Name the class `{Domain}Service` and the Action property `{domain}_service` (for example `UserService` / `$user_service`).

Place Service files under a `services/` folder in the pack (or a feature `model/` folder in older packs). Map that folder into the pack namespace with PSR-4 so PHP-DI can autowire it. There is no Service registry.

## How Actions call Services

Type-hint Services on the Action constructor. PHP-DI builds both:

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

The Action gathers request input, calls the Service, and pushes the result onto `$this->prepare` for the [Preparer](preparers.md):

```php
class IsUsernameAvailableAction extends PithAction
{
    private UserService $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function runAction()
    {
        $username_unsafe = $_REQUEST['username'] ?? '';
        $info            = $this->user_service->getUsernameAvailability($username_unsafe);

        $this->prepare->response = [
            'message_status' => 'success',
            'action_status'  => $info['is_available'] === 'yes' ? 'success' : 'failure',
            'data'           => $info,
        ];
    }
}
```

## How Services call Gateways

Type-hint Gateways on the Service constructor. Call Gateway methods for data access; keep multi-step and multi-table work in the Service:

```php
class UserService
{
    private PithPostgresWrapper $database;
    private UserGateway         $user_gateway;
    private UsernameNormalizer  $username_normalizer;

    public function __construct(
        PithPostgresWrapper $database,
        UserGateway $user_gateway,
        UsernameNormalizer $username_normalizer
    ) {
        $this->database           = $database;
        $this->user_gateway       = $user_gateway;
        $this->username_normalizer = $username_normalizer;
    }

    public function getUsernameAvailability($given_name): array
    {
        $is_available = false;
        $name_info    = $this->username_normalizer->getNameInfo($given_name);
        $is_allowed   = $name_info['is_allowed'] === 'yes';
        $fail_reason  = $name_info['fail_reason'];

        if ($is_allowed) {
            $name       = $name_info['name_normalized'];
            $name_lower = $name_info['name_normalized_lower'];

            try {
                $name_results     = $this->user_gateway->findUsernameResults($name, $name_lower);
                $has_name_results = count($name_results) > 0;
                $fail_reason      = $has_name_results ? 'username-unavailable' : $fail_reason;
                $is_available     = !$has_name_results;
            } catch (PithException $e) {
                $is_available = false;
                $fail_reason  = 'database-query-exception';
            }
        }

        return [
            'name_normalized'       => $name_info['name_normalized'],
            'name_normalized_lower' => $name_info['name_normalized_lower'],
            'is_allowed'            => $name_info['is_allowed'],
            'is_available'          => $is_available ? 'yes' : 'no',
            'fail_reason'           => $fail_reason,
        ];
    }
}
```

A Service may inject several Gateways plus helpers (password hashing, name normalization, random chars) when one domain operation spans multiple tables or steps.

### Transactions

Start, commit, and roll back on the DB wrapper from the **Service** (not the Gateway) when a workflow touches multiple tables or steps:

- `$database->startTransaction()`
- `$database->commitTransaction()`
- `$database->rollbackTransaction()`

See [Table Gateways](table-gateways.md) for SQL patterns and the Postgres wrapper API.

## Return style

Services often return **info arrays** rather than throwing for expected domain failures. Common fields:

| Field | Typical values |
|-------|----------------|
| `is_*` / `is_available` / `is_successful` | `'yes'` or `'no'` |
| `fail_reason` | kebab-case string (`username-unavailable`, `password-is-too-short`) |
| `fail_field` | which input failed, when useful |

Validation helpers sometimes use try/catch with `Exception` messages as fail reasons (`email-address-is-empty`). Gateway SELECT failures often throw `PithException`; Services catch those and map them to a domain `fail_reason` or empty data. Write paths commonly throw a plain `Exception` when an insert or update did not take effect.

## Where they live

| Generation | Layout |
|------------|--------|
| Current packs (user-system-5) | `…/services/` next to `gateways/` under the pack |
| user-system-3 | `…/user-system-models/services/` + `gateways/` |
| Older shared-infrastructure | `…/model/{feature}/` with Service + Gateway co-located |

App Pack scaffolds include a `services/` folder. A Pack does not register Services. PSR-4 + constructor type-hints are enough.

Services are usually called from Actions, but other framework pieces can inject them too (for example access control using `UserService`).

## Conventions

- Name classes `*Service`; Action properties `{domain}_service`.
- Inject Gateways and utilities through the constructor (PHP-DI).
- Put business rules, validation, and orchestration in Services; put SQL in Gateways.
- Prefer structured info arrays with `fail_reason` and yes/no flags for domain outcomes.
- Keep transactions and multi-step workflows in Services.
- Keep Services PSR-4 autoloadable; type-hinting them on an Action is registration.

## Related pieces

| Piece | Role |
|-------|------|
| Service (`*Service`) | Business logic; calls Gateways |
| [Table Gateways](table-gateways.md) (`*Gateway`) | SQL / table access |
| [Actions](actions.md) (`PithAction`) | Injects Services; fills `$prepare` |
| [Packs](packs.md) (`PithPack`) | Feature tree that often contains `services/` and `gateways/` |
| [Preparers](preparers.md) (`PithPreparer`) | Shapes `$prepare` → `$view` after the Action |
| [Routes](routes.md) | Wire Action FQCNs; never touch Services or Gateways |
| `PithPostgresWrapper` | Current Postgres PDO wrapper (transactions from Services) |

## Important source files

- `src/plugins/user-system-5/src/user-system-5-pack/services/UserService.php`
- `src/plugins/user-system-5/src/user-system-5-pack/gateways/UserGateway.php`
- `src/plugins/user-system-5/src/user-system-5-pack/endpoints/is-username-available/IsUsernameAvailableAction.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/model/test-quotes/TestQuoteService.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/model/test-quotes/TestQuoteGateway.php`
- `src/plugins/shared-infrastructure-DEPRECATED/src/shared-infrastructure-pack/controller-and-view/pages/demo-pages/quotes/QuotesAction.php`
