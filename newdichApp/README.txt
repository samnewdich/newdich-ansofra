ANSOFRA WAS DEVELOPED AND MAINTAINED BY NEWDICH TECHNOLOGY(A Software Engineering firm)
OFFICIAL WEBSITE: WWW.NEWDICH.TECH | SUPPORT EMAIL: NEWDICHNGR@GMAIL.COM | FACEBOOK: FACEBOOK.COM/NEWDICH
CREATED BY: SAMUEL IDEBI(A senior Software Engineer at NEWDICH TECHNOLOGY)
DESCRIPTION: ANSOFRA IS A FRAMEWORK THAT IS PERFECT FOR DEVELOPING ANY SOFTWARE.
THE NAME ANSOFRA IS AN ACRONYM OF THE PHRASE: ANY SOFTWARE FRAMEWORK(ANSOFRA)
IT FOLLOWS THE CQRS(COMMAND QUERY RESPONSIBILITY SEGREGATION) PATTERN WHICH IS A PERFECT ARCHITECTURE FOR BUILDING ANY SOFTWARE INCLUDING ENTERPRISE APPLICATIONS
IT MAKES MVP FASTER.
ANSOFRA SPEEDS UP DEVELOPMENT BY 60%
SOFTWARES BUILT WITH ANSOFRA FRAMEWORK ARE EASY TO MAINTAIN.
ANSOFRA ALLOWS A .NET DEVELOPER, JAVA DEVELOPER, C++ DEVELOPER TO EASILY GET ON AND EASILY BUILD IN PHP
TO USE ANSOFRA, YOU SHOULD HAVE A SOUND KNOWLEDGE IN CQRS ARCHITECTURE PATTERN.

BELOW ARE SOME DIRECTORIES AND FILES TO UNDERSTAND IN ANSOFRA.
index.php
    is the entry to the framework.
    it contains the autoload, it is where all request land before sending it to route

route
    The route directory contains an index.php file which receives the request sent from
    the landing index.php
    From the route directory, requests are then passed to the Controllers of
    the microservices in the apis directory, app directory, src directory.
    The namespace is NewdichRoute

apis
    This is the directory that contains microservices of API or third parties
    It contains an index.php file which is just a file for prevention
    It can contain microservices of other third parties APIs(Each microservice has Command, Controller, Query,)
    The namespace is NewdichApis

app
    The app directory is the backend for users and it contains all the app microservices of users on this project, 
    it is scannable on Swagger framework(that is it works with swagger)
    It contains a docs directory which is holds the JSON documentation(newdichapp.json) for Swagger framework
    It contains a swagger directory, the GUI for swagger documentation. This directory has an index.html file that can be loaded on a browser to show/see the API documentation for the whole app/ main directory
    It contains AppSpecification.php which is the file that contains the Info Details of the app/ swagger documentation
    It contains an index.php file, which is just an empty file(do not touch it).
    It can contain as many microservices as you want, for example, a default Account/ and Wallet/ microservices comes with it, which you may delete if you don't need it.
    The namespace is NewdichApp

Mail
    This is the directory for sending Emails.
    The namespace is NewdichMail
    it has a file Index.php which is the class that sends the mail

public
    The public folder is the directory for the FrontEnd
    It has an admin/ directory which is the FrontEnd for admins, this sends and receives requests and responses from the src/ directory
    It contains assets/ directory that stores all the static assets like images, videos, gifs, favicon, logos, etc..
    It contains css/ directory that stores the CSS styling codes
    It contains js/ directory that stores the JS codes
    index.html is the landing page to the FrontEnd(This is where all users to the app lands)

