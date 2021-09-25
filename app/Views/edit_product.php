<?php 
// print_r($brands);
?>
<main class="withpadding">
  <h1>Edit Product</h1>
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <form class="" action="/products/<?php echo $product['id']; ?>/edit" method="post">
          <div class="row">
            <div class="col-12 col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name', $product['name']); ?>">
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3 mb-3">
              <div class="form-group">
                <label for="code">Product Code</label>
                <input type="text" class="form-control" name="code" id="code" value="<?php echo set_value('code', $product['code']); ?>">
                <div class="form-note"></div>
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3 mb-3">
              <div class="form-group">
                <label for="size">Size</label>
                <input type="text" class="form-control" name="size" id="size" value="<?php echo set_value('size', $product['size']); ?>">
              </div>
            </div>

            <div class="col-12 col-sm-12 mb-3">
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="5"><?php echo set_value('description', $product['description']); ?></textarea>
              </div>
            </div>

            <div class="col-12 col-sm-12 mb-3">
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label for="brand">Brand</label><br>
                    <select class="form-control" name="brand" id="brand">
                      <?php 
                      $brands_option = "";
                      foreach($brands as $rwcount => $row) {
                        if($row->id == $product['brand']) {
                          $brands_option .= '<option value="'.$row->id.'" selected="selected">'.$row->name.'</option>';
                        }
                        else {
                          $brands_option .= '<option value="'.$row->id.'">'.$row->name.'</option>';
                        }
                      }
                      $brands_option .= '<option disabled>----------------------------------------------------</option>';
                      $brands_option .= '<option opt-data="new_brand" value="new_brand">+ Add a new Brand</option>';
                      echo $brands_option;
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-6 hidden">
                    <label for="new_brand">Add a new Brand</label>
                    <input type="text" class="form-control" name="new_brand" id="new_brand" value="">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-12 mb-3">
              <div class="form-group">
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <label for="category">Category</label><br>
                    <select class="form-control" name="category" id="category">
                      <?php 
                      $categories_option = "";
                      foreach($categories as $ccount => $catrow) {
                        if($catrow->id == $product['category']) {
                          $categories_option .= '<option value="'.$catrow->id.'" selected="selected">'.$catrow->name.'</option>';
                        }
                        else {
                          $categories_option .= '<option value="'.$catrow->id.'">'.$catrow->name.'</option>';
                        }
                      }
                      $categories_option .= '<option disabled>----------------------------------------------------</option>';
                      $categories_option .= '<option opt-data="new_category" value="new_category">+ Add a new Category</option>';
                      echo $categories_option;
                      ?>
                    </select>
                  </div>
                  <div class="col-12 col-sm-6 hidden">
                    <label for="new_category">Add a new Category</label>
                    <input type="text" class="form-control" name="new_category" id="new_category" value="">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-12 mb-3">
              <div class="form-group">
                <label for="supplier">Supplier</label>
                <select class="form-control" name="supplier" id="supplier">
                      <?php 
                      $suppliers_option = "";
                      foreach($suppliers as $supcount => $suprow) {
                        if($suprow->id == $product['supplier']){
                          $suppliers_option .= '<option value="'.$suprow->id.'">'.$suprow->name.'</option>';
                        }
                        else {
                          $suppliers_option .= '<option value="'.$suprow->id.'">'.$suprow->name.'</option>';
                        }
                      }
                      echo $suppliers_option;
                      ?>
                    </select>
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-2 mb-3">
              <div class="form-group">
                <label for="supplier_price">Supplier Price</label>
                <input type="text" class="form-control" name="supplier_price" id="supplier_price" value="<?php echo set_value('supplier_price', $product['supplier_price']); ?>">
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-2 mb-3">
              <div class="form-group">
                <label for="price">Regular Price</label>
                <input type="text" class="form-control" name="price" id="price" value="<?php echo set_value('price', $product['price']); ?>">
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-2 mb-3">
              <div class="form-group">
                <label for="unit_measure">Unit</label>
                <select class="form-control" name="unit_measure" id="unit_measure">
                  <option value="piece" selected="selected">Piece</option>
                  <option value="dozen">Dozen</option>
                  <option value="kilo">Kilo</option>
                  <option value="liter">Liter</option>
                  <option value="pack">Pack</option>
                  <option value="sack">Sack</option>~
                </select>
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-2 mb-3">
              <div class="form-group">
                <label for="stock_qty">Stock Quantity</label>
                <input type="text" class="form-control" name="stock_qty" id="stock_qty" value="<?php echo set_value('stock_qty', $product['stock_qty']); ?>">
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-2 mb-3">
              <div class="form-group">
                <label for="lowstock_alert">Low Stock Threshold</label>
                <input type="text" class="form-control" name="lowstock_alert" id="lowstock_alert" value="<?php echo set_value('lowstock_alert', $product['lowstock_alert']); ?>">
              </div>
            </div>

            <?php if(isset($validation)): ?>
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?php echo $validation->listErrors(); ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="row">
            <div class="col-12 col-md-11">
              <button type="submit" class="btn btn-primary">Save</button> | <a href="/products/<?php echo $product['id']; ?>">Cancel</a>
            </div>
            <div class="col-12 col-md-1 text-right">
              <a class="delete_product" href="#">Delete</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $(".delete_product").click(function() {
        if(confirm("Are you sure you want to delete this?")){
          $(this).attr("href", "/products/<?php echo $product['id']; ?>/delete");
        }
        else{
          return false;
        }
      });
    });
  </script>
</main>