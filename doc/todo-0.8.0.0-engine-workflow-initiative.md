
> [All ToDo Lists](todo-index.md)
---

# Engine Workflow Initiative Roadmap for 0.8


---


## General

> Fixup:
> - [ ] Add PhpDoc comments
> - [ ] PhpDoc comments in PhpStorm can display pictures now. Add documentation pictures.
> 
> Refactor:
> - [ ] Refactor objects to use the App Reference Trait.

## Pith Info

> Add:
> - [ ] Meta Object (Internal, with framework version info, legal info.)
> - [ ] Info Object `$this->app->info` (External, with methods that talk to Meta Object, but also app info, and info from the pith.json file.)
> 
> Edit:
> - [ ] The Info Object should be accesssible from `$this->app->info`
> 
> Cleanup / refactor at the end:
> - [ ] Remove the Version Trait

## Config
> Add:
> - [x] Add simple Constants file.
> - [ ] New Config system.
>
> Cleanup / refactor at the end:
> - [ ] Remove the current Config.
> - [ ] Remove the Config Profiles.

## Engine

> Add:
> - [x] Engine Object `$app->engine` & `$this->app->engine` 
> - ~~Engine State Machine Object~~ (Dispatching was too interconnected for using states)
> - ~~Engine State Object? (Or use PHP8 enum? Or a simple string?)~~ (n/a)
> 
> Framework Startup:
> - [x] Add new startup method `$app->engine->start();`
> 
> Workflow
> - ~~State Machine should have methods like~~ `enterRouting( )`, ~~and~~ `enterDispatching( )` (n/a)
> 
> Cleanup / refactor at the end:
> - [ ] Remove the Startup Trait
> - [ ] Remove the Run Trait

## Routing

> Add to Engine
> - [x] Do routing with FastRoute (Figure out how to keep our 2-level routing, and how to dynamically add/remove routes. Cache routes, to array?)
> 
> Cleanup / refactor at the end:
> - [ ] Remove the current Router.



## Dispatch

> Add to Engine
> - ~~Add new cleaned-up Dispatcher.~~ (Added new functions to Dispatcher)
> - [x] Instead of Controller Objects with `action( )` and `preparer( )` functions, use Action Objects and Preparer Objects.
>
> Cleanup / refactor at the end:
> - ~~Remove the current Dispatcher~~ (Added new functions to Dispatcher)
> - [ ] Cleanup Dispatcher.

## Error Reporting

> Add
> - [x] Add "PithException" exception
> - [ ] Add special Monolog logging for Pith Exceptions, ex: `$e->logMysqlConnectionFailure`, for when services catch exceptions for well-known problems.
> 
> Cleanup / refactor at the end:
> - [ ] Remove the current Problem calls.
> - [ ] Remove the Problem trait.
> - [ ] Remove the Problem Handler

---

## Appendix A
### Objects in 0.7.5

External

> External Extendable:
> - Pith Access Level
> - Pith Controller
> - Pith Query
> 
> External Interfaces
> - Pith App Interface
> - Pith Config Interface
> - Pith Controller Interface
> - Pith Module Interface
> - Pith Router Interface
> 
> External Objects
> - Pith Access Control
> - Pith App
> - Pith Config
> - Pith Dispatcher
> - Pith Request Processor
> - Pith Router
> 
> External Traits
> - Pith Problem Trait 
> - Pith Run Trait
> - Pith Startup Trait
> - Pith Version Trait



Internal

> Internal Objects
> - Pith Access Level Factory
> - Pith App Helper
> - Pith Problem Handler
> - Pith Problem List
> - Pith Request Helper
> - Pith Route
> - Pith State Enum
> - Pith State Machine
> - Pith String Utility
> 
> Internal Traits
> - Pith App Reference Trait

---

## Appendix B (WIP)
### Current Objects in 0.8+ (WIP)


External

> External Extendable:
> - Pith Access Level
> - [x] **Pith Action**
> - Pith Controller
> - [x] **Pith Pack**
> - [x] **Pith Preparer**
> - Pith Query
> - [x] **Pith Route**
> - [x] **Pith View Requisition**
> - [x] **Pith Workflow Element**
>
> External Interfaces
> - Pith App Interface
> - Pith Config Interface
> - Pith Controller Interface
> - Pith Module Interface
> - Pith Router Interface
>
> External Objects
> - Pith Access Control
> - Pith App
> - Pith Config
> - Pith Dispatcher
> - [x] **Pith Engine**
> - [x] **Pith Exception**
> - [x] **Pith Info**
> - Pith Request Processor
> - [x] **Pith Responder**
> - Pith Router
>
> External Traits
> - Pith Problem Trait
> - Pith Run Trait
> - Pith Startup Trait
> - Pith Version Trait



Internal

> Internal Objects
> - Pith Access Level Factory
> - Pith App Helper
> - [x] **Pith Expression Utility**
> - Pith Problem Handler
> - Pith Problem List
> - Pith Request Helper
> - Pith Route
> - Pith State Enum
> - Pith State Machine
> - Pith String Utility
>
> Internal Traits
> - Pith App Reference Trait
> - [x] **Pith Get Object Class Directory Trait**
> 
> Internal Workflow Elements
> - [x] **Empty Action**
> - [x] **Empty Preparer**
> - [x] **Empty View Requisition**


Misc. Files

> - Index Front Controller
> - [x] **Constants file**
> - [x] **Routes file**
> - [x] **.serve.php file**


Misc. Plugins
> - Command Tool
> - Database Wrapper
> - Internal Access Levels
> - Internal Utilities
> - PHTML View Adapter
> - [x] **PHTML View Adapter 2**
> - Pith-dot-json

---

## Appendix C (WIP)
### List of Additions and Cleanups (WIP)

- Added 0.8 ToDo List.
- Added Engine Workflow Initiative Roadmap for 0.8 (This file).
- Added constants, Added Pith Info.
- Added Engine.
- Added Routes file.
- Added routing with FastRoute to replace old routing.
- Added new dispatching methods for Action object to Preparer object workflow.
- Added a 2nd .phtml adapter with new View logic


---

## Appendix D (WIP)
### Current Objects refactored to use the App Reference Trait (TODO)

External

> External Objects
> - [x] Pith Info
> - [x] Pith Engine
> - [x] Pith Router
> - [x] Pith Dispatcher
> - [x] Pith Responder

---

## Appendix E (WIP)
### Current Objects with PhpDoc comments (TODO)

External

> External Objects
> - [x] Pith Info

Internal

> Internal Traits
> - [x] Pith App Reference Trait


Misc. Files
> Initialization
> - [x] Index Front Controller
> - [x] Constants file

---

## Appendix F (WIP)
### Current Objects with images for PhpDoc comments (TODO)

---

## Next Steps

- Database workflow
- Unit Testing
- Integration Testing
- Database Migrations
- Access Levels