Schema
    The Schema directory houses everything about the Database and the settings of the software
    The Dealer.php file contains the server connection codes
    index.php is an empty file(do not touch)
    Migration.php contains Database Migration codes
    Platform.php contains the lists of Database tables and the table Ids
    Settings.php contains the software's configuration like port, ips, names, otp emails, etc..
    The namespace is NewdichSchema
    Settings.php class :
        The Settings.php class loads all the configuration of your software.
        Your can set the configuration in the Settings.php class directly or load it from the .env environment to the Settings.php class
        The settings of your server, hosting, cloud, etc, is loaded/set in the Settings.php class
    Dealer.php class :
        The Dealer.php class connects your software to your server user, host, databases
        The Dealer.php class uses the configuration in the Settings.php class to make the connection
    Platform.php class :
        The Platform.php class contains your Database Tables.
        If you need to create any table, Add it to the Platform.php class, then load it in the RunMigration.php class and execute the RunMigration.php class
    Migration.php class :
        The Migration.php class contains the SQL/Database logic which should only be called.
        Note: In the Migration.php class, the only thing you should change is the $rootDir variable value. change the value to the root directory of your project.
        To use the Migration.php class anywhere in your project, use it by adding use NewdichSchema\Migration to the file or class where you want to use it.
        After adding it to the file or class where you need it, you can then create an object of the Migration class and start calling the methods/functions on the object created.
        E.G
        To create new database, use the createDB() method in the Migration.php class
        Pass the name of the databse to the createDB()
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $dbName = Settings::SERVER_DB;
            $usersTable = Platform::USERS;
            $usersTableColumns = Platform::USERS_COLUMNS;
            $adminTable = Platform::ADMINS;
            $adminTableColumns = Platform::ADMINS_COLUMNS;
            
            $newMigration = new Migration(); //createDB does not need the arguments passed into the constructor
            echo $newMigration->createDB($dbName);
        
        To create new table, use the createTB() method in the Migration.php class
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $dbName = Settings::SERVER_DB;
            $usersTable = Platform::USERS;
            $usersTableColumns = Platform::USERS_COLUMNS;
            $adminTable = Platform::ADMINS;
            $adminTableColumns = Platform::ADMINS_COLUMNS;

            $newMigration = new Migration($adminTableColumns, $adminTable); //pass the table columns and the table name as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->createTB();

        To insert/create data into table uniquely. That is if you want to insert into table but want to be sure no double entry. for example in the case of creating user accoun. you know one email should not be created more than once!
        So to insert/create such data uniquely, use the saveUnique() method in the Migration.php class
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $usersTable = Platform::USERS;
            $uniqueColName ="email";
            $uniqueValue ="useremail@gmail.com";
            $rowsInKeyValue = [
                "email"=>"useremail@gmail.com",
                "fullname"=>"John Doe",
                "country"=>"Nigeria"
            ];
            //Note: the keys of the array must exist as column in the table

            $newMigration = new Migration(null, $adminTable); //No table columns needed so just put null, only the table name is needed as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->saveUnique($uniqueColName, $uniqueValue, $rowsInKeyValue);
        
        To insert/create data into table without uniqueness. That is you don't mind even if there are duplicates. example is saving history or transaction records.
        To do this, use the save() method in the Migration.php class 
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $usersTable = Platform::USERS;
            $uniqueColName ="email";
            $uniqueValue ="useremail@gmail.com";
            $rowsInKeyValue = [
                "email"=>"useremail@gmail.com",
                "fullname"=>"John Doe",
                "country"=>"Nigeria"
            ];
            //Note: the keys of the array must exist as column in the table

            $newMigration = new Migration(null, $adminTable); //No table columns needed so just put null, only the table name is needed as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->save($rowsInKeyValue);

        To select/fetch from table, use the get() method in Migration.php class
        The 3 arguments which are all OPTIONAL
        The first argument is the key=>value array of the condition to select
        The second argument is the offset, at which row should the selection start from.
        The third argument is the limit, the total number of rows to select/fetch
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $usersTable = Platform::USERS;
            $offset = 0;
            $limit = 50;
            $ConditionsInKeyValue = [
                "email"=>"useremail@gmail.com",
                "password"=>"123456"
            ];
            //Note: the keys of the array must exist as column in the table

            $newMigration = new Migration(null, $adminTable); //No table columns needed so just put null, only the table name is needed as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->get($ConditionsInKeyValue, $offset, $limit);

            So under the hood, what happens is:
            SELECT * FROM $adminTable Where email=:email AND password=:password
            bindParam(':email', 'useremail@gmail.com');
            bindParam(':password', '123456');

            //note the arguments are all optional, so you can have something like:
            $newMigration = new Migration(null, $adminTable); //No table columns needed so just put null, only the table name is needed as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->get();

        To delete row from database table, use the remove() method in Migration.php class
        It takes one argument which is an array of condition to use in deleting the rows.
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $usersTable = Platform::USERS;
            $offset = 0;
            $limit = 50;
            $ConditionsInKeyValue = [
                "email"=>"useremail@gmail.com",
                "password"=>"123456"
            ];
            //Note: the keys of the array must exist as column in the table

            $newMigration = new Migration(null, $adminTable); //No table columns needed so just put null, only the table name is needed as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->get($ConditionsInKeyValue);
            So under the hood, what happens is:
            DELETE FROM $adminTable Where email=:email AND password=:password
            bindParam(':email', 'useremail@gmail.com');
            bindParam(':password', '123456');
            //note: you must set the conditions for deleting the row.

        To update a row, use the edit() method in the Migration.php class.
        It takes 2 arguments, which are key=>value array of data to update, and the key=>value array of conditions to use in updating the row
        example
            use NewdichSchema\Migration;
            use NewdichSchema\Platform;
            use NewdichSchema\Settings;
            $usersTable = Platform::USERS;
            $updateDatakeyValue = [
                "fullname"=>"Samuel Idebi",
                "country"=>"Nigeria",
                "profession"=>"Software Engineering"
            ];
            //Note: the keys of the array must exist as column in the table

            $ConditionsInKeyValue = [
                "email"=>"useremail@gmail.com",
                "password"=>"123456"
            ];
            //Note: the keys of the array must exist as column in the table

            $newMigration = new Migration(null, $adminTable); //No table columns needed so just put null, only the table name is needed as contructor. check the Platform.php file to see how the table columns must be
            echo $newMigration->edit($updateDatakeyValue, $ConditionsInKeyValue);
            So under the hood, what happens is:
            UPDATE $adminTable SET fullname=:fullname, country=:country, profession=:profession Where email=:email AND password=:password
            bindParam(':fullname', 'Samuel Idebi');
            bindParam(':country', 'Nigeria');
            bindParam(':profession', 'Software Engineering');
            bindParam(':email', 'useremail@gmail.com');
            bindParam(':password', '123456');
            //note: you must set both the data array and the conditions array
    RunMigration.php class :
        Once you configure your server in the Settings.php class
        And you have connected it to server in the Dealer.php class
        And you have set your tables and their columns in the Platform.php class
        Make sure you have set $rootDir in the Migration.php class constructor
        Also set your $rootDir in route/index.php
        Also set your $usersArea and $adminArea in route/index.php
        You can then run migration to create all the Database structures
        To run migration, run this endpoint either on your browser or via an API call
            localhost/$rootDir/apiadmin/run_migration
            Where $rootDir is the root directory of your project. e.g / , /ecommerce, etc..
        IMPORTANT NOTICE, ONLY ADMIN/PERSON WITH RIGHT ACCESS SHOULD BE ALLOWED TO RUN Migration
        -FOR SECURITY REASON, YOU CAN REMOVE run_migration ROUTE IN THE route/index.php BY JUST REMOVING THIS LINE
            elseif($url === $adminArea."/run_migration"){
                //Running the migration will create the admin database with details
                require_once $srcController."/RunMigration.php";
                exit();
            }
        YOU CAN ALSO REMOVE THIS LINE FROM THE Controller/Src/RunMigration.php
            namespace NewdichControllerSrc;
            require_once $serverDir.$rootDir."/Schema/RunMigration.php";

