<?php
namespace NewdichMiddleware;

class Index{
    public function __construct(){

    }


    public function hashPassword(){

    }

    public function cleanData($data){
        return trim(htmlspecialchars($data));
    }
}
?>