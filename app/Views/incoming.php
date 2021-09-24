<?php
// print_r(session()->get());
// print_r($supplier);

$output = "";
?>
<main class="withpadding">
<div class="row">
  <div class="col-12 col-md-10 mt-3 pt-3 pb-3 bg-white">
    <h1>Incoming Stocks</h1>
  </div>
  <div class="col-12 col-md-2 mt-3 pt-3 pb-3 bg-white">
    <a href="/products/add" class="btn btn-primary"><i class="fas fa-plus"></i> Create Sales</a>
  </div>
</div>

<div class="row">
  <div class="col-12 mt-3 pt-3 pb-3 bg-white">
    <table id="products_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
      <thead>
          <tr>
            <th>ID</th>
            <th>Receipt No.</th>
            <th>Products</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <?php 
          foreach($products as $row) {
            $output .= '<tr>';
            $output .= '<td class="name"><a href="/suppliers/'.$row->id.'" class="view-link-data">'.$row->name.'</a></td>';
            $output .= '<td>'.$row->code.'</td>';
            $output .= '<td>'.$row->size.'</td>';
            $output .= '<td>'.$row->supplier_price.'</td>';
            $output .= '<td>'.$row->price.'</td>';
            $output .= '<td>'.$row->stock_qty.'</td>';
            $output .= '<td><a href="/products/'.$row->id.'/edit" class="edit-product edit-product-'.$row->id.'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="/products/'.$row->id.'/delete" class="delete-product delete-product-'.$row->id.'"><i class="fas fa-trash-alt"></i></a></td>';
            $output .= '</tr>';
          }

          echo $output;
          ?>
      </tbody>
      <tfoot>
          <tr>
            <th>ID</th>
            <th>Receipt No.</th>
            <th>Products</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
      </tfoot>
    </table>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#products_list').DataTable();
  });
</script>

</main>