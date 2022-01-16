<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SubProductModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\SupplierModel;
use App\Models\IncomingModel;

class Products extends BaseController {
  public function index() {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new ProductModel();
        // $query = $model->table('products')->get();
        $query = $model->where('status', 1)->get();

        /* foreach ($query->getResult() as $row) {
          $data['supplier'][] = $row;
        } */

        $data['products'] = $query->getResult();

        echo view('templates/admin_header', $data);
        echo view('products');
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

  public function view_product($id = false) {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new ProductModel();
        $data['product'] = $model->where(['id' => $id, 'status' => 1])->first();

        $sub_products = new ProductModel();
        $query_subproducts = $sub_products->where(['is_subproduct' => 1, 'status' => 1, 'parent_id' => $id])->get();
        $data['sub_products'] = $query_subproducts->getResult();

        $sub_products_ratio = new SubProductModel();
        $query_subproducts_ratio = $sub_products_ratio->where(['ppid' => $id])->get();
        $data['sub_products_ratio'] = $query_subproducts_ratio->getResult();

        // print_r($data['product']['brand']);

        $brands = new BrandModel();
        $data['brand'] = $brands->where('id', $data['product']['brand'])->first();

        // print_r($data['brand']);

        $categories = new CategoryModel();
        $data['category'] = $categories->where('id', $data['product']['category'])->first();

        // print_r($data['category']);

        $suppliers = new SupplierModel();
        $query_suppliers = $suppliers->table('suppliers')->get();
        $data['suppliers'] = $query_suppliers->getResult();

        $db = \Config\Database::connect();

        foreach($data['suppliers'] as $supp_id => $supp_list) {
          $suppdata = $db->table('incoming');
          $suppdata->select('SUM(qty) as total');
          $suppdata->where(['pid' => $id, 'supplier_id' => $supp_list->id]);
          $query_suppdata = $suppdata->get();
          $total = $query_suppdata->getResult();

          if($total > 0) {
            $data['suppliers'][$supp_id]->total = $total[0]->total;
          }
          

          $suppdata->select('id, qty, price, purchase_date');
          $suppdata->where(['pid' => $id, 'supplier_id' => $supp_list->id]);
          $suppdata->orderBy('purchase_date', 'DESC');
          $suppdata->orderBy('id', 'DESC');
          $suppdata->limit(1);
          $query_last_purchase = $suppdata->get();
          $data['suppliers'][$supp_id]->last_purchase = $query_last_purchase->getResult();
        }

        // echo "<pre>".print_r($data['suppliers'], 1)."</pre>";

        // $incoming = new IncomingModel();
        // $$query_incoming = $incoming->where('pid', $id)->get();
        // $data['incoming'] = $query_incoming->getResult();

        /* $db = \Config\Database::connect();
        $incoming = $db->table('incoming');
        $incoming->select('incoming.*, suppliers.name as supplier_name, suppliers.id as supplier_id');
        $incoming->join('suppliers', 'incoming.supplier_id = suppliers.id', 'inner');
        $incoming->where('incoming.pid', $id);
        $incoming->orderBy('suppliers.name', 'ASC');
        $incoming->orderBy('incoming.purchase_date', 'DESC');
        $query_incoming = $incoming->get();
        $data['incoming'] = $query_incoming->getResult(); */

        // print_r($data['supplier']);

        echo view('templates/admin_header', $data);
        echo view('view_product');
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

  public function edit_product($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new ProductModel();
        $data['product'] = $model->where('id', $id)->first();

        $brands = new BrandModel();
        $query_brands = $brands->table('brands')->get();
        $data['brands'] = $query_brands->getResult();

        $categories = new CategoryModel();
        $query_categories = $categories->table('categories')->get();
        $data['categories'] = $query_categories->getResult();

        $suppliers = new SupplierModel();
        $query_suppliers = $suppliers->table('suppliers')->get();
        $data['suppliers'] = $query_suppliers->getResult();

        if($this->request->getPost()) {
          $rules = [
            'name' => 'required|min_length[3]',
          ];

          if($this->request->getPost('code') != $data['product']['code']) {
            $rules['code'] = 'is_unique[products.code]';
          }

          if($this->request->getPost('brand') == 'new_brand') {
            $rules['new_brand'] = 'required|min_length[3]';
          }

          if($this->request->getPost('category') == 'new_category') {
            $rules['new_category'] = 'required|min_length[3]';
          } 

          if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
          }
          else {
            $newBrand = [];
            $newCat = [];

            if($this->request->getPost('brand') == 'new_brand') {
              $newBrand['name'] = $this->request->getVar('new_brand');

              $brands->insert($newBrand);
              $brands_id = $brands->getInsertID();
              session()->setFlashdata('success', 'New Brand successfully added');
            }
            else {
              $brands_id = $this->request->getVar('brand');
            }

            if($this->request->getPost('category') == 'new_category') {
              $catSlug = $this->slugify($this->request->getVar('new_category'));

              $newCat = [
                'name' => $this->request->getVar('new_category'),
                'slug' => $catSlug,
                'parent' => 0,
              ];

              $categories->insert($newCat);
              $cat_id = $categories->getInsertID();
              session()->setFlashdata('success', 'New Category successfully added');
            }
            else {
              $cat_id = $this->request->getVar('category');
            }

            // $model = new ProductModel();

            $newData = [
              'id' => $id,
              'name' => $this->request->getVar('name'),
              'code' => $this->request->getVar('code'),
              'size' => $this->request->getVar('size'),
              'description' => $this->request->getVar('description'),
              'brand' => $brands_id,
              'category' => $cat_id,
              'stock_qty' => $this->request->getVar('stock_qty'),
              'unit_measure' => $this->request->getVar('unit_measure'),
              'supplier_price' => $this->request->getVar('supplier_price'),
              'price' => $this->request->getVar('price'),
              // 'supplier' => $this->request->getVar('supplier'),
              'lowstock_alert' => $this->request->getVar('lowstock_alert'),
            ];

            $model->save($newData);
            session()->setFlashdata('success', 'Product successfuly updated');
				    return redirect()->to('/products/'.$id);
          }
        }

        echo view('templates/admin_header', $data);
        echo view('edit_product');
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

  public function delete_product($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new ProductModel();

        $newData = [
          'id' => $id,
          'status' => 0,
        ];

        $model->save($newData);
        session()->setFlashdata('success', 'Product deleted');
        return redirect()->to('/products');
      }
      else {
        return redirect()->to('/');
      }
    }
    else {
      return redirect()->to('/');
    }
  }

