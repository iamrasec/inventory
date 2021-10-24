<?php 

namespace App\Models;

use CodeIgniter\Model;

class SalesProductModel extends Model {
  protected $table = 'sales_products';
  protected $allowedFields = ['sid', 'pid', 'qty', 'price', 'total', 'discounted', 'discounted_price', 'discounted_total'];
}