<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWT_CLASS
{
    public static function createToken ($emailId, $userId): string
    {
        $KEY = env('TOKEN_KEY');
        $payload = [
            'iss' => 'Laravel Token',
            'iat' => time(),
            'exp' => time()+60*60*24,
            'email' => $emailId,
            'id' => $userId
        ];
        return JWT::encode($payload,$KEY,'HS256');

    }

    public static function VerifyToken ($token): string | object
    {
        try {
            if ($token == null){
                return "unauthorized";
            }else{
                $KEY = env('TOKEN_KEY');
                return  JWT::decode($token,new Key($KEY,'HS256'));

            }
        }catch (Exception $exception){
            return "unauthorized";
        }

    }

}
