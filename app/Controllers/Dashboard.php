<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    private $data = [
        'view'=>'Dasboard',
        'saveData' => false,
        'active' => 'dashboard'
    ];

    public function __construct()
    {
        $session = session();
        $this->data['role'] = $session->role;
        $this->data['username'] = $session->username;
    }
    public function index()
    {
        return view('dashboard', $this->data);
    }
}
?>