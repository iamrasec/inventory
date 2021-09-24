<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\IncomingModel;

class Sales extends BaseController {
  public function index() {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new IncomingMOdel();
        $query = $model->table('incoming')->get();

        $data['sales'] = $query->getResult();

        echo view('templates/admin_header', $data);
        echo view('incoming');
        echo view('templates/footer');
      }
      else {
        return redirect()->to('/');
      }
    }
    else {
      return redirect()->to('/');
    }    
  }

}