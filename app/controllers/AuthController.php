<?php
namespace Controllers;
use Core\Controller;
use Core\Auth;

class AuthController extends Controller{
    public function loginForm(){ if(!empty($_SESSION['user'])){ header('Location: '.\APP_URL.'/dashboard'); exit; } $this->view('auth/login',['title'=>'Ingresar']); }
    public function login(){ $u=$_POST['username']??''; $p=$_POST['password']??'';
        if(Auth::attempt($u,$p)){ header('Location: '.\APP_URL.'/dashboard'); exit; }
        $this->view('auth/login',['error'=>'Credenciales inválidas','title'=>'Ingresar']);
    }
    public function logout(){ Auth::logout(); header('Location: '.\APP_URL.'/login'); }
}
