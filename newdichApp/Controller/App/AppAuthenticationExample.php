<?php
namespace NewdichControllerApp;
use NewdichAuth\AppAuthentication;
use NewdichDto\AnsofraAppDto;
use NewdichMiddleware\Index;

$newMiddleware = new Index();

$incomingRequest = json_decode(file_get_contents("php://input"), true);
$email = $incomingRequest["email"];
$cleanEmail = $newMiddleware->cleanData($email);

$newAuth = new AppAuthentication();
$auth = $newAuth->auth($cleanEmail);
echo $auth; //returns an encoded array of ["status"=>"failed or success", "response"=>"hashed token or error response"]
exit;
?>