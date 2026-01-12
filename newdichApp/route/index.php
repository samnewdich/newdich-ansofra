<?php
namespace NewdichRoute;
//let apis request go to apis controller
//let app request go to app controller
//let src request go to src controler
$app ="/";
$currentDir = getcwd();
$previousDirectory = dirname($currentDir);
$appController = $previousDirectory.$app."/Controller/App";
$srcController = $previousDirectory.$app."/Controller/Src";
if($url ===$app."/" || $url === $app."/index.html" || $url === $app."/index.php" ){
    require_once $appController."/Index.php";
}
?>