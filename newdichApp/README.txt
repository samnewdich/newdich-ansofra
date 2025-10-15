index.php
    is the entry to the framework.
    it contains the autoload, it is where all request land before sending it to route

route
    The route directory contains an index.php file which receives the request sent from
    the landing index.php
    From the route directory, requests are then passed to the Controllers of
    the microservices in the apis directory, app directory, src directory.

apis
    This is the directory that contains microservices of API or third parties
    It contains an index.php file which is just a file for prevention
    It contains a DTO directory for Data Transfer Objects(stored in ApisDTO.php) of these third parties APIs
    It can contain microservices of other third parties APIs(Each microservice has Command, Controller, Query,)

app
    The app directory contains all the apis microservices of users on this project, 
    it is scannable on Swagger framework(that is it works with swagger)
    It contains the Auth directory for Authentication and Authorization
    It contains the Cache directory for In-Memory(RAM) services like Redis or Memchache
    It contains a docs directory which is holds the JSON documentation for Swagger framework
    It contains a DTO directory for Data Transfer Objects(AnsofraAppDto.php)
    It