  public function add_product() {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {

        $brands = new BrandModel();
        $query_brands = $brands->table('brands')->get();
        $data['brands'] = $query_brands->getResult();

        $categories = new CategoryModel();
        $query_categories = $categories->table('categories')->get();
        $data['categories'] = $query_categories->getResult();

        $suppliers = new SupplierModel();
        $query_suppliers = $suppliers->table('suppliers')->get();
        $data['suppliers'] = $query_suppliers->getResult();


        if($this->request->getPost()) {
          $rules = [
            'name' => 'required|min_length[3]',
          ];

          if($this->request->getPost('brand') == 'new_brand') {
            $rules['new_brand'] = 'required|min_length[3]';
          }

          if($this->request->getPost('category') == 'new_category') {
            $rules['new_category'] = 'required|min_length[3]';
          } 

          if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
          }
          else {
            $newBrand = [];
            $newCat = [];

            if($this->request->getPost('brand') == 'new_brand') {
              $newBrand['name'] = $this->request->getVar('new_brand');

              $brands->insert($newBrand);
              $brands_id = $brands->getInsertID();
              session()->setFlashdata('success', 'New Brand successfully added');
            }
            else {
              $brands_id = $this->request->getVar('brand');
            }

            if($this->request->getPost('category') == 'new_category') {
              $catSlug = $this->slugify($this->request->getVar('new_category'));

              $newCat = [
                'name' => $this->request->getVar('new_category'),
                'slug' => $catSlug,
                'parent' => 0,
              ];

              $categories->insert($newCat);
              $cat_id = $categories->getInsertID();
              session()->setFlashdata('success', 'New Category successfully added');
            }
            else {
              $cat_id = $this->request->getVar('category');
            }

            $model = new ProductModel();

            $newData = [
              'name' => $this->request->getVar('name'),
              'code' => $this->request->getVar('code'),
              'size' => $this->request->getVar('size'),
              'description' => $this->request->getVar('description'),
              'brand' => $brands_id,
              'category' => $cat_id,
              'stock_qty' => $this->request->getVar('stock_qty'),
              'unit_measure' => $this->request->getVar('unit_measure'),
              'supplier_price' => $this->request->getVar('supplier_price'),
              'price' => $this->request->getVar('price'),
              // 'supplier' => $this->request->getVar('supplier'),
              'lowstock_alert' => $this->request->getVar('lowstock_alert'),
            ];

            $model->save($newData);
            session()->setFlashdata('success', 'Product successfully added');
				    return redirect()->to('/products');
          }
        }

        echo view('templates/admin_header', $data);
        echo view('add_product');
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

  public function add_subproduct($id) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    // $response = array();

    echo '<pre>Submitted: '.print_r($this->request->getVar(), 1).'</pre>';

    if($isLoggedIn == 1) {
      if($role == 'admin') {

        $model = new ProductModel();
        $parent_product = $model->where('id', $id)->first();

        // echo '<pre>Parent: '.print_r($parent_product, 1).'</pre>';

        $initial_stocks = floatval($this->request->getVar('childQty')) * floatval($this->request->getVar('qty_unpack'));
        $parent_price = $parent_product['price'] / $this->request->getVar('childQty');

        $new_parent_qty = floatval($parent_product['stock_qty']) - floatval($this->request->getVar('qty_unpack'));

        if($new_parent_qty < 0) {
          session()->setFlashdata('error', 'Unable to unpack.  Source product quantity not enough.');
          $initial_stocks = 0;
        }

        $newData = [
          'name' => $this->request->getVar('name'),
          'code' => $this->request->getVar('code'),
          'size' => $parent_product['size'],
          'description' => $parent_product['description'],
          'brand' => $parent_product['brand'],
          'category' => $parent_product['category'],
          'stock_qty' => $initial_stocks,
          'unit_measure' => $this->request->getVar('child_unit'),
          'supplier_price' => $parent_price,
          'price' => $this->request->getVar('price'),
          // 'supplier' => $this->request->getVar('supplier'),
          // 'lowstock_alert' => $this->request->getVar('lowstock_alert'),
          'lowstock_alert' => '',
          'is_subproduct' => 1,
          'parent_id' => $parent_product['id'],
        ];

        // echo '<pre>Sub Product to save: '.print_r($newData, 1).'</pre>';

        
        $model->insert($newData);
        $sub_product_id = $model->getInsertID();
        // $sub_product_id = 100;

        // echo '<pre>'.print_r($new_parent_qty, 1).'</pre>';

        $subData = [
          'ppid' => $parent_product['id'],
          'spid' => $sub_product_id,
          'punitqty' => $this->request->getVar('parentQty'),
          'sunitqty' => $this->request->getVar('childQty'),
        ];

        // echo '<pre>Relation to save: '.print_r($subData, 1).'</pre>';

        $subProduct = new SubProductModel();
        $subProduct->save($subData);
        session()->setFlashdata('success', 'Sub Product added successfully added');
        return redirect()->to('/products/'.$id);
      }
    }
    // echo view('templates/admin_header', $data);
    // echo view('add_subproduct');
    // echo view('templates/footer');

    // return $this->response->setJSON($response);
    
  }

  public static function slugify($text, string $divider = '-') {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }

}