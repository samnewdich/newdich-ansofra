<?php
namespace NewdichAuth;
use NewdichSchema\Settings;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;
use PDOException;

 class AppAuthentication{
    private $jwtSecret = Settings::AUTH_KEY;
    private $jwtKey = Settings::JWT_KEY;
    private $jwtExpiry = Settings::JWT_EXPIRY;
    private $jwtSecureLevel = Settings::JWT_SECURE_LEVEL;
    private $jwtSameSite = Settings::JWT_SAMESITE;
    private $jwthash = Settings::JWT_HASH_ALGORITHM;
    private $domain = Settings::DOMAIN_NAME;
    private $rootdir = Settings::ROOT_DIRECTORY;

    public function auth($email){
        if($email !==''){            
            //NOW authorize $jwtSecret 
            $authPayload = [
                'iss'=>$this->domain, //provided in the tables file
                'aud'=>$this->domain,
                'iat'=>time(),
                'exp'=>time() + $this->jwtExpiry,
                'user_id'=>trim($email),
                'role'=>'user'
            ];
            $authhash = JWT::encode($authPayload, $this->jwtSecret, $this->jwthash);
            //set it into cookie
            setcookie($this->jwtKey, $authhash, [
                "expires"=> time() + $this->jwtExpiry,
                "path" => $this->rootdir,
                "secure" => $this->jwtSecureLevel,
                "httponly" => true,
                "samesite" => $this->jwtSameSite
            ]);
            return json_encode(array("status"=>"success", "response"=>$authhash), JSON_PRETTY_PRINT);
        }
        else{
            //you can modify to add any role you want during authentication
            return json_encode(array("status"=>"failed", "response"=>"user_id not provided"), JSON_PRETTY_PRINT);
        }
    }
 }
?>