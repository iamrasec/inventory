<?php
// print_r(session()->get());
// print_r($products);

$output = "";
$role = session()->get('role');
?>
<main class="withpadding">
<div class="row">
  <div class="col-12 col-md-10 mt-3 pt-3 pb-3 bg-white">
    <h1>Incoming Stocks</h1>
  </div>
  <div class="col-12 col-md-2 mt-3 pt-3 pb-3 bg-white">
    <a href="/incoming/add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Purchases</a>
  </div>
</div>

<div class="row">
  <div class="col-12 mt-3 pt-3 pb-3 bg-white">
    <table id="products_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
      <thead>
          <tr>
            <th>Receipt</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>ETA</th>
            <?php if($role == 'admin'): ?>
            <th>Action</th>
            <?php endif; ?>
          </tr>
      </thead>
      <tbody>
          <?php 
          foreach($products as $row) {
            $output .= '<tr>';
            $output .= '<td>'.$row->receipt.'</td>';
            if($row->size != "") {
              $output .= '<td>'.$row->product_name.' -- ( '.$row->size.' )</td>';
            }
            else {
              $output .= '<td>'.$row->product_name.'</td>';
            }
            
            $output .= '<td>'.number_format($row->qty, 2, '.', ',').'</td>';
            $output .= '<td>'.$row->supplier_name.'</td>';
            $output .= '<td>'.$row->eta.'</td>';
            if($role == 'admin') {
              $output .= '<td>';
              $output .= '<a href="/incoming/'.$row->id.'/received" class="release-sales release-sales-'.$row->id.'" title="Confirm release"><i class="fas fa-check"></i> Received</a>&nbsp;&nbsp;&nbsp;';
              // $output .= '<a href="/incoming/'.$row->id.'/edit" class="edit-product edit-product-'.$row->id.'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
              // $output .= '<a href="/incoming/'.$row->id.'/delete" class="delete-product delete-product-'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
              $output .= '</td>';
            }
            $output .= '</tr>';
          }

          echo $output;
          ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Receipt</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>ETA</th>
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
  });
</script>

</main>