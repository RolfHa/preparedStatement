<?php

abstract class Dbconn
{
    public static function getConn():PDO
    {
        return  new PDO("mysql:host=".SERVERNAME.";dbname=".
            DB_NAME, USERNAME, PASS);
    }
}