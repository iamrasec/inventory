<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\SupplierModel;

class Dashboard extends BaseController {
  
  public function index() {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      $model = new ProductModel();
      // $query = $model->table('products')->get();
      $query = $model->where('status', 1)->get();

      /* foreach ($query->getResult() as $row) {
        $data['supplier'][] = $row;
      } */

      $data['products'] = $query->getResult();

      if($role == 'admin') {
        echo view('templates/admin_header', $data);
      }
      else {
        echo view('templates/header', $data);
      }
  
      echo view('dashboard');
      echo view('templates/footer');
    }
    else {
      return redirect()->to('/');
    }        
  }
}