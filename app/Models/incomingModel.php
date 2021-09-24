<?php 

namespace App\Models;

use CodeIgniter\Model;

class IncomingModel extends Model {
  protected $table = 'incoming';
  protected $allowedFields = ['receipt', 'products'];
}