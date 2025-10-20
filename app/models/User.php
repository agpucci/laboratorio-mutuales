<?php
namespace Models;
use Core\DB;
class User{
    public static function create($u,$p,$r='ADMIN'){
        $h=hash('sha256',$p);
        $q=DB::pdo()->prepare('INSERT INTO users (username,password_hash,role,created_at) VALUES (?,?,?,NOW())');
        $q->execute([$u,$h,$r]); return (int)DB::pdo()->lastInsertId();
    }
}
