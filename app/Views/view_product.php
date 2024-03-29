<?php
// print_r(session()->get());
// print_r($product);

date_default_timezone_set('Asia/Manila');

$output = "";
?>

<?php if(empty($product)): ?>
  <div class="alert alert-danger" role="alert">
    PRODUCT NOT FOUND
  </div>
<?php else: ?>
<main id="view_product_page" class="withpadding">
  <?php if(session()->get('success')): ?>
    <div class="col col-12 col-md-12 mt-3 pt-3 pb-3 alert alert-success" role="alert">
      <?php echo session()->get('success'); ?>
    </div>
  <?php endif; ?>
  <?php if(session()->get('error')): ?>
    <div class="col col-12 col-md-12 mt-3 pt-3 pb-3 alert alert-danger" role="alert">
      <?php echo session()->get('error'); ?>
    </div>
  <?php endif; ?>

  <div class="row mt-3">
    <div class="col-12 col-md-8 mt-1 pt-1 pb-1 bg-white">
      <a href="/products" class="mt-1 mb-2"><i class="fas fa-arrow-left"></i> Back to Inventory List</a>
      <h1><?php echo $product['name']; ?><?php echo ($product['size'] != '') ? ' - '.$product['size'] : ''; ?></h1>
      <div class="product_code">product Code: <strong><?php echo $product['code']; ?></strong></div>
    </div>
    
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="edit_wrapper text-right"><a class="btn btn-primary" href="/products/<?php echo $product['id']; ?>/edit">Edit</a></div>
      <div class="date_added_wrapper">
        <div class="date_added" date-data="<?php echo $product['created_at']; ?>"><strong>Date Added: </strong><?php echo date("F j, Y g:i A", strtotime($product['created_at'])); ?></div>
        <?php if($product['updated_at'] > $product['created_at']): ?>
        <div class="date_updated" date-data="<?php echo $product['updated_at']; ?>"><strong>Updated on: </strong><?php echo date("F j, Y g:i A", strtotime($product['updated_at'])); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <hr />
  <div class="row mt-3">
    <div class="col-12 col-md-12 mt-1 pt-1 pb-1 bg-white">
      <div class="description"><strong>Description: </strong><br/><?php echo $product['description']; ?></div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="brand"><strong>Brand: </strong><?php echo $brand['name']; ?></div>
    </div>
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="category"><strong>Category: </strong><?php echo $category['name']; ?></div>
    </div>
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="size"><strong>Size: </strong><?php echo $product['size']; ?></div>
    </div>
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="unit"><strong>Unit: </strong><?php echo $product['unit_measure']; ?></div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="price"><strong>Price: </strong>Php <?php echo number_format($product['price'], 2, '.', ','); ?></div>
    </div>
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
    <div class="supplier_price"><strong>Average Supplier Price: </strong>Php 0.00</div>
    </div>
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="stock"><strong>Stocks remaining: </strong><?php echo number_format($product['stock_qty'], 2, '.', ','); ?></div>
    </div>
    <div class="col-12 col-md-3 mt-1 pt-1 pb-1 bg-white">
      <div class="lowstock_alert"><strong>Low Stock Threshold: </strong><?php echo number_format($product['lowstock_alert'], 2, '.', ','); ?></div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-12 col-md-12 mt-1 pt-1 pb-1 bg-white">
      <hr />
      <div class="row mb-3">
        <div class="col-12 col-md-10 mt-1 pt-1 pb-1 bg-white">
          <h5><strong>Sub-products / Retail</strong></h5>
        </div>
        <div class="col-12 col-md-2 mt-1 pt-1 pb-1 bg-white">
        <div class="edit_wrapper text-right">
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubproductModal">
            Add Sub-Product
          </button>

          <!-- Modal -->
          <div class="modal fade" id="addSubproductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">
                    Add Sub-Product for <?php echo $product['name']; ?><?php echo ($product['size'] != '') ? ' - '.$product['size'] : ''; ?>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="addSubproductForm" action="/products/<?php echo $product['id']; ?>/subproduct/add" method="post">
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-12 mb-3 mt-3">
                        <div class="form-group mb-3">
                          <label for="name"><strong>Sub-Product Name</strong></label>
                          <input type="text" class="form-control" name="name" id="name" value="<?php echo $product['name']; ?><?php echo ($product['size'] != '') ? ' - '.$product['size'] : ''; ?> (Retail)">
                        </div>
                        <div class="form-group  mb-3">
                          <label for="name"><strong>Sub-Product Code</strong></label>
                          <input type="text" class="form-control" name="code" id="code" value="<?php echo $product['code']; ?> (Retail)">
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 mb-3 mt-3 form-group">
                          <label><strong>Conversion</strong> <span style="font-size: 12px; font-style: italic;">(Unpacking to smaller retail quantities)</span></label>
                          <div class="row">
                            <div class="col-12 col-sm-12 col-md-4">
                              <input type="text" class="form-control" name="parentQty" id="parentQty" value="1" readonly><br>
                              <input type="text" class="form-control" name="parentUnit" id="parentUnit" value="<?php echo $product['unit_measure']; ?>" readonly>
                            </div>
                            <div class="col-12 col-sm-12 col-md-2 text-center">To</div>
                            <div class="col-12 col-sm-12 col-md-4">
                              <input type="text" class="form-control" name="childQty" id="childQty" value=""><br>
                              <select class="form-control" name="child_unit" id="child_unit">
                                <option value="bottle">Bottle</option>
                                <option value="box">Box</option>
                                <option value="bundle">Bundle</option>
                                <option value="can">Can</option>
                                <option value="case">Case</option>
                                <option value="dozen">Dozen</option>
                                <option value="kilo">Kilo</option>
                                <option value="liter">Liter</option>
                                <option value="meters">Meters</option>
                                <option value="pack">Pack</option>
                                <option value="piece" selected="selected">Piece</option>
                                <option value="sack">Sack</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group  mb-3 text-left"  style="text-align: left;">
                          <label for="qty_unpack"><strong>Price</strong></label>
                          <input type="text" class="form-control" name="price" id="price" value="<?php echo $product['price']; ?>" style="display: inline-block; width: 100px;"> 
                        </div>
                        <div class="form-group  mb-3">
                          <label for="qty_unpack"><strong>Initial Stock Quantity</strong></label>
                            <div class="initial_stock" style="text-align: left;">
                              Unpack 
                              <input type="number" class="form-control" name="qty_unpack" id="qty_unpack" value="1" style="display: inline-block; width: 100px;"> 
                              <?php echo $product['unit_measure']; ?>
                            </div> 
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </form>
                </div>
                <div class="modal-footer">
                  <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                </div>
              </div>
            </div>
          </div>

        </div>
        </div>
      </div>

      <div class="row">
        <!--<pre><?php echo print_r($sub_products, 1); ?></pre>-->
        <table id="subproducts_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
          <thead>
            <tr>
              <th>Name</th>
              <th>Code</th>
              <th>Size</th>
              <th>Unit</th>
              <th>Price</th>
              <th>Available Stocks</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($sub_products)): ?>
              <?php foreach($sub_products as $row=>$sub_product): ?>
                <tr>
                  <td><?php echo $sub_product->name; ?></td>
                  <td><?php echo $sub_product->code; ?></td>
                  <td><?php echo $sub_product->size; ?></td>
                  <td><?php echo $sub_product->unit_measure; ?></td>
                  <td><?php echo $sub_product->price; ?></td>
                  <td>
                    <?php echo $sub_product->stock_qty; ?>
                    <span class="text-right" style="float: right; margin-right: 20px;"><a href="#" class="edit-product edit-product-<?php echo $sub_product->id; ?>" data-bs-toggle="modal" data-bs-target="#replenish_subproduct-<?php echo $sub_product->id; ?>"><i class="fas fa-plus"></i></a></span></td>

                    <!-- Modal -->
                    <div class="modal fade" id="replenish_subproduct-<?php echo $sub_product->id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">
                                Replenish / Unpack for <?php echo $sub_product->name; ?>
                              </h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form id="addSubproductForm-<?php echo $sub_product->id; ?>" action="/subproduct/replenish/<?php echo $sub_product->id; ?>" method="post">
                                <div class="row">
                                  <div class="col-12 col-sm-12 col-md-12 mb-3 mt-3">
                                    <div class="col-12 col-sm-12 col-md-12 mb-3 mt-3 form-group">
                                      <label><strong>Conversion</strong> <span style="font-size: 12px; font-style: italic;">(Unpacking to smaller retail quantities)</span></label>
                                      <div class="row">
                                        <div class="col-12 col-sm-12 col-md-4">
                                          <input type="text" class="form-control" name="parentQty" id="parentQty" value="1" readonly><br>
                                          <input type="text" class="form-control" name="parentUnit" id="parentUnit" value="<?php echo $product['unit_measure']; ?>" readonly>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 text-center">To</div>
                                        <div class="col-12 col-sm-12 col-md-4">
                                          <input type="text" class="form-control" name="childQty" id="childQty" value="<?php echo $sub_products_ratio[$row]->sunitqty; ?>" readonly><br>
                                          <input type="text" class="form-control" name="child_unit" id="child_unit" value="<?php echo $sub_product->unit_measure; ?>" readonly>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group  mb-3">
                                      <label for="qty_unpack"><strong>Convert/Unpack Stocks</strong></label>
                                        <div class="initial_stock" style="text-align: left;">
                                          Unpack 
                                          <input type="number" class="form-control" name="qty_unpack" id="qty_unpack" value="1" style="display: inline-block; width: 100px;"> 
                                          <?php echo $product['unit_measure']; ?>
                                        </div> 
                                    </div>
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                            </div>
                          </div>
                        </div>
                      </div>
                  <td>
                    <a href="#" class="edit-product edit-product-<?php echo $sub_product->id; ?>"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                    <a href="#" class="delete delete-product delete-product-<?php echo $sub_product->id; ?>" data-id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Name</th>
              <th>Code</th>
              <th>Size</th>
              <th>Unit</th>
              <th>Price</th>
              <th>Available Stocks</th>
              <th>Action</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-12 col-md-12 mt-1 pt-1 pb-1 bg-white">
      <hr />
      <h5><strong>Suppliers</strong></h5>
      <?php if(!empty($suppliers)): ?>
        <table id="suppliers_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
          <thead>
              <tr>
                <th>Name</th>
                <th>Last Purchased Quantity</th>
                <th>Last Purchase Price</th>
                <th>Last Purchase Date</th>
                <th>Total Quantity Purchased</th>
              </tr>
          </thead>
          <tbody>
              <?php 
              foreach($suppliers as $row) {
                /* if(!empty($row->last_purchase)) {
                  print_r($row->last_purchase[0]);
                } */

                if(!empty($row->last_purchase)) {
                  $output .= '<tr>';
                  $output .= '<td class="name"><a href="/suppliers/'.$row->id.'" class="view-link-data">'.$row->name.'</a></td>';
                  $output .= '<td>'.number_format($row->last_purchase[0]->qty, 2, '.', ',').'</td>';
                  $output .= '<td>Php '.number_format($row->last_purchase[0]->price, 2, '.', ',').'</td>';
                  $output .= '<td>'.date("F j, Y g:i A", strtotime($row->last_purchase[0]->purchase_date)).'</td>';
                  $output .= '<td>'.number_format($row->total, 2, '.', ',').'</td>';
                  $output .= '</tr>';
                }
              }

              echo $output;
              ?>
          </tbody>
          <tfoot>
              <tr>
                <th>Name</th>
                <th>Last Purchased Quantity</th>
                <th>Last Purchase Price</th>
                <th>Last Purchase Date</th>
                <th>Total Quantity Purchased</th>
              </tr>
          </tfoot>
        </table>
      <?php endif; ?>
    </div>
    <pre><?php // print_r($suppliers); ?></pre>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#suppliers_list').DataTable({
        "order": [[3, "desc"]],
      });
      $('#subproducts_list').DataTable();
    });
  </script>

</main>
<?php endif; ?>