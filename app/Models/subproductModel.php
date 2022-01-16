<?php 

namespace App\Models;

use CodeIgniter\Model;

class SubProductModel extends Model {
  protected $table = 'sub_products';
  protected $allowedFields = ['ppid', 'spid', 'punitqty', 'sunitqty'];
}