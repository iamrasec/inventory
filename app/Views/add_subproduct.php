<?php 
// print_r($brands);
?>
<main class="withpadding">
  <div class="row">
    <?php if(session()->get('success')): ?>
      <div class="col col-12 col-md-12 mt-3 pt-3 pb-3 alert alert-success" role="alert">
        <?php echo session()->get('success'); ?>
      </div>
    <?php endif; ?>
    <?php if(isset($validation)): ?>
      <div class="col-12">
        <div class="col col-12 col-md-12 mt-3 pt-3 pb-3alert alert-danger" role="alert">
          <?php echo $validation->listErrors(); ?>
        </div>
      </div>
    <?php endif; ?>
    <div class="col-12 col-md-10 mt-3 pt-3 pb-3 bg-white">
      <a href="/products" class="mt-1 mb-2"><i class="fas fa-arrow-left"></i> Back to Inventory List</a>
      <h1>Add Sub-Product</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <form class="" action="/products/add" method="post">
          <div class="row">
            <div class="col-12 col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>">
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3 mb-3">
              <div class="form-group">
                <label for="stock_qty">Stock Quantity</label>
                <input type="text" class="form-control" name="stock_qty" id="stock_qty" value="<?php echo set_value('stock_qty'); ?>">
              </div>
            </div>

            <div class="col-6 col-sm-6 col-md-3 mb-3">
              <div class="form-group">
                <label for="unit_measure">Unit</label>
                <select class="form-control" name="unit_measure" id="unit_measure">
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

            <?php if(isset($validation)): ?>
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?php echo $validation->listErrors(); ?>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
              <h5>Conversion:</h5>
            </div>
          </div>
          
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Save</button> | <a href="/products">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#brand').select2();
      $('#category').select2();
    });
  </script>

</main>