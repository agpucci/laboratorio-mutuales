<?php
namespace Core;
class Controller{
    protected function view($t,$d=[]){
        extract($d); $csrf=$_SESSION['csrf_token']??''; $appUrl=APP_URL; $appName=APP_NAME;
        include APP_ROOT.'/app/views/layout/header.php';
        include APP_ROOT.'/app/views/'.$t.'.php';
        include APP_ROOT.'/app/views/layout/footer.php';
    }
    protected function sanitize($s){ return trim((string)$s); }
    protected function requireFields(array $fields, array $data): array{
        $errors=[]; foreach($fields as $k=>$label){ if(!isset($data[$k]) || trim((string)$data[$k])===''){ $errors[$k]=$label.' es requerido'; } }
        return $errors;
    }

    protected function formatDate($dateString) {
        if (empty($dateString)) return '';
        $ts = strtotime($dateString);
        if (!$ts) return htmlspecialchars($dateString, ENT_QUOTES, 'UTF-8');
        return date('d-m-Y', $ts);
    }
}
