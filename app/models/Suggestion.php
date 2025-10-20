<?php
namespace Models;
use Core\DB;

class Suggestion {
    public static function add(int $mutualId, int $userId, string $content): int {
        $pdo = DB::pdo();
        $q = $pdo->prepare('INSERT INTO mutual_suggestions (mutual_id,user_id,content) VALUES (?,?,?)');
        $q->execute([$mutualId, $userId, $content]);
        return (int)$pdo->lastInsertId();
    }
    public static function listByMutual(int $mutualId): array {
        $pdo = DB::pdo();
        $q = $pdo->prepare('SELECT s.*, u.username FROM mutual_suggestions s JOIN users u ON u.id=s.user_id WHERE s.mutual_id=? ORDER BY s.id DESC');
        $q->execute([$mutualId]);
        return $q->fetchAll();
    }
    public static function recentOpen(int $limit = 50): array {
        $pdo = DB::pdo();
        $q = $pdo->prepare("SELECT s.*, m.name AS mutual_name, u.username
                            FROM mutual_suggestions s
                            JOIN mutuales m ON m.id=s.mutual_id
                            JOIN users u ON u.id=s.user_id
                            WHERE s.status='ABIERTA'
                            ORDER BY s.id DESC LIMIT ?");
        $q->bindValue(1, $limit, \PDO::PARAM_INT);
        $q->execute();
        return $q->fetchAll();
    }
    public static function recentAll(int $limit = 50): array {
        $pdo = DB::pdo();
        $q = $pdo->prepare("SELECT s.*, m.name AS mutual_name, u.username
                            FROM mutual_suggestions s
                            JOIN mutuales m ON m.id=s.mutual_id
                            JOIN users u ON u.id=s.user_id
                            ORDER BY s.id DESC LIMIT ?");
        $q->bindValue(1, $limit, \PDO::PARAM_INT);
        $q->execute();
        return $q->fetchAll();
    }
    public static function close(int $id, string $status, int $resolverId, ?string $note): void {
        $pdo = DB::pdo();
        $q = $pdo->prepare('UPDATE mutual_suggestions SET status=?, resolver_id=?, resolver_note=?, resolved_at=NOW() WHERE id=?');
        $q->execute([$status, $resolverId, $note, $id]);
    }
}
