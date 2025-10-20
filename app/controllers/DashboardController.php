<?php
namespace Controllers;
use Core\Controller;
class DashboardController extends Controller{
    public function index(){
        $this->requireAuth();
        $recientes = [];
        try { if (class_exists('\\Models\\Mutual')) { $recientes = \Models\Mutual::recentUpdated(5);} } catch(\Throwable $e){}
        $this->view('dashboard/index',['title'=>'Dashboard','recientes'=>$recientes]);
    }
}
