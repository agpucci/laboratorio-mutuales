<?php
namespace Core;
use Core\DB;
class Auth{
    public static function attempt($u,$p):bool{
        $q=DB::pdo()->prepare('SELECT id,username,password_hash,role FROM users WHERE username=? LIMIT 1');
        $q->execute([$u]); $r=$q->fetch(); if(!$r) return false;
        if(hash('sha256',$p)!==$r['password_hash']) return false;
        $_SESSION['user']=['id'=>$r['id'],'username'=>$r['username'],'role'=>$r['role']];
        session_regenerate_id(true); return true;
    }
    public static function logout(){ $_SESSION=[]; session_destroy(); }
}
