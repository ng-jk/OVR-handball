<?php
namespace App\Libraries;
class Password
{
    public static function make($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    public static function check($password,$db_hash_password)
    {
        if(password_verify($password,$db_hash_password)){
            return true;
        }else{
            return false;
        }

    }
}