WHAT TO SET/CHANGE 
    SET $rootDir, $usersArea, $adminArea INSIDE THE route/index.php TO MEET THE CORRECT ROOT DIRECTORY OF YOUR PROJECT
    SET $rootDir INSIDE THE Schema/Migration.php TO MEET THE CORRECT ROOT DIRECTORY OF YOUR PROJECT
    CONFIGURE YOUR Schema/Settings.php class

src
    The src/ directory is the backend for admins.
    It can contain all the microservices for admins only
    it is scannable on Swagger framework(that is it works with swagger)
    It contains a docs directory which is holds the JSON documentation(newdichsrc.json) for Swagger framework
    It contains a swagger directory, the GUI for swagger documentation. This directory has an index.html file that can be loaded on a browser to show/see the API documentation for the whole app/ main directory
    It contains SrcSpecification.php which is the file that contains the Info Details of the app/ swagger documentation
    It contains an index.php file, which is just an empty file(do not touch it)
    It can contain as many microservices as you want.
    The namespace is NewdichSrc

Auth
    The Auth/ directory contails the classes the Authenticates and Authorizes both Users and admins
    It contains AppAuthentication and AppAuthorization for Authenticating and Authorizing Users
    It contains SrcAuthentication and SrcAuthorization for Authenticating anf Authorizing admins
    NOTE: Authentication(wether for App or Src) should be called once the user or admin has been Queried(that is logged in)
    NOTE: Authorization should be run on any request from user or admin to required endpoints.

