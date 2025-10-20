<?php
namespace Controllers;
use Core\Controller;

class SuggestionController extends Controller
{
    public function index() {
        $items = \Models\Suggestion::recentOpen(50);
        if (!$items) { // fallback para evitar listado en blanco si por algún motivo no coincide el estado
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
}
