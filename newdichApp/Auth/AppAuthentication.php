<?php
namespace NewdichAuth;
use NewdichSchema\Settings;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;
use PDOException;

 class AppAuthentication{
    private $jwtSecret = Settings::AUTH_KEY;
    private $domain = Settings::DOMAIN_NAME;

    public function auth($email){
        if($email !==''){            
            //NOW authorize $jwtSecret 
            $authPayload = [
                'iss'=>$this->domain, //provided in the tables file
                'aud'=>$this->domain,
                'iat'=>time(),
                //'exp'=>time() + (24 * 60 * 60),
                'user_id'=>trim($email),
                'role'=>'user'
            ];
            $authhash = JWT::encode($authPayload, $this->jwtSecret, 'HS256');
            return json_encode(array("status"=>"success", "response"=>$authhash), JSON_PRETTY_PRINT);
        }
        else{
            //you can modify to add any role you want during authentication
            return json_encode(array("status"=>"failed", "response"=>"user_id not provided"), JSON_PRETTY_PRINT);
        }
    }
 }
?>