Controller
    The Controller/ directory controls the routing of the software
    It takes request to the appropriate class in the right microservice in either Command or Query
    It is where Middleware should be run on incoming or outgoing requests
    It has 2 subdirectories(App and Src) which controls app(users) and src(admins) routing
    The App/ subdirectory has 2 classes Index.php and AppLanding.php.
    The Index.php loads the index.html file of the public(which is the landing page)
    The AppLanding.php loads the swagger UI of the app/(users api)
    The Src/ subdirectory also has 2 classes Index.php and RunMigration.php
    The RunMigration.php loads and executes Database Migration.

Cache
    The Cache/ directory handles caching. It uses Redis for caching
    It has Setup.php which connects the to your redis server. Do not touch this file
    Note: make sure you have your redis installed on your server/machine and get the IP, Port, password
    Note: Open your .env file to update your redis server with the correct Ip, port, password.
    The Index.php class(Cache/Index.php) has methods you can use for caching and retrieveing:
    It has the following methods:
        setCache(): It is a method used to store cache, it takes 2 arguments, the key and the value to store.
            To use, include it in the file where you need it.
            example
            use NewdichCache\Index;
            $data ="data to save, it can be a string or an encoded array/object";
            $key ="mydata";
            $newobject = new Index();
            $newobject->setCache($key, $data);
        setExpireCache(): It is a method used to store cache with expiry time(in seconds), it takes 3 arguments, the key, the value to store and time in seconds.
            To use, include it in the file where you need it.
            example
            use NewdichCache\Index;
            $data ="data to save, it can be a string or an encoded array/object";
            $key ="mydata";
            $time = 60; //expires in 60 seconds
            $newobject = new Index();
            $newobject->setCache($key, $data, $time);
        setIncrease(): It is a method used to increase store values that are number(integer or float), it takes only 1 argument which is the key of the stored value
            To use, include it in the file where you need it.
            example
            use NewdichCache\Index;
            $key ="mynumber";
            $newobject = new Index();
            $newobject->setIncrease($key);
            //Note: you must have used setCache() or setExpireCache() to store the value before. And it must be number(integer or float).
        setDecrese(): It is a method used to decrease store values that are number(integer or float), it takes only 1 argument which is the key of the stored value
            To use, include it in the file where you need it.
            example
            use NewdichCache\Index;
            $key ="mynumber";
            $newobject = new Index();
            $newobject->setDecrease($key);
            //Note: you must have used setCache() or setExpireCache() to store the value before. And it must be number(integer or float).
        getCache(): It is a method used to retrieve stored values. it takes only 1 argument which is the key of the stored value
            To use, include it in the file where you need it.
            example
            use NewdichCache\Index;
            $key ="mynumber";
            $newobject = new Index();
            $newobject->getCache($key);
            //Note: you must have used setCache() or setExpireCache() to store the value before. 
