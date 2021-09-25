<?php 

namespace App\Models;

use CodeIgniter\Model;

class IncomingModel extends Model {
  protected $table = 'incoming';
  protected $allowedFields = ['id', 'receipt', 'pid', 'qty', 'price', 'supplier_id', 'status', 'purchase_date', 'eta'];
}