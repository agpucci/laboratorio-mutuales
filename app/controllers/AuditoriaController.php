<?php
namespace Controllers;
use Core\Controller;
use Models\Auditoria;
class AuditoriaController extends Controller{
    public function index(){ $this->requireAuth(); $items=Auditoria::all(); $this->view('auditoria/index',['items'=>$items,'title'=>'Log de cambios']); }
}
