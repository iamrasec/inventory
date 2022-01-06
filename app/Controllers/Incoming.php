<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\IncomingModel;

class Incoming extends BaseController {
  public function index() {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      $model = new IncomingModel();
      $query = $model->table('incoming')->get();
      $data['incoming'] = $query->getResult();

      $suppliers = new SupplierModel();
      $supquery = $suppliers->table('suppliers')->get();
      $data['suppliers'] = $supquery->getResult();

      $db = \Config\Database::connect();
      $products = $db->table('incoming');
      $products->select('incoming.*, products.name as product_name, products.size, suppliers.name as supplier_name');
      $products->join('products', 'incoming.pid = products.id', 'inner');
      $products->join('suppliers', 'incoming.supplier_id = suppliers.id', 'inner');
      // $products->orderBy('incoming.eta', 'asc');
      // $products->where('incoming.status', 0);
      $query_products = $products->get();
      $data['products'] = $query_products->getResult();

      if($role == 'admin') {
        echo view('templates/admin_header', $data);
      }
      else {
        echo view('templates/header', $data);
      }
      echo view('incoming');
      echo view('templates/footer');
    }
    else {
      return redirect()->to('/');
    }    
  }

  public function received($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $newData = [
          'id' => $id,
          'status' => 1,
        ];

        $model = new IncomingModel();
        $model->save($newData);

        $incoming_data = $model->where('id', $id)->first();
        // $data['incoming_data'] = $incoming_data->getResult();

        $products = new ProductModel();
        $query_product = $products->where('id', $incoming_data['pid'])->first();
        $updated_stock = $query_product['stock_qty'] + $incoming_data['qty'];

        $update_stock = [
          'id' => $incoming_data['pid'],
          'stock_qty' => $updated_stock,
        ];

        $products->save($update_stock);

        session()->setFlashdata('success', 'Confirmed: Incoming product received.');
        return redirect()->to('/incoming');

        // $data['supplier'] = $model->where('id', $id)->first();

        // echo view('templates/admin_header', $data);
        // echo view('edit_supplier');
        // echo view('templates/footer');
      }
      else {
        return redirect()->to('/');
      }
    }
    else {
      return redirect()->to('/');
    }
  }

  public function view_incoming($id = false) {
    
  }

  public function delete_purchase_product($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $newData = [
          'id' => $id,
        ];

        $model = new IncomingModel();
        $model->delete($newData);

        session()->setFlashdata('success', 'Incoming Product Deleted.');
        return redirect()->to('/incoming');
      }
      else {
        return redirect()->to('/');
      }
    }
    else {
      return redirect()->to('/');
    }
  }

  public function add_purchase() {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {

        $products = new ProductModel();
        // $query_products = $products->table('products')->get();
        $query_products = $products->where('status', 1)->get();
        // $query_products = $products->where(['status' => 1, 'price > ' => 0])->get();
        $data['products'] = $query_products->getResult();

        $suppliers = new SupplierModel();
        $query_suppliers = $suppliers->table('suppliers')->get();
        $data['suppliers'] = $query_suppliers->getResult();

        if($this->request->getPost()) {
          $rules = [
            // 'checkout_products' => 'required',
            'supplier' => [
              'rules' => 'required',
              'errors' => [
                'required' => 'Please select a Supplier.',
              ]
            ],
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
            $model = new IncomingModel();

            $incoming_products = json_decode($this->request->getVar('checkout_products'));

            foreach($incoming_products as $chck_prod) {
              $pid = (int) $chck_prod->pid;

              $newData = [
                'receipt' => $this->request->getVar('receipt'),
                'pid' => $pid,
                'qty' => number_format($chck_prod->qty, 2, '.', ''),
                'price' => number_format($chck_prod->price, 2, '.', ''),
                'supplier_id' => $this->request->getVar('supplier'),
                'status' => 0,
                'purchase_date' => date("Y-m-d 00:00:00", strtotime($this->request->getVar('date_purchased'))),
                'eta' => date("Y-m-d 00:00:00", strtotime($this->request->getVar('eta'))),
              ];

              // echo "<pre>".print_r($newData, 1)."</pre>";

              $model->save($newData);  
            }

            session()->setFlashdata('success', 'Sales Order successfully added.');
				    return redirect()->to('/incoming');
          }
        }

        echo view('templates/admin_header', $data);
        echo view('add_purchase');
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