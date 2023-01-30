<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $helpers = ['form'];
    private $data = [
        'view'=>'Login',
        'saveData' => false,
    ];

    public function __construct()
    {
        helper('form');
        $this->userModel = model('App\Models\UserModel');
    }

    public function index()
    {
        $this->response->redirect('auth/login');
        // redirect()->to("/auth/login");
    }

    public function login(){
        if($this->request->getMethod() == 'get') return view('login', $this->data);
        $loginData = $this->request->getPost();
        $session = session();
        $user = $this->userModel->where('username', $loginData['username'])->first();
        if($user){
            if(password_verify($loginData['password'], $user['password'])){
                $session->set(['id'=>$user['id'], 'username'=>$user['username'], 'role'=>$user['role'], 'isLoggedIn'=>TRUE]);
                return $this->response->redirect('/dashboard');
            } else{
                $session->setFlashdata('msg', 'password invalid');
                return view('login', $this->data);
            }
        } else {
            $session->setFlashdata('msg','username invalid');
            return view('login', $this->data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        $this->response->redirect('auth/login');
    }
}
?>