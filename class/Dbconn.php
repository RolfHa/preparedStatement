<?php

abstract class Dbconn

{

    public static function getConn():PDO
    {
        $servername = "localhost";
        $username = "root";
        $pass = "";
        $dbname = "preparedstatement";
        return  new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);

    }
}