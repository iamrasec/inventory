<?php 

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model {
  protected $table = 'sales';
  protected $allowedFields = ['receipt', 'customer', 'products'];
}