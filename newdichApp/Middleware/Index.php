<?php
namespace NewdichMiddleware;

class Index{
    public function __construct(){

    }

    public function getIp(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }


    public function hashData($data){
        $hash = password_hash($data, PASSWORD_BCRYPT);
        return $hash;
    }

    public function verifyHash($data, $hash){
        return password_verify($data, $hash); //returns a boolean
        
    }

    public function cleanData($data){
        return trim(htmlspecialchars($data));
    }

    public function otp(){
        $otp = strtotime(date("Y-m-d H:i:s"));
        $otp = sprintf("%u", crc32($otp.$this->getIp()));
        $otp = substr($otp, 0, 6);
        return $otp;
    }
}
?>