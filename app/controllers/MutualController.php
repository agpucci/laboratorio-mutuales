<?php
namespace Controllers;
use Core\Controller;

class MutualController extends Controller{
    private function collectData(): array {
        $receta = $_POST['receta'] ?? [];
        if (!is_array($receta)) $receta = [];
        return [
            'name'=>$this->sanitize($_POST['name']??''),
            'paga_coseguro'=>isset($_POST['paga_coseguro'])?1:0,
            'detalle_coseguro'=>$this->sanitize($_POST['detalle_coseguro']??''),
            'description'=>$this->sanitize($_POST['description']??''),

            'codigos'=>$this->sanitize($_POST['codigos']??''),
            'apb'=>$_POST['apb'] ?? null,
            'apb_adicional'=>$this->sanitize($_POST['apb_adicional']??''),
            'coseguros'=>$_POST['coseguros'] ?? null,
            'coseguros_adicional'=>$this->sanitize($_POST['coseguros_adicional']??''),
            'token'=>$_POST['token'] ?? null,
            'autorizacion'=>$_POST['autorizacion'] ?? null,
            'elegibilidad'=>$_POST['elegibilidad'] ?? null,
            'elegibilidad_adicional'=>$this->sanitize($_POST['elegibilidad_adicional']??''),
            'validez'=>(int)($_POST['validez'] ?? 0),
            'planes'=>$this->sanitize($_POST['planes']??''),
            'receta'=>json_encode($receta, JSON_UNESCAPED_UNICODE),
            'domicilio_cubre'=>$_POST['domicilio_cubre'] ?? null,
            'domicilio_adicional'=>$this->sanitize($_POST['domicilio_adicional']??''),
            'credencial'=>$_POST['credencial'] ?? null,
            'atencion'=>$this->sanitize($_POST['atencion']??''),
            'comentarios'=>$this->sanitize($_POST['comentarios']??''),

            'cuit'=>$this->sanitize($_POST['cuit']??''),
            'razon_social'=>$this->sanitize($_POST['razon_social']??''),
            'factura'=>$this->sanitize($_POST['factura']??''),
            'nomenclador'=>$this->sanitize($_POST['nomenclador']??''),
            'domicilio_fact'=>$this->sanitize($_POST['domicilio_fact']??''),
            'entrega'=>$this->sanitize($_POST['entrega']??''),
            'correo'=>$this->sanitize($_POST['correo']??''),
            'telefonos'=>$this->sanitize($_POST['telefonos']??''),
            'portal'=>$this->sanitize($_POST['portal']??'')
        ];
    }

    public function index(){
        $mutuales=\Models\Mutual::all();
        $this->view('mutuales/index',['mutuales'=>$mutuales,'title'=>'Mutuales']);
    }
    public function recent(){
        $mutuales=\Models\Mutual::recentUpdated(10);
        $this->view('mutuales/recent',['mutuales'=>$mutuales,'title'=>'Últimas modificadas']);
    }
    public function createForm(){ $this->view('mutuales/create',['title'=>'Nueva Mutual']); }
    public function create(){
        $data=$this->collectData();
        $errors=$this->requireFields(['name'=>'Nombre'],$data);
        if($errors){ $this->view('mutuales/create',['errors'=>$errors,'data'=>$data,'title'=>'Nueva Mutual']); return; }
        \Models\Mutual::create($data,(int)($_SESSION['user']['id']??0));
        header('Location: '.\APP_URL.'/mutuales'); exit;
    }
    public function ver(){
        $id=(int)($_GET['id']??0);
        $m=\Models\Mutual::find($id);
        if(!$m){ http_response_code(404); echo 'Mutual no encontrada'; return; }
        $this->view('mutuales/view',['mutual'=>$m,'title'=>'Detalle']);
    }
    public function editForm(){
        $id=(int)($_GET['id']??0);
        $m=\Models\Mutual::find($id);
        if(!$m){ http_response_code(404); echo 'Mutual no encontrada'; return; }
        $this->view('mutuales/edit',['mutual'=>$m,'title'=>'Editar Mutual']);
    }
    public function update(){
        $id=(int)($_POST['id']??0);
        $data=$this->collectData();
        $errors=$this->requireFields(['name'=>'Nombre'],$data);
        if($errors){
            $mutual=array_merge(['id'=>$id],$data);
            $this->view('mutuales/edit',['errors'=>$errors,'mutual'=>$mutual,'title'=>'Editar Mutual']); return;
        }
        \Models\Mutual::update($id,$data,(int)($_SESSION['user']['id']??0));
        header('Location: '.\APP_URL.'/mutuales'); exit;
    }
    public function delete(){
        $id=(int)($_POST['id']??0);
        if($id>0){ \Models\Mutual::softDelete($id,(int)($_SESSION['user']['id']??0)); }
        header('Location: '.\APP_URL.'/mutuales'); exit;
    }
    public function validateOn(){
        $id=(int)($_POST['id']??0);
        if($id>0){ \Models\Mutual::setValidation($id,1,(int)($_SESSION['user']['id']??0)); }
        header('Location: '.\APP_URL.'/mutuales/view?id='.$id); exit;
    }
    public function validateOff(){
        $id=(int)($_POST['id']??0);
        if($id>0){ \Models\Mutual::setValidation($id,0,(int)($_SESSION['user']['id']??0)); }
        header('Location: '.\APP_URL.'/mutuales/view?id='.$id); exit;
    }
}
