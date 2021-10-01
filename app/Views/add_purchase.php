<?php 
// print_r($products);
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
      <a href="/incoming" class="mt-1 mb-2"><i class="fas fa-arrow-left"></i> Back to Incoming Stocks List</a>
      <h1>Add Purchase (Incoming Stocks)</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <form class="" action="/incoming/add" method="post">
          <div class="row">
            <div class="col col-12 col-sm-12 col-md-12 mb-3">
              <div class="row">
                <div class="col col-12 col-sm-12 col-md-4">
                  <div class="form-group">
                    <label for="receipt">Reference Number (Receipt)</label>
                    <input type="text" class="form-control" name="receipt" id="receipt" value="<?php echo set_value('receipt'); ?>">
                  </div>
                </div>

                <div class="col col-12 col-sm-12 col-md-4">
                  <div class="form-group">
                    <label for="supplier">Supplier</label>
                    <select class="form-control" name="supplier" id="supplier">
                      <option selected="true" disabled="disabled">Choose Supplier</option>
                      <?php 
                      $suppliers_option = "";
                      $supp = set_value('supplier');
                      foreach($suppliers as $supcount => $suprow) {
                        if($supp == $suprow->id){
                          $suppliers_option .= '<option value="'.$suprow->id.'" selected>'.$suprow->name.'</option>';
                        }
                        else {
                          $suppliers_option .= '<option value="'.$suprow->id.'">'.$suprow->name.'</option>';
                        }
                      }
                      echo $suppliers_option;
                      ?>
                    </select>
                    <div class="form-note"></div>
                  </div>
                </div>

                <div class="col col-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="date_purchased">Purchase Date</label>
                    <input type="text" class="form-control datepicker" name="date_purchased" id="date_purchased" autocomplete="off" value="<?php echo set_value('date_purchased'); ?>">
                    <div class="form-note"></div>
                  </div>
                </div>

                <div class="col col-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="eta">Estimated Arrival Date</label>
                    <input type="text" class="form-control datepicker" name="eta" id="eta" autocomplete="off" value="<?php echo set_value('eta'); ?>">
                    <div class="form-note"></div>
                  </div>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col col-12 col-sm-12 col-md-3">
                  <div class="form-group">
                    <h3>Total</h3>
                    <div class="show_checkout_total"></div>
                    <input type="hidden" class="form-control" id="checkout_total" name="total" value="">
                  </div>
                </div>

                <div class="col col-12 col-sm-12 col-md-6"></div>

                <div class="col col-12 col-sm-12 col-md-3 text-right">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="checkout_products" name="checkout_products" value="<?php echo set_value('checkout_products'); ?>">
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg">Save</button>
                </div>
              </div>
            </div>
            <div class="col col-12 col-sm-12 col-md-12 mb-3">
              <h5>Add Products</h5>
              <div class="row add-products-wrap">
                <div class="col col-12 col-sm-12 col-md-4">
                  <label for="products-select">Select Product</label>
                  <select class="products-select" id="products-select">
                    <option></option>
                    <?php
                    $product_options = "";
                    foreach($products as $pcount => $prow) {
                      if($prow->size != "") {
                        $product_options .= '<option value="'.$prow->id.'" data-price="'.$prow->price.'" data-unit="'.$prow->unit_measure.'" data-code="'.$prow->code.'">'.$prow->name.' -- ( '.$prow->size.' )</option>';
                      }
                      else {
                        $product_options .= '<option value="'.$prow->id.'" data-price="'.$prow->price.'" data-unit="'.$prow->unit_measure.'" data-code="'.$prow->code.'">'.$prow->name.'</option>';
                      }
                    }

                    echo $product_options;
                    ?>
                  </select>
                </div>
                <div class="col col-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="add_quantity">Quantity</label>
                    <input type="text" class="form-control" id="add_quantity" value="1">
                  </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="add_unit">Unit</label>
                    <input type="text" class="form-control" id="add_unit" value="" readonly>
                  </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-2">
                  <div class="form-group">
                    <label for="add_price">Supplier Price</label>
                    <input type="text" class="form-control" id="add_price" value="">
                  </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-2">
                  <div class="row mt-3">
                    <div class="col-12 col-sm-4">
                      <button id="add-product-to-list" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                </div>
              </div>

              <h3>Incoming Products List</h3>
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
              <div id="cart_items"></div>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.products-select').select2({
        placeholder: "Choose a Product",
      });

      $( "#date_purchased" ).datepicker();
      $( "#eta" ).datepicker();

      $('.datepicker').on('click', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");  
      });

      $('.products-select').on('select2:select', function () {
        $("#add_unit").val($('.products-select :selected').data("unit"));
      });

      var orderData = [];

      var savedProducts = $("#checkout_products").val();
      if(savedProducts != "") {
        prepopulateProducts(savedProducts);
        orderData = JSON.parse(savedProducts);
      }

      $('#add-product-to-list').click(function() {
        var addProductId = $('.products-select').val();
        var addProductText = $('.products-select :selected').text();
        var addQty = Number($('#add_quantity').val());
        var addUnit = $('.products-select :selected').data("unit");
        var addUnitPrice = Number($('#add_price').val());
        var addLineTotal = addQty * addUnitPrice;
        var checkoutTotal = Number($('#checkout_total').val());

        if(addProductId != "") {
          var alreadyAdded = 0;
          $.each(orderData, function(i, obj) {
            if(obj.pid == addProductId) {
              obj.qty += addQty;
              addLineTotal = addUnitPrice * obj.qty;
              obj.total = addLineTotal;
              checkoutTotal += addLineTotal;
              alreadyAdded = 1;
              $('.product-'+addProductId+' .show_qty').text(obj.qty);
              $('.product-'+addProductId+' .show_linetotal').text(thousands_separators(addLineTotal.toFixed(2)));
              $('#checkout_total').val(checkoutTotal);
              $('.show_checkout_total').text('Php '+thousands_separators(checkoutTotal.toFixed(2)));
              $('.products-select').val(null).trigger('change');
              $('#add_quantity').val(1);
              $('#add_unit').val("");
              $('#add_price').val("");
              return false;
            }
          });

          if(alreadyAdded == 0) {
            orderData.push({
              pid: addProductId,
              ptxt: addProductText,
              qty: addQty,
              qunit: addUnit,
              price: addUnitPrice,
              total: addLineTotal,
            });
            // orderData.chkTotal = checkoutTotal;

            checkoutTotal += addLineTotal;

            var addProduct = '<div class="row added_product product-'+addProductId+'">';
            addProduct += '<div class="col-12 col-sm-12 col-md-6 show_name">'+addProductText+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-6">';
            addProduct += '<div class="row">';
            addProduct += '<div class="col-12 col-sm-12 col-md-3 show_qty">'+addQty+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_unitprice">'+thousands_separators(addUnitPrice.toFixed(2))+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_unit">'+addUnit+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_linetotal">'+thousands_separators(addLineTotal.toFixed(2))+'</div>';
            addProduct += '</div>';
            addProduct += '</div>';
            addProduct += '</div>';
            $('#cart_items').prepend(addProduct);
            $('#checkout_total').val(checkoutTotal);
            $('.show_checkout_total').text('Php '+thousands_separators(checkoutTotal.toFixed(2)));
            $('.products-select').val(null).trigger('change');
            $('#add_quantity').val(1);
            $('#add_unit').val("");
            $('#add_price').val("");
          }

          $("#checkout_products").val(JSON.stringify(orderData));

          // console.log(orderData);
          console.log(checkoutTotal);
        }
        return false;
      });
    });
  </script>
</main>