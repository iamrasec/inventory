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
      $model = new SalesModel();
      $query = $model->table('sales')->get();

      $data['sales'] = $query->getResult();

      if($role == 'admin') {
        echo view('templates/admin_header', $data);
      }
      else {
        echo view('templates/header', $data);
      }
      echo view('sales');
      echo view('templates/footer');
    }
    else {
      return redirect()->to('/');
    }    
  }

  public function confirm_release($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      $newData = [
        'id' => $id,
        'status' => 1,
      ];

      $model = new SalesModel();
      $model->save($newData);
      session()->setFlashdata('success', 'Confirmed: Order released to customer.');
      return redirect()->to('/sales/'.$id);

      // $data['supplier'] = $model->where('id', $id)->first();

      // echo view('templates/admin_header', $data);
      // echo view('edit_supplier');
      // echo view('templates/footer');
    }
    else {
      return redirect()->to('/sales');
    }
  }

  public function view_sales_order($id = false) {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      $model = new salesModel();
      $data['sales'] = $model->where('id', $id)->first();

      $db = \Config\Database::connect();
      $products = $db->table('sales_products');
      $products->select('sales_products.*, products.name, products.code, products.size, products.unit_measure');
      $products->join('products', 'sales_products.pid = products.id', 'inner');
      $products->where('sid', $id);
      $query_products = $products->get();
      $data['products'] = $query_products->getResult();

      if($role == 'admin') {
        echo view('templates/admin_header', $data);
      }
      else {
        echo view('templates/header', $data);
      }
      echo view('view_sales_order');
      echo view('templates/footer');
    }
    else {
      return redirect()->to('/');
    }
  }

  public function delete_sales($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      $model = new salesModel();
      $salesProductModel = new SalesProductModel();

      $newData = [
        'id' => $id,
      ];

      $model->delete($newData);
      $salesProductModel->where('sid', $id)->delete();
      session()->setFlashdata('success', 'Sales Order deleted');
      return redirect()->to('/sales');
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
            $pid = (int) $chck_prod->pid;

            $products_arr = [
              'sid' => $sale_id,
              'pid' => $pid,
              'qty' => number_format($chck_prod->qty, 2, '.', ''),
              'price' => number_format($chck_prod->price, 2, '.', ''),
              'total' => number_format($chck_prod->total, 2, '.', ''),
            ];

            $salesProductModel->save($products_arr);

            // echo '<pre>'.print_r($data['products']).'</pre>';

            foreach($data['products'] as $plist) {
              if($pid == $plist->id) {
                $update_stock = [
                  'id' => $pid,
                  'stock_qty' => $plist->stock_qty - number_format($chck_prod->qty, 2, '.', ''),
                ];
  
                $products->save($update_stock);
                break;
              }
            }

            // print_r($products_arr);

          }
          session()->setFlashdata('success', 'Sales Order successfully added.');
          return redirect()->to('/sales');
        }
      }

      if($role == 'admin') {
        echo view('templates/admin_header', $data);
      }
      else {
        echo view('templates/header', $data);
      }
      echo view('add_sales');
      echo view('templates/footer');
    }
    else {
      return redirect()->to('/');
    }    
  }
}