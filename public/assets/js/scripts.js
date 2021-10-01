function thousands_separators(num) {
  var num_parts = num.toString().split(".");
  num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return num_parts.join(".");
}

function prepopulateProducts(orderData) {
  console.log(orderData);

  var obj = JSON.parse(orderData);
  var checkoutTotal = 0;

  $(obj).each(function() {
    console.log(this.pid);
    console.log(this.ptxt);

    var addProductId = this.pid;
    var addProductText = this.ptxt;
    var addQty = Number(this.qty);
    var addUnit = this.qunit;
    var addUnitPrice = Number(this.price);
    var addLineTotal = addQty * addUnitPrice;
    
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
  });

  // console.log(obj[0].pid);
  // console.log(obj[0].ptxt);
}

(function($) {
  $(document).ready(function() {
    $('.btn-disabled').on('click',function(event){
      event.preventDefault();
    });
  });
})(jQuery);