Dto
    The Dto/ directory handles Data Transfer Object. It gets all the incoming data needed for computation
    Dto is passed through controller to the Classes where it's needed in the microservices in the command or queries
    It has 3 classes which are AnsofraApiDto.php, AnsofraAppDto.php, AnsofraSrcDto.php
    The AnsofraApiDto.php handles the incoming data needed in the /apis directory
    The AnsofraAppDto.php handles the incoming data needed in the /app directory
    The AnsofraSrcDto.php handles the incoming data needed in the /src directory

Middleware
    The Middleware/ directory has all functions and methods that could be run on incoming or outgoing requests
    It has a class Index.php that contains all the functions

vendor
    The vendor/ directory contains all installed PHP libraries usable in your project

composer.json
    This file contains list of all installed PHP libraries
    It also contains autoload namespace declaration(psr-4) and other important PHP setups in your project in a JSON format
    Note: whenever you make any changes to your composer.json, always dump composer by running:
        composer dump-autoload
composer.lock
    It contains the locked of the composer.json file

ansofra-generator.sh 
    This is a shell file that generates the swagger annotation JSON documentation into the docs/ directory of /app and /src respectively.
    After you have made any changes to your Swagger/OpenApi annotations endponts, you must execute this file by running:
        ./ansofra-generator.sh

USING ANSOFRA
TO USE ANSOFRA, YOU MUST INSTALL IT GLOBALLY ON YOUR DEVICE/MACHINE.
MAKE SURE YOU ALREADY HAVE composer INSTALLED.
THEN FOLLOW THESE STEPS.

STEP 1 : INSTALL ANSOFRA GLOBALLY
OPEN YOUR TERMINAL AND RUN:
    composer global require newdich/ansofra

STEP 2 : CONFIRM ANSOFRA IS INSTALLED
TO CONFIRM IT'S INSTALLED, OPEN YOUR TERMINAL AND RUN
    ansofra --version
YOU SHOULD SEE SOMETHING LIKE: ANSOFRA BY NEWDICH TECHNOLOGY
NOTE: IF YOU GET command not found ERROR, MAKE SURE TO ADD YOUR COMPOSER BIN TO YOUR ENVIRONMENT PATH

STEP 3 : CREATE YOUR PROJECT(APP/SOFTWARE) WITH ANSOFRA
NOW THAT YOU HAVE ANSOFRA INSTALLED ON YOUR MACHINE, YOU CAN NOW CREATE YOUR SOFTWARE FRAMEWORK WITH IT.
cd TO WHERE YOU WANT TO CREATE THE PROJECT AND RUN
    ansofra new name_of_your_project
EXAMPLE
    ansofra new myEcommerce
IT WILL CREATE A PROJECT NAMED myEcommerce WITH ALL THE ANSOFRA FRAMEWORKS(DIRECTORIES AND FILES) IN IT.
IT WILL ALSO START A SERVER AT http://localhost:8000
OPEN YOUR BROWSER AND LOAD https://localhost:8000 AND YOU SHOULD SEE THE ANSOFRA PAGE.
CONGRATULATIONS!! YOU CAN NOW START CODING AND USE..

STEP 4(OPTIONAL) : ALWAYS UPDATE YOUR ANSOFRA
WE REGULARLY MAINTAIN THE ANSOFRA FRAMEWORK, SO IT'S A GOOD PRACTICE TO ALWAYS UPDATE YOUR ANSOFRA ON YOUR MACHINE
TO UPDATE YOUR ANSOFRA, RUN
    composer global update newdich/ansofra