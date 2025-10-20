<?php
namespace Models;
use Core\DB;
class Auditoria{
    public static function add(string $action, string $table, int $record_id, int $user_id=null){
        $pdo = DB::pdo();
        $st = $pdo->prepare('INSERT INTO auditoria (action,table_name,record_id,user_id,created_at) VALUES (?,?,?,?,NOW())');
        $st->execute([$action,$table,$record_id,$user_id]);
    }
    public static function all(): array{
        $pdo = DB::pdo();
        $q = $pdo->query('SELECT id,action,table_name,record_id,created_at FROM auditoria ORDER BY created_at DESC LIMIT 200');
        return $q->fetchAll();
    }
}
