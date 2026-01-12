<?php
namespace NewdichRoute;
//let apis request go to apis controller
//let app request go to app controller
//let src request go to src controler
$app ="/market";
$appController ="../Controller/AnsofraAppController.php";
$srcController ="../Controller/AnsofraSrcController.php";
if($url ===$app+"/" || $url === $app + "/index.html" || $url === $app + "/index.php" ){
    require_once __DIR__ .$appController+"?page=index";
}
?>