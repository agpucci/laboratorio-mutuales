<?php
namespace Core;
use PDO,PDOException;
class DB{
    private static ?PDO $pdo=null;
    public static function pdo():PDO{
        if(!self::$pdo){
            try{
                self::$pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET,DB_USER,DB_PASS,[
                    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
                ]);
            }catch(PDOException $e){ die('DB error: '.$e->getMessage()); }
        }
        return self::$pdo;
    }
}
