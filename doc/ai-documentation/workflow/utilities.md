# Utilities

A Utility is a helper class. It receives method calls from a [Service](services.md), transforms or validates data without talking to other domain objects, and returns results back to that Service.

Utilities are **not** workflow elements. They sit below Services, outside the Route → Pack → Access → Action → Preparer → View pipeline. Services inject Utilities (alongside [Table Gateways](table-gateways.md)).

There is no framework base class named `PithUtility`. Utilities are plain PHP classes that follow a naming and injection convention.

## Role in the stack

```
Route List → Route → Pack → Access → Action →    Service → Utility
                                        ↓           ↓
                                    Preparer     Gateway → DB
```

| Layer | Responsibility |
|-------|----------------|
| **Action** | Request-facing logic; fills `$this->prepare` |
| **Service** | Business rules, orchestration, transactions |
| **Utility** | Transforms, validation, and helpers (no SQL, no Gateways) |
| **Gateway** | SQL for one table (or a small related set) |

Keep HTTP and view concerns out of pack Utilities when possible. Keep SQL out of Utilities—call Gateways from the Service for that. Do not call Services or Gateways from a Utility; a Utility should work with the data it is given and return a result.

## Defining a Utility

Expose methods that take input and return a transformed or validated result. Many Utilities need no constructor dependencies:

```php
namespace FooOrganization\FooProject;

use Normalizer;

class PasswordUtility
{
    public function getPasswordHash(string $raw_password): string
    {
        $password_utf8_nfc = normalizer_normalize($raw_password, Normalizer::NFC);
        $password_hash     = password_hash($password_utf8_nfc, PASSWORD_DEFAULT);

        return $password_hash;
    }
}
```

Name the class `{Concern}Utility` and the Service property `{concern}_utility` (for example `PasswordUtility` / `$password_utility`). Domain helpers sometimes use a role name instead (`UsernameNormalizer`) but still live under `utilities/`.

Place Utility files under a `utilities/` folder in the pack, next to `services/` and `gateways/`. Map that folder into the pack namespace with PSR-4 so PHP-DI can autowire it. There is no Utility registry.

Shared helpers that many packs use live under `src/utilities/` in the `Pith\Framework\Utility\` namespace (for example `RandomCharUtility`, `PithHeaderUtility`, `GroupingUtility`).

## How Services call Utilities

Type-hint Utilities on the Service constructor. PHP-DI builds both:

```php
class UserService
{
    private PasswordUtility   $password_utility;
    private RandomCharUtility $random_char_utility;
    private UserGateway       $user_gateway;
    private UsernameNormalizer $username_normalizer;

    public function __construct(
        PasswordUtility $password_utility,
        RandomCharUtility $random_char_utility,
        UserGateway $user_gateway,
        UsernameNormalizer $username_normalizer
    ) {
        $this->password_utility    = $password_utility;
        $this->random_char_utility = $random_char_utility;
        $this->user_gateway        = $user_gateway;
        $this->username_normalizer = $username_normalizer;
    }

