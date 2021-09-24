<?php
namespace App\Controllers;

class Dashboard extends BaseController {
  
  public function index() {
    $data = [];
    
    $role = session()->get('role');

    if($role == 'admin') {
      echo view('templates/admin_header', $data);
    }
    else {
      echo view('templates/header', $data);
    }

		echo view('dashboard');
		echo view('templates/footer');
  }
}