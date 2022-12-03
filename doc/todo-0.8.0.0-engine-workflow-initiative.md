
> [All ToDo Lists](todo-index.md)
---

# Engine Workflow Initiative Roadmap for 0.8


---


## General

> Fixup:
> - [x] Add PhpDoc comments
> - [ ] PhpDoc comments in PhpStorm can display pictures now. Add documentation pictures.
> 
> Refactor:
> - [x] Refactor objects to use the App Reference Trait.

## Pith Info

> Add:
> - [x] Meta Object (Internal, with framework version info, legal info.)
> - [x] Info Object `$this->app->info` (External, with methods that talk to Meta Object, but also app info, and info from the pith.json file.)
> 
> Edit:
> - [x] The Info Object should be accessible from `$this->app->info`
> 
> Cleanup / refactor at the end:
> - [x] Remove the Version Trait

## Config
> Add:
> - [x] Add simple Constants file.
> - [x] New Config system.
>
> Cleanup / refactor at the end:
> - [x] Remove the current Config.
> - [x] Remove the Config Profiles.

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
> - [x] Remove the Startup Trait
> - [x] Remove the Run Trait

## Routing

> Add to Engine
> - [x] Do routing with FastRoute (Figure out how to keep our 2-level routing, and how to dynamically add/remove routes. Cache routes, to array?)
> 
> Cleanup / refactor at the end:
> - [x] Remove the current Router. *--- (Router is all the new Routing implementation with FastRoute now)*



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
> - [x] Remove the current Problem calls.
> - [x] Remove the Problem trait.
> - [x] Remove the Problem Handler

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

> About:
> - [x] **Pith Meta**
> 
> External Extendable:
> - Pith Access Level
> - [x] **Pith Action**
> - ~~Pith Controller~~
> - [x] **Pith Pack**
> - [x] **Pith Preparer**
> - Pith Query
> - [x] **Pith Route**
> - [x] **Pith Route List**
> - [x] **Pith View Requisition**
> - [x] **Pith Workflow Element**
>
> External Interfaces
> - ~~Pith App Interface~~
> - ~~Pith Config Interface~~
> - ~~Pith Controller Interface~~
> - ~~Pith Module Interface~~
> - ~~Pith Router Interface~~
>
> External Objects
> - Pith Access Control
> - Pith App
> - Pith Config
> - [x] *Pith Database Wrapper* (Moved)
> - Pith Dispatcher
> - [x] **Pith Engine**
> - [x] **Pith Exception**
> - [x] **Pith Info**
> - ~~Pith Request Processor~~
> - [x] **Pith Responder**
> - Pith Router
>
> External Traits
> - ~~Pith Problem Trait~~
> - ~~Pith Run Trait~~
> - ~~Pith Startup Trait~~
> - ~~Pith Version Trait~~



Internal

> Internal Objects
> - ~~Pith Access Level Factory~~
> - Pith App Helper
> - [x] *Pith Array Utility* (Moved)
> - [x] *Pith Database Wrapper Helper* (Moved)
> - [x] *Error Utility* (Moved)
> - [x] **Pith Escape Utility**
> - [x] **Pith Expression Utility**
> - ~~Pith Problem Handler~~
> - ~~Pith Problem List~~
> - ~~Pith Request Helper~~ *(Converted to URI Utility)*
> - ~~Pith Route~~
> - [x] *Pith Rowset Array Utility* (Moved)
> - ~~Pith State Enum~~
> - ~~Pith State Machine~~
> - Pith String Utility
> - [x] **Pith URI Utility** *(From old Pith Request Helper)*
>
> Internal Traits
> - Pith App Reference Trait
> - [x] **Pith Get Object Class Directory Trait**
> 
> Internal Workflow Access Levels
> - [x] **World Access Level**
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
> - ~~*Database Wrapper*~~ (Moved)
> - ~~Internal Access Levels~~
> - ~~*Internal Utilities*~~ (Moved)
> - ~~PHTML View Adapter~~
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
### Current Objects refactored to use the App Reference Trait

(All Done)

---

## Appendix E (WIP)
### Current Objects with PhpDoc comments

(All Done)

---

## Appendix F (WIP)
### Current Objects with images for PhpDoc comments (TODO)

(TODO)

---

## Next Steps

- Database workflow
- Unit Testing
- Integration Testing
- Database Migrations
- Access Levels