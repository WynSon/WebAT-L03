<?php

class DBconnect{

    

    public function getconn(){
        global $db_name;
        $db_name = "facademy";
        $db_host = "localhost";
        $db_user = "spider";
        $db_pass = "spider";

        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

        try{
            return new PDO($dsn,$db_user, $db_pass);
        }catch (PDOException $e) {
            die ("Can't connect: ".$e->getMessage());
        }
    }
}

?>