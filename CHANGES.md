#NEXT TARGET
##Development Concept:
- Modelling the Proxy for old-devosa
- Modelling the DMS (Document Management System)

##Programming:
- Finish the routing library
- Updating old-files so can applied with "bridge-framework"

##Infrastructure:
- Finishing Git Hooks
- Create Test-Build Server 
- Create Deployment Server

##Team Collaboration:
- Watch and monitor issue tracker and project management system activity
- Start to create git system for development environment
- Training day: saturday 10.00-15.00
    - Core programming concepts (OOP)
    - How to implement daily code standard and programming convention 

#CODE CHANGES
##Changes on 22-26/04/2016
- Finishing the storage adapter library.
- Started to work on routing library

##Changes on 18/04/2016
- Modify composer.json file
    - Customize the autoloader:
        - Changes the root namespace to "Bridge"
        - Add the files autoloader: `function.inc.php`
    - Add some composer configuration: optimize-autoloader, secure-http
    - For next improvement to add the classmap 
        `"classmap": ["application/devosa/plugins","application/devosa/libraries/classes"]`
- Modify core library class
    - Finishing the final concept model for filesystem library.
    - Rename the IniParser class to IniReader
    - Add Gui element handler components
    - Modify the kernel system core class flow to separate the production installation and development use. 
    - Modify the application class library: added property that will completely act as a general application

#RULES AND CODE CONVENTIONS
##RESERVED & ALLOWED WORD FOR METHOD (12/04/2016)
###Some Exceptional for core system class libraries (application, system, kernel)
- shutdown
- up
- down
- boot
- restart
- run
- register

###Allowed Prefixes (12/04/2016)
- do: void
- get: ROT
- set: void
- run: void
- init: void
- make: ROT
- is: boolean
- fetch: array
- validate: boolean
- check: boolean
- update: boolean
- remove: boolean
- kill: boolean
- load: void
- reload: void
- log: void
- create: boolean
- put: boolean
- open: boolean
- prepend: ROT
- append: ROT
- list: array
- has: boolean

###Adding some allowed prefix on 25/04/2016
- attach: void
- detach: void
- resolve: ROT
- read: void
- render: string
- view: string
- apply: void
- write: boolean
- find: ROT
- search: array

###Design Patterns that will be used
- Adapter: Storage library
- Singleton: Kernel
- Proxy: 
- Builder:
- Factory Method: 
- Observer: 
- Decorator: 
- Registry: 

#DIRECTORY CHANGES:
##Changes on 25/04/2016
- Restructuring the application modules, so all of them will be more modular and 
    - All modules for example "HR" will be on good directory structure that applied below patterns:
        - Php files under modules will be moved to src directory
        - All static content under modules will be moved to assets directory


##Changes on 22/04/2016
- Create src folder as the php source code folder
- Move the all the devosa application module to src folder
- Move the bridge core library framework to src/system/core
- Move the application/function.inc.php to src/function.inc.php

##Changes on 12/04/2016

- Deleted changepwd_2.php on public dir
- Deleted background.jpg cause has been existsed on img dir under asset folder.
- Move all the files under public directory (exclude: favicon.jpg, index.php) to application/modules/root
- Remove the ark-admin template folder 
- Move config folder on root-dir into application directory (application/config) there will be divide general (for app) and server
- Rename bin/sql/start to bin/sql/setup and move the base backup to folder setup/base
- Move application/helper to application/libraries/helper
- Updating .gitignore and .gitattributes for old-devosa 
- Separate development and deployment directory for binary/executed command files.
- Create .htaccess for root directory, please read the description for each section, and change the default directory index to public/index.php 
- Added composer.json files so after pull up/checkout from the repository please do composer install/update
- Create core library for old-devosa-bridge, like reader, system (kernel, loader, proxy, route)
- Move index.php on public directory to application/modules/root/index.php
- Restructure all modules, so it should be on good directory pattern
    - All public resources like: js, css, images will be moved into assets
    - Create new directory named as "resources" that will be contain the application resources like: templates, file upload
    - All php modules files will be moved into "src" directory
- Move global application templates, and language dir to resources/application/

##Changes on 11/04/2016
###Create new directory:
- bin directory to store all hooks script, and runtime script under server
 tmp directory to store application log, cache, sessions
- resources directory to store all resource that will be used/resulted by application eg: upload, templates, languages

###Moving directory:
- adm      : application/modules/base/adm
- ga       : application/modules/base/ga
- hrd      : application/modules/base/hrd
- export   : application/modules/base/export
- classes  : application/libraries/classes
- includes : application/plugins

all files under root directory moved to public directory.

###Renaming directory:
- asset renamed to assets
- css    : assets/public/css
- images : assets/public/img
- js     : assets/public/js
- canvasjs : assets/vendor/canvasjs

###Global directory changes:
- all files under global move to: application/helper
- all directory under global dir move to: application/plugins

###Deleted directory/files
- doc directory deleted
- global directory deleted
- log directory that contain database app error deleted
- report directory deleted
- err_log, php.ini files under root directory deleted
