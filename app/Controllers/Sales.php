<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\SalesModel;
use App\Models\SalesProductModel;

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
        // $query_products = $products->where('status', 1)->get();
        $query_products = $products->where(['status' => 1, 'price > ' => 0])->get();
        $data['products'] = $query_products->getResult();

        $categories = new CategoryModel();
        $query_categories = $categories->table('categories')->get();
        $data['categories'] = $query_categories->getResult();

        $brands = new BrandModel();
        $query_brands = $brands->table('brands')->get();
        $data['brands'] = $query_brands->getResult();


        if($this->request->getPost()) {
          $rules = [
            // 'checkout_products' => 'required',
            'checkout_products' => [
              'rules' => 'required',
              'errors' => [
                'required' => 'Please add atleast 1 product.',
              ]
            ],
          ];

          if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
          }
          else {
            $model = new salesModel();

            $newData = [
              'receipt' => $this->request->getVar('receipt'),
              'customer' => $this->request->getVar('customer'),
              'status' => 0,
              'total' => $this->request->getVar('total'),
            ];

            $model->insert($newData);
            $sale_id = $model->getInsertID();

            $checkoutProducts = json_decode($this->request->getVar('checkout_products'));

            $salesProductModel = new SalesProductModel();
            
            foreach($checkoutProducts as $chck_prod) {
              // print_r($chck_prod);
              // print_r('<br>');

              $products_arr = [
                'sid' => $sale_id,
                'pid' => (int) $chck_prod->pid,
                'qty' => number_format($chck_prod->qty, 2, '.', ''),
                'price' => number_format($chck_prod->price, 2, '.', ''),
                'total' => number_format($chck_prod->total, 2, '.', ''),
              ];

              $salesProductModel->save($products_arr);

              // print_r($products_arr);

            }
            session()->setFlashdata('success', 'Sales Order successfully added.');
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