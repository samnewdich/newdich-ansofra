<?php
namespace NewdichControllerApp;
$currentDir = getcwd();
$app="/";
$previousDirectory = dirname($currentDir);
$appController = $previousDirectory.$app;
require_once $appController."/public/index.html";
?>