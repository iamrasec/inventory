<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\SalesModel;

class Sales extends BaseController {
  public function index() {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new SalesModel();
        $query = $model->table('sales')->get();

        $data['sales'] = $query->getResult();

        echo view('templates/admin_header', $data);
        echo view('sales');
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

  public function add_sales() {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {

        $products = new ProductModel();
        // $query_products = $products->table('products')->get();
        $query_products = $products->where('status', 1)->get();
        $data['products'] = $query_products->getResult();

        $categories = new CategoryModel();
        $query_categories = $categories->table('categories')->get();
        $data['categories'] = $query_categories->getResult();

        $brands = new BrandModel();
        $query_brands = $brands->table('brands')->get();
        $data['brands'] = $query_brands->getResult();


        if($this->request->getPost()) {
          $rules = [
            'name' => 'required|min_length[3]',
            'code' => 'required|min_length[3]|is_unique[products.code]',
            'supplier' => 'required',
          ];

          if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
          }
          else {
            $model = new ProductModel();

            $newData = [
              'name' => $this->request->getVar('name'),
              'code' => $this->request->getVar('code'),
              'size' => $this->request->getVar('size'),
              'description' => $this->request->getVar('description'),
              'stock_qty' => $this->request->getVar('stock_qty'),
              'unit_measure' => $this->request->getVar('unit_measure'),
              'supplier_price' => $this->request->getVar('supplier_price'),
              'price' => $this->request->getVar('price'),
              'supplier' => $this->request->getVar('supplier'),
              'lowstock_alert' => $this->request->getVar('lowstock_alert'),
            ];

            $model->save($newData);
            session()->setFlashdata('success', 'Product successfully added');
				    return redirect()->to('/sales');
          }
        }

        echo view('templates/admin_header', $data);
        echo view('add_sales');
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