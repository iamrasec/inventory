<?php
// print_r(session()->get());
// print_r($sales);

$output = "";
?>
<main id="view_salesorder_page" class="withpadding">
  <?php if(session()->get('success')): ?>
    <div class="alert alert-success" role="alert">
      <?php echo session()->get('success'); ?>
    </div>
  <?php endif; ?>

  <div class="row mt-3">
    <div class="col-12 col-md-8 mt-1 pt-1 pb-1 bg-white">
      <h1>Sales Order # <?php echo $sales['id']; ?></h1>
      <div class="sales_receipt"><strong>Receipt No.:</strong> <?php echo $sales['receipt']; ?></div>
      <div class="sales_customer"><strong>Customer Name:</strong> <?php echo $sales['customer']; ?></div>
      <div class="date_added" date-data="<?php echo $sales['order_date']; ?>"><strong>Order Date: </strong><?php echo date("F j, Y g:i A", strtotime($sales['order_date'])); ?></div>
    </div>
    
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <?php if($sales['status'] == 0): ?>
      <div class="edit_wrapper text-right"><a class="btn btn-primary" href="/sales/<?php echo $sales['id']; ?>/release"><i class="fas fa-check"></i> Confirm Release</a></div>
      <?php else: ?>
      <div class="edit_wrapper text-right"><a class="btn btn-success btn-disabled" href="#">Released</a></div>
      <?php endif; ?>
    </div>
  </div>

  <hr />
  
  <div class="row mt-3">
    <div class="container">
      <h3>Products</h3>
      <div class="row">
        <div class="col col-12 col-sm-12 col-md-6 show_name_header"><strong>Product Name</strong></div>
        <div class="col col-12 col-sm-12 col-md-6">
          <div class="row">
            <div class="col col-12 col-sm-12 col-md-3 show_qty_header"><strong>Quantity</strong></div>
            <div class="col col-12 col-sm-12 col-md-2 show_unitprice_header"><strong>Price</strong></div>
            <div class="col col-12 col-sm-12 col-md-2 show_unit_header"><strong>Unit</strong></div>
            <div class="col col-12 col-sm-12 col-md-2 show_linetotal_header"><strong>Total</strong></div>
          </div>
        </div>
      </div>
      <div id="cart_items">
        <?php foreach($products as $row => $value): ?>
          <div class="row added_product product-<?php echo $value->id; ?>">
            <div class="col col-12 col-sm-12 col-md-6 show_name"><?php echo ($value->size != "") ? $value->name .' '. $value->size : $value->name; ?></div>
            <div class="col col-12 col-sm-12 col-md-6">
              <div class="row">
                <div class="col-12 col-sm-12 col-md-3 show_qty"><?php echo $value->qty; ?></div>
                <div class="col-12 col-sm-12 col-md-2 show_unitprice"><?php echo number_format($value->price, 2, '.', ','); ?></div>
                <div class="col-12 col-sm-12 col-md-2 show_unit"><?php echo $value->unit_measure; ?></div>
                <div class="col-12 col-sm-12 col-md-2 show_linetotal"><?php echo number_format($value->total, 2, '.', ','); ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>