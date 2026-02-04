<?php
namespace NewdichAuth;
use NewdichSchema\Settings;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;
use PDOException;

class AppAuthorization{
    //private $userToken;
    private $user_id;
    private $role;
    private $expirationDate;
    private $authResponse;
    private $jwtSecret = Settings::AUTH_KEY;
    private $jwtKey = Settings::JWT_KEY;
    private $jwthash = Settings::JWT_HASH_ALGORITHM;

    public function __construct(){
        //$this->userToken = $userToken;
        if (!isset($_COOKIE[$this->jwtKey])) {
            http_response_code(401);
            $this->authResponse ="failed";
        }

        $headers = new \stdClass();
        $authenticatedKey = $_COOKIE[$this->jwtKey] ?? null;
        if(!$authenticatedKey){
            $this->authResponse ="failed";
        }
            
        try{
            $decodeToken = JWT::decode($authenticatedKey, new Key($this->jwtSecret, $this->jwthash), $headers);
            $this->user_id = $decodeToken->user_id;
            $this->role = $decodeToken->role;
            //$this->expirationDate = $decodeToken->exp;
            $this->authResponse ="success";
        }
        catch(ExpiredException $e){
            $this->authResponse ="Authorization token has expired, please relogin";
        }
        catch(Exception $e){
            $this->authResponse = $e->getMessage();
        }
    }

    public function authorize(){
        $arraySend = [
            "user_id"=>$this->user_id,
            "role"=>$this->role
        ];
        return json_encode(array("status"=>"success", "response"=>$arraySend), JSON_PRETTY_PRINT);
    }

}
?>