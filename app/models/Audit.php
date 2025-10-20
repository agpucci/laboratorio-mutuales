<?php
namespace Models;
use Core\DB;
class Audit{
    public static function log(int $userId, string $table, int $recordId, string $action, $old, $new): void {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare('INSERT INTO audit_logs (user_id, table_name, record_id, action, old_value, new_value, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$userId, $table, $recordId, $action, $old, $new]);
    }
    public static function recent(int $limit = 50): array {
        $pdo = DB::pdo();
        $q = $pdo->prepare('SELECT id, user_id, table_name, record_id, action, old_value, new_value, created_at FROM audit_logs ORDER BY id DESC LIMIT ?');
        $q->bindValue(1, $limit, \PDO::PARAM_INT);
        $q->execute(); return $q->fetchAll();
    }
    public static function forMutual(int $mutualId, int $limit = 50): array {
        $pdo = DB::pdo();
        $q = $pdo->prepare('SELECT id, user_id, action, old_value, new_value, created_at FROM audit_logs WHERE table_name="mutuales" AND record_id=? ORDER BY id DESC LIMIT ?');
        $q->bindValue(1, $mutualId, \PDO::PARAM_INT);
        $q->bindValue(2, $limit, \PDO::PARAM_INT);
        $q->execute(); return $q->fetchAll();
    }
}
