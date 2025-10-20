<?php
namespace Models;
use Core\DB;
class Sugerencia{
    public static function create(int $mutual_id, int $user_id, string $texto){
        $pdo = DB::pdo();
        $st = $pdo->prepare('INSERT INTO sugerencias (mutual_id,user_id,texto,created_at) VALUES (?,?,?,NOW())');
        $st->execute([$mutual_id,$user_id,$texto]);
    }
    public static function all(): array{
        $pdo = DB::pdo();
        $q = $pdo->query('SELECT s.id,s.texto,s.created_at,u.username,m.name as mutual_name FROM sugerencias s LEFT JOIN usuarios u ON u.id=s.user_id LEFT JOIN mutuales m ON m.id=s.mutual_id ORDER BY s.created_at DESC');
        return $q->fetchAll();
    }
    public static function delete(int $id){
        $pdo = DB::pdo();
        $st = $pdo->prepare('DELETE FROM sugerencias WHERE id=?'); $st->execute([$id]);
    }
}
