<?php
namespace Core;

class Router{
    private array $r=['GET'=>[],'POST'=>[]];

    public function get($p,$h,$a=false,$roles=[]){ $this->r['GET'][$p]=[$h,$a,$roles]; }
    public function post($p,$h,$a=false,$roles=[]){ $this->r['POST'][$p]=[$h,$a,$roles]; }

    private function norm($u){
        $b=rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '')),'/');
        if($b && strpos($u,$b)===0) $u=substr($u,strlen($b));
        return $u ?: '/';
    }

    public function dispatch(){
        $m = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $u = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        $u = $this->norm($u);

        if(!isset($this->r[$m][$u])){ http_response_code(404); echo '404'; return; }

        [$h,$auth,$roles] = $this->r[$m][$u];
        [$c,$f] = explode('@',$h);
        $cls = 'Controllers\\'.$c;

        $o = new $cls();

        if($auth){
            if(empty($_SESSION['user'])){ header('Location: '.APP_URL.'/login'); exit; }
            if($roles){
                $role = $_SESSION['user']['role'] ?? 'VIEWER';
                if(!in_array($role,$roles)){ die('Acceso denegado'); }
            }
        }

        if($m==='POST'){
            if(!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')){ die('CSRF'); }
        }

        if($f==='view' && method_exists($o,'ver')){ $f='ver'; }

        if(!method_exists($o,$f)){ http_response_code(404); echo 'Acción no encontrada'; return; }

        $o->$f();
    }
}
