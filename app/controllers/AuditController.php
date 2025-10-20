<?php
namespace Controllers;
use Core\Controller;

class AuditController extends Controller
{
    public function recent() {
        $items = \Models\Audit::recent(50);
        $this->view('audit/recent', ['items' => $items, 'title' => 'Log de cambios (global)']);
    }
    public function forMutual() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) { http_response_code(400); echo 'ID inválido'; return; }
        $items = \Models\Audit::forMutual($id, 50);
        $this->view('audit/for_mutual', ['items' => $items, 'mutual_id' => $id, 'title' => 'Cambios de la mutual']);
    }
}
