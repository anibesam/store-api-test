<?php

use \Firebase\JWT\JWT;

class JwtHelper
{
    private static $secretKey = "your_secret_key"; // Change this to a secure key
    private static $algorithm = "HS256";

    public static function encode($data)
    {
        return JWT::encode($data, self::$secretKey, self::$algorithm);
    }

    public static function decode($jwt)
    {
        return JWT::decode($jwt, self::$secretKey, [self::$algorithm]);
    }
}
