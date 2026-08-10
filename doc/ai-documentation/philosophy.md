# Philosophy of Pith

Pith is a lightweight PHP framework built from proven components. It aims to stay small, modern, and easy to understand—while giving you a clear place for each kind of work.

## Built from established components

Pith does not reinvent the stack. It wires together libraries that are already widely used and well documented:

| Concern | Component |
|---------|-----------|
| Routing | [FastRoute](https://github.com/nikic/FastRoute) |
| Dependency injection | [PHP-DI](https://php-di.org/) |
| HTTP request / response | [Symfony HttpFoundation](https://symfony.com/doc/current/components/http_foundation.html) |
| Logging | [Monolog](https://github.com/Seldaek/monolog) |
| Database schema changes | [Doctrine Migrations](https://www.doctrine-project.org/projects/migrations.html) |

You keep the benefits of those tools. Pith’s job is to connect them with a thin, readable workflow—not to hide them behind a large proprietary core.

## Small and easy to understand

Pith prefers plain PHP classes and explicit configuration over magic.

- A **Route** is mostly config: which access level, Action, view, and related pieces to use.
- Listing a class FQCN (and constructor type-hints) is enough for wiring. There is no separate Service or Gateway registry to learn.
- Workflow elements stay intentionally small (`PithAction`, `PithPack`, `PithPreparer`, and so on), so the framework surface stays easy to read.

The goal is that a developer can follow a request from URL match to render without needing a large mental model of framework internals.

## Simple defaults

Pith provides simple defaults so basic pages stay thin. Optional pieces fall back to no-ops or pass-throughs—for example empty Actions, pass-through Preparers, and empty View Requisitions—so you only add what the feature needs.

You can grow into more structure when a feature needs it. You are not forced to fill every layer for every Route.

## Clear separation of concerns

Pith organizes work into two stacked conventions that meet at the Action:

- **Route–Action–View (RAV)** — URL match, access, request-facing logic, prepare/view shaping, and render.
- **Action–Service–Gateway (ASG)** — business rules, orchestration, SQL (via Gateways), and helpers (via Utilities).

Routes stay free of domain and SQL details. Services stay free of Routes and Views. That split keeps HTTP and presentation concerns apart from domain logic, which makes features easier to reason about and domain code easier to test.

See [Combined RAV–ASG workflow](rav-asg-workflow.md) for how those pipelines fit together.

## What “lightweight” means here

Lightweight in Pith means:

- Prefer composition of known components over a heavy framework core.
- Prefer conventions and defaults over mandatory ceremony.
- Prefer code you can open and understand over abstraction for its own sake.

Pith is meant to feel modern without feeling large: established pieces underneath, a small workflow on top, and defaults that stay out of the way until you need more.
