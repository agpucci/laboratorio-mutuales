<?php
namespace Controllers;
use Core\Controller;
use Models\Sugerencia;
class SugerenciasController extends Controller{
    public function index(){ $this->requireAuth(); $items=Sugerencia::all(); $this->view('sugerencias/index',['items'=>$items,'title'=>'Sugerencias']); }
    public function create(){
        $this->requireAuth(); $this->checkCsrf();
        $mutual_id=(int)($_POST['mutual_id']??0);
        $texto=$this->sanitize($_POST['texto']??'');
        $user_id=(int)($_SESSION['user']['id'] ?? 0);
        if($mutual_id && $texto){ Sugerencia::create($mutual_id,$user_id,$texto); }
        header('Location: '.$GLOBALS['appUrl'].'/sugerencias');
    }
    public function delete(){
        $this->requireAuth(); $this->checkCsrf();
        if(($_SESSION['user']['role']??'')!=='ADMIN'){ http_response_code(403); echo 'Solo admin'; return; }
        $id=(int)($_POST['id']??0);
        if($id) Sugerencia::delete($id);
        header('Location: '.$GLOBALS['appUrl'].'/sugerencias');
    }
}