    public function getUsernameAvailability($given_name): array
    {
        $name_info  = $this->username_normalizer->getNameInfo($given_name);
        $is_allowed = $name_info['is_allowed'] === 'yes';
        // …then use Gateways for DB checks when allowed…
    }
}
```

The Service calls the Utility for non-SQL work, then Gateways for data access:

```php
$password_hash   = $this->password_utility->getPasswordHash($new_password);
$user_check_char = $this->random_char_utility->getRandomCheckCharVersion1();
$user_id         = $this->user_gateway->createUser($user_check_char, $username_lower, $email_address);
```

The Action calls the Service, not the Utility:

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

## What belongs in a Utility

| Good fit | Better elsewhere |
|----------|------------------|
| Hashing, normalization, formatting | SQL / table access → Gateway |
| Validation rules on a value | Multi-step orchestration → Service |
| Random tokens / check chars | Filling `$prepare` / HTTP response shaping → Action |
| Pure transforms of given input | View escaping → Preparer / `PithEscapeUtility` |

A Utility may inject **another Utility** when composition helps (for example a normalizer that uses a reserved-name helper). Prefer not to inject Services or Gateways.

Actions sometimes inject a Utility directly for request or HTTP helpers (for example `PithHeaderUtility` on an endpoint Action). Prefer Services for domain work; direct Action → Utility injection is the exception, not the rule.

## Return style

Utilities often return **transformed values** (`string`, `array`, `bool`) or **info arrays** in the same style as Services. Common info-array fields:

| Field | Typical values |
|-------|----------------|
| `is_*` / `is_allowed` | `'yes'` or `'no'` |
| `fail_reason` | kebab-case string |
| Normalized copies | `name_normalized`, `name_normalized_lower`, and similar |

Example shape from username validation:

```php
[
    'is_too_long'           => 'yes'|'no',
    'name_normalized'       => ...,
    'name_normalized_lower' => ...,
    'is_reserved'           => 'yes'|'no',
    'is_allowed'            => 'yes'|'no',
    'fail_reason'           => ...,
    'problem_char_index'    => ...,
]
```

## Where they live

| Generation | Layout |
|------------|--------|
| Current packs (user-system-5) | `…/utilities/` next to `services/` and `gateways/` under the pack |
| Shared app helpers | `src/utilities/{http,random,string}/` → `Pith\Framework\Utility\` |
| user-system-3 | `…/user-system-models/utilities/` |
| Framework internals | `src/framework/internal/utilities/` → `Pith\Framework\Internal\` (engine / presentation helpers) |

A Pack does not register Utilities. PSR-4 + constructor type-hints are enough.

Internal utilities such as `PithEscapeUtility` and `PithExpressionUtility` support the engine and presentation layers. Pack and shared `Pith\Framework\Utility\` helpers are the ones Services typically inject for domain work.

## Conventions

- Name classes `*Utility` (or a clear role name under `utilities/`); Service properties `{concern}_utility`.
- Inject Utilities through the Service constructor (PHP-DI).
- Keep Utilities free of SQL, Services, and Gateways; work with given data and return a result.
- Prefer shared `Pith\Framework\Utility\` helpers for cross-pack concerns; keep pack-specific rules in the pack `utilities/` folder.
- Prefer structured info arrays with `fail_reason` and yes/no flags when validating.
- Keep Utilities PSR-4 autoloadable; type-hinting them on a Service is registration.

## Related pieces

| Piece | Role |
|-------|------|
| Utility (`*Utility`) | Transforms / validation / helpers; no SQL |
| [Services](services.md) (`*Service`) | Business logic; calls Utilities and Gateways |
| [Table Gateways](table-gateways.md) (`*Gateway`) | SQL / table access |
| [Actions](actions.md) (`PithAction`) | Injects Services; fills `$prepare` |
| [Packs](packs.md) (`PithPack`) | Feature tree that often contains `utilities/`, `services/`, and `gateways/` |
| [Preparers](preparers.md) (`PithPreparer`) | Uses framework `PithEscapeUtility` via `$this->escape` |
| [Routes](routes.md) | Wire Action FQCNs; never touch Utilities |

## Important source files

- `src/plugins/user-system-5/src/user-system-5-pack/utilities/PasswordUtility.php`
- `src/plugins/user-system-5/src/user-system-5-pack/utilities/UsernameNormalizer.php`
- `src/plugins/user-system-5/src/user-system-5-pack/services/UserService.php`
- `src/utilities/random/RandomCharUtility.php`
- `src/utilities/http/PithHeaderUtility.php`
- `src/utilities/string/GroupingUtility.php`
- `src/framework/internal/utilities/PithEscapeUtility.php`
- `src/framework/internal/utilities/PithReservedNameUtility.php`
