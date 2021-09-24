<?php
// print_r(session()->get());
// print_r($supplier);

$output = "";
?>
<main id="view_supplier_page" class="withpadding">
  <?php if(session()->get('success')): ?>
    <div class="alert alert-success" role="alert">
      <?php echo session()->get('success'); ?>
    </div>
  <?php endif; ?>

  <div class="row mt-3">
    <div class="col-12 col-md-8 mt-1 pt-1 pb-1 bg-white">
      <h1><?php echo $supplier['name']; ?></h1>
      <div class="supplier_code">Supplier Code: <strong><?php echo $supplier['code']; ?></strong></div>
    </div>
    
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="edit_wrapper text-right"><a class="btn btn-primary" href="/suppliers/<?php echo $supplier['id']; ?>/edit">Edit</a></div>
      <div class="date_added_wrapper">
        <div class="date_added" date-data="<?php echo $supplier['created_at']; ?>"><strong>Date Added: </strong><?php echo date("F j, Y g:i A", strtotime($supplier['created_at'])); ?></div>
        <?php if($supplier['updated_at'] > $supplier['created_at']): ?>
        <div class="date_updated" date-data="<?php echo $supplier['updated_at']; ?>"><strong>Updated on: </strong><?php echo date("F j, Y g:i A", strtotime($supplier['updated_at'])); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <hr />
  <div class="row mt-3">
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="street_address"><strong>Street Address: </strong><?php echo $supplier['street_address']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="barangay"><strong>Barangay: </strong><?php echo $supplier['barangay']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="city"><strong>City: </strong><?php echo $supplier['city']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="zip"><strong>Zip Code: </strong><?php echo $supplier['zip_code']; ?></div>
    </div>
    <div class="col-12 col-md-4 mt-1 pt-1 pb-1 bg-white">
      <div class="province"><strong>Province: </strong><?php echo $supplier['province']; ?></div>
    </div>
  </div>
</main>