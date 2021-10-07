<?php
// print_r(session()->get());
// print_r($supplier);

$output = "";
$role = session()->get('role');
?>
<main class="withpadding">
<div class="row">
  <?php if(session()->get('success')): ?>
    <div class="col col-12 col-md-12 mt-3 pt-3 pb-3 alert alert-success" role="alert">
      <?php echo session()->get('success'); ?>
    </div>
  <?php endif; ?>
  <div class="col-12 col-md-10 mt-3 pt-3 pb-3 bg-white">
    <h1>Dashboard</h1>
  </div>
</div>

<div class="row">
  <div class="col-12 mt-3 pt-3 pb-3 bg-white">
    <table id="products_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
      <thead>
          <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Size</th>
            <?php if($role == 'admin'): ?>
            <th>Supplier Price</th>
            <?php endif; ?>
            <th>Price</th>
            <th>Available Stocks</th>
            <?php if($role == 'admin'): ?>
            <th>Action</th>
            <?php endif; ?>
          </tr>
      </thead>
      <tbody>
          <?php 
          foreach($products as $row) {
            $output .= '<tr>';
            $output .= '<td class="name"><a href="/products/'.$row->id.'" class="view-link-data">'.$row->name.'</a></td>';
            $output .= '<td>'.$row->code.'</td>';
            $output .= '<td>'.$row->size.'</td>';
            if($role == 'admin') {
              $output .= '<td>'.number_format($row->supplier_price, 2, '.', ',').'</td>';
            }
            $output .= '<td>'.number_format($row->price, 2, '.', ',').'</td>';
            $output .= '<td>'.number_format($row->stock_qty, 2, '.', ',').'</td>';
            if($role == 'admin') {
              $output .= '<td><a href="/products/'.$row->id.'/edit" class="edit-product edit-product-'.$row->id.'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
              $output .= '<a href="/products/'.$row->id.'/delete" class="delete delete-product delete-product-'.$row->id.'" data-id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a></td>';
            }
            $output .= '</tr>';
          }

          echo $output;
          ?>
      </tbody>
      <tfoot>
          <tr>
          <th>Name</th>
            <th>Code</th>
            <th>Size</th>
            <?php if($role == 'admin'): ?>
            <th>Supplier Price</th>
            <?php endif; ?>
            <th>Price</th>
            <th>Available Stocks</th>
            <?php if($role == 'admin'): ?>
            <th>Action</th>
            <?php endif; ?>
          </tr>
      </tfoot>
    </table>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#products_list').DataTable();

    $(".delete-product").click(function() {
      if(confirm("Are you sure you want to delete this?")){
        var deleteId = $(this).attr('data-id');
        $(this).attr("href", "/products/"+ deleteId +"/delete");
      }
      else{
        return false;
      }
    });
  });
</script>

</main>