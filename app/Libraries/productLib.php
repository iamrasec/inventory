<?php

namespace App\Libraries;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\SalesModel;
use App\Models\SalesProductModel;

class ProductLib {
  public function add_qty($pid = 0, $qty = 0) {
    // echo "PID: ".$pid;
    // echo "<br>";
    // echo "QTY: ".$qty;

    $products = new ProductModel();
    $product_data = $products->where('id', $pid)->first();

    // echo "<pre>".print_r($product_data, 1)."</pre>";
    

    $new_qty = number_format($product_data['stock_qty'] + $qty, 2, '.', '');

    // echo "<br>";
    // echo "New QTY: " . $new_qty;

    $newdata = [
      'id' => $pid,
      'stock_qty' => $new_qty,
    ];

    $products->save($newdata);

    // echo "<br><hr>";

    return true;
  }
}