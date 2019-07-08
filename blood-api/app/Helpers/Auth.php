<?php
namespace App\Helpers;

use App\Token;

class Auth
{

    public static $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generateRandomString($length = 10)
    {
        $characters = self::$characters;

        $charactersLength = strlen($characters);

        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getTokenValidity(string $token)
    {

        try {
            $activeToken = Token::where('token', $token)->first();

            $date = new \DateTime("{$activeToken->created_at}");
            $now = new \DateTime();

            $difference_in_seconds = $date->format('U') - $now->format('U');

            if ($difference_in_seconds >= $activeToken->ttl) {
                return false;
            }

            return true;
        } catch (\Throwable $th) {
            return false;
        }

    }
}
