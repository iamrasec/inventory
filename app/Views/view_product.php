<?php
// print_r(session()->get());
// print_r($product);

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
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="brand"><strong>Brand: </strong><?php echo $brand['name']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="category"><strong>Category: </strong><?php echo $category['name']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="supplier"><strong>Supplier: </strong><?php echo $supplier['name']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="size"><strong>Size: </strong><?php echo $product['size']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="unit"><strong>Unit: </strong><?php echo $product['unit_measure']; ?></div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="stock"><strong>Stocks remaining: </strong><?php echo $product['stock_qty']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="lowstock_alert"><strong>Low Stock Threshold: </strong><?php echo $product['lowstock_alert']; ?></div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="supplier_price"><strong>Supplier Price: </strong><?php echo $product['supplier_price']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="price"><strong>Price: </strong><?php echo $product['price']; ?></div>
    </div>
  </div>
</main>
<?php endif; ?>