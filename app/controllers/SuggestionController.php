<?php
namespace Controllers;
use Core\Controller;

class SuggestionController extends Controller
{
    public function index() {
        $items = \Models\Suggestion::recentOpen(50);
        if (!$items) { // fallback para evitar listado en blanco si por algun motivo no coincide el estado
            $items = \Models\Suggestion::recentAll(50);
        }
        $this->view('suggestions/index', ['items' => $items, 'title' => 'Sugerencias']);
    }
    public function add() {
        $mutualId = (int)($_POST['mutual_id'] ?? 0);
        $content  = $this->sanitize($_POST['content'] ?? '');
        if ($mutualId <= 0 || $content === '') {
            header('Location: ' . \APP_URL . '/mutuales/view?id='.$mutualId.'&err=1#sugerencias'); exit;
        }
        \Models\Suggestion::add($mutualId, (int)($_SESSION['user']['id'] ?? 0), $content);
        header('Location: ' . \APP_URL . '/mutuales/view?id='.$mutualId.'#sugerencias'); exit;
    }
    public function close() {
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'RESUELTA';
        if (!in_array($status, ['RESUELTA','RECHAZADA'], true)) $status = 'RESUELTA';
        $note   = $this->sanitize($_POST['resolver_note'] ?? '');
        \Models\Suggestion::close($id, $status, (int)($_SESSION['user']['id'] ?? 0), $note);
        $back = $_POST['back'] ?? (\APP_URL.'/sugerencias');
        header('Location: '.$back); exit;
    }

    public function delete()
    {
        // Solo ADMIN
        if (empty($_SESSION['user']) || (($_SESSION['user']['role'] ?? '') !== 'ADMIN')) {
            http_response_code(403);
            exit('No autorizado');
        }

        // Verificacion CSRF
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(400);
            exit('Solicitud invalida');
        }

        // ID sugerencia
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            http_response_code(400);
            exit('ID invalido');
        }

        // Eliminar (tabla mutual_suggestions)
        try {
            \Models\Suggestion::delete($id);
            header('Location: ' . \APP_URL . '/sugerencias');
            exit;
        } catch (\Throwable $e) {
            http_response_code(500);
            exit('Error al eliminar: ' . htmlspecialchars($e->getMessage()));
        }
    }
}
