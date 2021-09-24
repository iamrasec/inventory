<main class="withpadding">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
      <h1>Add Suppliers</h1>    
    </div>

    <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
        <form class="" action="/suppliers/add" method="post">
          <div class="row">
            <div class="col-sm-12 col-md-10 mb-3">
              <div class="form-group">
                <label for="name">Supplier Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name'); ?>">
              </div>
            </div>

            <div class="col-sm-12 col-md-2 mb-3">
              <div class="form-group">
                <label for="code">Supplier Code</label>
                <input type="text" class="form-control" name="code" id="code" value="<?php echo set_value('code'); ?>">
                <div class="form-note"></div>
              </div>
            </div>

            <div class="col-sm-12 col-md-12 mb-3">
              <div class="form-group">
                <label for="street_address">Street Address</label>
                <input type="text" class="form-control" name="street_address" id="street_address" value="<?php echo set_value('street_address'); ?>">
              </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="barangay">Barangay</label>
                <input type="text" class="form-control" name="barangay" id="barangay" value="<?php echo set_value('barangay'); ?>">
              </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city'); ?>">
              </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="province">Province</label>
                <input type="text" class="form-control" name="province" id="province" value="<?php echo set_value('province'); ?>">
              </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="zip_code">Zip Code</label>
                <input type="text" class="form-control" name="zip_code" id="zip_code" value="<?php echo set_value('zip_code'); ?>">
              </div>
            </div>

            <div class="col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo set_value('phone'); ?>">  
              </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-3">
              <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo set_value('mobile'); ?>">  
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
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Save</button> | <a href="/suppliers">cancel</a>
            </div>
          </div>
        </form>
    </div>
  </div>
</main>