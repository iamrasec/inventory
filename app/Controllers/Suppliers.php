<?php
namespace App\Controllers;

use App\Models\SupplierModel;

class Suppliers extends BaseController {
  
  public function index() {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new SupplierModel();
        $query = $model->table('suppliers')->get();

        /* foreach ($query->getResult() as $row) {
          $data['supplier'][] = $row;
        } */

        $data['supplier'] = $query->getResult();

        echo view('templates/admin_header', $data);
        echo view('suppliers');
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

  public function view_supplier($id = false) {
    $data = [];

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new SupplierModel();
        $data['supplier'] = $model->where('id', $id)->first();

        echo view('templates/admin_header', $data);
        echo view('view_supplier');
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

  public function edit_supplier($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new SupplierModel();

        if($this->request->getPost()) {
          $rules = [
            'name' => 'required|min_length[3]',
            'code' => 'required|min_length[3]|is_unique[suppliers.code]',
          ];

          if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
          }
          else {
            $model = new SupplierModel();

            $newData = [
              'id' => $id,
              'name' => $this->request->getVar('name'),
              'code' => $this->request->getVar('code'),
              'street_address' => $this->request->getVar('street_address'),
              'barangay' => $this->request->getVar('barangay'),
              'city' => $this->request->getVar('city'),
              'province' => $this->request->getVar('province'),
              'zip_code' => $this->request->getVar('zip_code'),
              'phone' => $this->request->getVar('phone'),
              'mobile' => $this->request->getVar('mobile'),
            ];

            $model->save($newData);
            session()->setFlashdata('success', 'Supplier successfuly updated');
				    return redirect()->to('/suppliers/'.$id);
          }
        }

        $data['supplier'] = $model->where('id', $id)->first();

        echo view('templates/admin_header', $data);
        echo view('edit_supplier');
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

  public function delete_supplier($id = false) {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {
        $model = new SupplierModel();

        $newData = [
          'id' => $id,
        ];

        $model->delete($newData);
        session()->setFlashdata('success', 'Supplier deleted');
        return redirect()->to('/suppliers');
      }
      else {
        return redirect()->to('/');
      }
    }
    else {
      return redirect()->to('/');
    }
  }

  public function add_suppliers() {
    $data = [];
    helper(['form']);

    $role = session()->get('role');
    $isLoggedIn = session()->get('isLoggedIn');

    if($isLoggedIn == 1) {
      if($role == 'admin') {

        if($this->request->getPost()) {
          $rules = [
            'name' => 'required|min_length[3]',
            'code' => 'required|min_length[3]|is_unique[suppliers.code]',
          ];

          if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
          }
          else {
            $model = new SupplierModel();

            $newData = [
              'name' => $this->request->getVar('name'),
              'code' => $this->request->getVar('code'),
              'street_address' => $this->request->getVar('street_address'),
              'barangay' => $this->request->getVar('barangay'),
              'city' => $this->request->getVar('city'),
              'province' => $this->request->getVar('province'),
              'zip_code' => $this->request->getVar('zip_code'),
              'phone' => $this->request->getVar('phone'),
              'mobile' => $this->request->getVar('mobile'),
            ];

            $model->save($newData);
            session()->setFlashdata('success', 'Supplier successfully added');
				    return redirect()->to('/suppliers');
          }
        }

        echo view('templates/admin_header', $data);
        echo view('add_suppliers');
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