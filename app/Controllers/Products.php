<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\SupplierModel;

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

        // print_r($data['product']['brand']);

        $brands = new BrandModel();
        $data['brand'] = $brands->where('id', $data['product']['brand'])->first();

        // print_r($data['brand']);

        $categories = new CategoryModel();
        $data['category'] = $categories->where('id', $data['product']['category'])->first();

        // print_r($data['category']);

        $suppliers = new SupplierModel();
        $data['supplier'] = $suppliers->where('id', $data['product']['supplier'])->first();

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
            'supplier' => 'required',
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
              'supplier' => $this->request->getVar('supplier'),
              'lowstock_alert' => $this->request->getVar('lowstock_alert'),
            ];

            $model->save($newData);
            session()->setFlashdata('success', 'Supplier successfuly updated');
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
            'code' => 'is_unique[products.code]',
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
              'supplier' => $this->request->getVar('supplier'),
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