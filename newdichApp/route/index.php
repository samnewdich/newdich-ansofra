<?php
namespace NewdichRoute;
$serverDir = $_SERVER["DOCUMENT_ROOT"]; //server directory
//let apis request go to apis controller
//let app request go to app controller
//let src request go to src controler
$rootDir ="/"; //the root directory of the project
//$rootDir can be / and it can be something like /vtu
//for example, let's say you have one server/host and you have many project in it.
//Example, in your localhost(/var/www/html), let's say you have 3 different projects:
//ecommerce, vtu, fintech.
//inside your localhost(/var/www/html), you will have
// var/www/html/ecommerce
// var/www/html/vtu
// var/www/html/fintech
//so, for ecommerce, the root directory is /ecommerce
//for vtu, the root directory is /vtu and for fintech the root directory is /fintech
//and if it is only one project you have, and the one project is inside (/var/www/html)
// then the root directory will be /
$usersArea ="/api"; //the area that users can access
// let's say your root directory is / . Then the usersArea will be /api
// if your root directory is /ecommerce, your usersArea will be /ecommerce/api
// if your root directory is /vtu, your usersArea will be /vtu/api
$adminArea ="/apiadmin"; //the area that only admin can access
// let's say your root directory is /, your adminArea will be /apiadmin
// if your root directory is /ecommerce, your adminArea will be /ecommerce/apiadmin
$appController = $serverDir.$rootDir."/Controller/App";
$srcController = $serverDir.$rootDir."/Controller/Src";
if($url === $rootDir || $url === $rootDir . "/" || $url === $rootDir . "/index.html" || $url === $rootDir . "/index.php"){
    require_once $appController."/Index.php";
    exit();
}
elseif($url === $usersArea || $url === $usersArea . "/"){
    require_once $appController."/AppLanding.php";
    exit();
}
elseif($url === $adminArea."/run_migration"){
    //Running the first migration will create the admin database with details
    require_once $srcController."/RunMigration.php";
    exit();
}
?>