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
      <a href="/sales" class="mt-1 mb-2"><i class="fas fa-arrow-left"></i> Back to Sales List</a>
      <h1>Create Sales</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 mt-3 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <form class="" action="/sales/add" method="post">
          <div class="row">
            <div class="col col-12 col-sm-12 col-md-3 mb-3 form_reference_area">
              <div class="form-group">
                <label for="receipt">Reference Number (Receipt)</label>
                <input type="text" class="form-control" name="receipt" id="receipt" value="<?php echo set_value('receipt'); ?>">
              </div>

              <div class="form-group">
                <label for="customer">Customer Name</label>
                <input type="text" class="form-control" name="customer" id="customer" value="<?php echo set_value('customer'); ?>">
                <div class="form-note"></div>
              </div>

              <hr class="mt-3 mb-3">

              <div class="row">
                <div class="col col-12 col-sm-12 col-md-12">
                  <div class="form-group">
                    <h3>Total</h3>
                    <div class="show_checkout_total"></div>
                    <input type="hidden" class="form-control" id="checkout_total" name="total" value="">
                  </div>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-12 col-sm-4">
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="checkout_products" name="checkout_products" value="">
                  </div>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>

            <div class="col col-12 col-sm-12 col-md-9 mb-3">
              <h5>Add Products to Cart</h5>
              <div class="row add-products-wrap">
                <div class="col col-12 col-sm-12 col-md-6">
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
                  <div class="row mt-3">
                    <div class="col-12 col-sm-4">
                      <button id="add-product-to-list" class="btn btn-primary">Add</button>
                    </div>
                  </div>
                </div>
              </div>

              <h3>Cart Items</h3>
              <div class="row">
                <div class="col col-12 col-sm-12 col-md-4 show_name_header"><strong>Product Name</strong></div>
                <div class="col col-12 col-sm-12 col-md-8">
                  <div class="row">
                    <div class="col col-12 col-sm-12 col-md-2 show_qty_header"><strong>Qty</strong></div>
                    <div class="col col-12 col-sm-12 col-md-2 show_unitprice_header"><strong>Price</strong></div>
                    <div class="col col-12 col-sm-12 col-md-2 show_discounted_price_header"><strong>Discount Price</strong></div>
                    <div class="col col-12 col-sm-12 col-md-2 show_unit_header"><strong>Unit</strong></div>
                    <div class="col col-12 col-sm-12 col-md-2 show_linetotal_header"><strong>Total</strong></div>
                    <div class="col col-12 col-sm-12 col-md-2 show_action_header"><strong>Action</strong></div>
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

      $('.products-select').on('select2:select', function () {
        $("#add_unit").val($('.products-select :selected').data("unit"));
      });

      var orderData = [];

      $('#add-product-to-list').click(function() {
        var addProductId = $('.products-select').val();
        var addProductText = $('.products-select :selected').text();
        var addQty = Number($('#add_quantity').val());
        var addUnit = $('.products-select :selected').data("unit");
        var addUnitPrice = Number($('.products-select :selected').data("price"));
        var addLineTotal = addQty * addUnitPrice;
        var checkoutTotal = Number($('#checkout_total').val());
        var isDiscounted = 0;
        var DiscountedPrice = 0;
        var DiscountedTotal = 0;

        if(addProductId != "") {
          var alreadyAdded = 0;
          $.each(orderData, function(i, obj) {
            if(obj.pid == addProductId) {
              isDiscounted = obj.isDiscounted;
              DiscountedPrice = obj.DiscountedPrice;
              DiscountedTotal = obj.DiscountedTotal;
              obj.qty += addQty;
              addLineTotal = addUnitPrice * obj.qty;
              obj.total = addLineTotal;
              checkoutTotal += (addUnitPrice * addQty);
              alreadyAdded = 1;
              $('.product-'+addProductId+' .show_qty').text(obj.qty);
              $('.product-'+addProductId+' .show_linetotal').text(thousands_separators(addLineTotal.toFixed(2)));
              $('#checkout_total').val(checkoutTotal);
              $('.show_checkout_total').fadeOut(10).text('Php '+thousands_separators(checkoutTotal.toFixed(2))).fadeIn(10);
              $('.products-select').val(null).trigger('change');
              $('#add_quantity').val(1);
              $('#add_unit').val("");
              return false;
            }
          });

          if(alreadyAdded == 0) {
            orderData.push({
              pid: addProductId,
              qty: addQty,
              price: addUnitPrice,
              total: addLineTotal,
              isDiscounted: isDiscounted,
              DiscountedPrice: DiscountedPrice,
              DiscountedTotal: DiscountedTotal,
            });

            checkoutTotal += addLineTotal;

            var addProduct = '<div class="row added_product product-'+addProductId+'">';
            addProduct += '<div class="col-12 col-sm-12 col-md-4 show_name">'+addProductText+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-8">';
            addProduct += '<div class="row">';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_qty">'+addQty+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_unitprice">'+thousands_separators(addUnitPrice.toFixed(2))+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_discounted_price"><input type="text" name="discprice-'+addProductId+'" class="discount-price" data-pid="'+addProductId+'" /></div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_unit">'+addUnit+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 show_linetotal">'+thousands_separators(addLineTotal.toFixed(2))+'</div>';
            addProduct += '<div class="col-12 col-sm-12 col-md-2 delete_line_product"><a href="#" data-delid="'+addProductId+'">X</a></div>';
            addProduct += '</div>';
            addProduct += '</div>';
            addProduct += '</div>';
            $('#cart_items').prepend(addProduct);
            $('#checkout_total').val(checkoutTotal);
            $('.show_checkout_total').fadeOut(10).text('Php '+thousands_separators(checkoutTotal.toFixed(2))).fadeIn(10);
            $('.products-select').val(null).trigger('change');
            $('#add_quantity').val(1);
            $('#add_unit').val("");
          }

          $("#checkout_products").val(JSON.stringify(orderData));

          // console.log(orderData);
          console.log(checkoutTotal);
        }
        return false;
      });

      $(document).on('change', ".added_product .discount-price", function() {
        console.log("Added discount");

        var discountVal = Number($(this).val());
        var isDiscounted = 0;
        var DiscountedPrice = 0;
        var DiscountedTotal = 0;
        var LineTotal = 0;
        var DiscountDiff = 0;
        var checkoutTotal = Number($('#checkout_total').val());
        var addProductId = $(this).data("pid");

        console.log('Current Total: '+checkoutTotal);

        if(discountVal != "" && discountVal > 0) {
          isDiscounted = 1;
          DiscountedPrice = discountVal;
        }
        else {
          isDiscounted = 0;
          DiscountedPrice = 0;
        }

        $.each(orderData, function(i, obj) {
          if(obj.pid == addProductId) {
            obj.isDiscounted = isDiscounted;
            obj.DiscountedPrice = DiscountedPrice;
            LineTotal = obj.total;
            DiscountedTotal = DiscountedPrice * obj.qty;
            obj.DiscountedTotal = DiscountedTotal;
            console.log('Line Total: '+LineTotal);
            console.log('Discounted Total: '+DiscountedTotal);
            return false;
          }
        });

        DiscountDiff = LineTotal - DiscountedTotal;
        console.log('Discounted Difference: '+DiscountDiff);

        if(DiscountDiff > 0) {
          checkoutTotal -= DiscountDiff;
          $('#checkout_total').val(checkoutTotal);
          $('.show_checkout_total').fadeOut(10).text('Php '+thousands_separators(checkoutTotal.toFixed(2))).fadeIn(10);
        }

        $("#checkout_products").val(JSON.stringify(orderData));

        console.log(orderData);
        console.log('Discount Price: '+discountVal);
        console.log('isDiscounted: '+isDiscounted);
        console.log('Discounted Price: '+DiscountedPrice);
        console.log('Product ID: '+addProductId);
      });

      $(document).on('click', ".delete_line_product a", function() {
        console.log("Delete Line Item");

        var delProductID = $(this).data('delid');
        var checkoutTotal = Number($('#checkout_total').val());

        console.log(delProductID);

        var remArrID = 0;
        $.each(orderData, function(i, obj) {
          if(obj.pid == delProductID) {
            remArrID = i;
            if(obj.isDiscounted == 1) {
              checkoutTotal -= obj.DiscountedTotal;
            }
            else {
              checkoutTotal -= obj.total;
            }
          }
        });

        orderData.splice(remArrID,1);

        /* $.each(orderData, function(i) {
          var obj = $(orderData).eq(0);
          if(obj.pid == delProductID) {
            orderData.splice(0,1);
          }
        }); */

        console.log(orderData);

        $('#checkout_total').val(checkoutTotal);
        $('.show_checkout_total').fadeOut(10).text('Php '+thousands_separators(checkoutTotal.toFixed(2))).fadeIn(10);

        $("#checkout_products").val(JSON.stringify(orderData));

        $("#cart_items .product-"+delProductID).remove();

        return false;
      });
    });
  </script>
</main>