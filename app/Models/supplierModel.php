<?php 

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model {
  protected $table = 'suppliers';
  protected $allowedFields = ['name', 'code', 'street_address', 'barangay', 'city', 'province', 'zip_code', 'phone', 'mobile', 'updated_at'];
}