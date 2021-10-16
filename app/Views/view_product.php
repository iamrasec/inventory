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
    });
  </script>

</main>
<?php endif; ?>