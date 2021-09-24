<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model {
  protected $table = 'products';
  protected $allowedFields = ['name', 'code', 'size', 'brand', 'description', 'category', 'stock_qty', 'unit_measure', 'supplier_price', 'price', 'supplier', 'lowstock_alert', 'status', 'updated_at'];
}