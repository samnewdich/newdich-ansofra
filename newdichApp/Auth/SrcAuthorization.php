<?php
namespace NewdichAuth;
use NewdichSchema\Settings;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Exception;
use PDO;
use PDOException;

class SrcAuthorization{
    private $userToken;
    private $user_id;
    private $role;
    private $expirationDate;
    private $authResponse;
    private $jwtSecret = Settings::AUTH_KEY;

    public function __construct($userToken){
        $this->userToken = $userToken;
        $headers = new \stdClass();
        try{
            $decodeToken = JWT::decode($this->userToken, new Key($this->jwtSecret, 'HS256'), $headers);
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
        if($this->role ==='admin'){
            return json_encode(array("status"=>"success", "response"=>$this->authResponse), JSON_PRETTY_PRINT);
        }
        else{
            //you can modify to add any role you want during authentication
            return json_encode(array("status"=>"failed", "response"=>"access denied and".$this->user_id), JSON_PRETTY_PRINT);
        }
    }

}
?>