<?php
// print_r(session()->get());
// print_r($products);

$output = "";
$role = session()->get('role');
date_default_timezone_set('Asia/Manila');

$today = date("F j, Y");

$incoming_list = "";
$received_list = "";

foreach($products as $row) {
  if($row->status == 0) {
    $incoming_list .= '<tr>';
    $incoming_list .= '<td>'.$row->receipt.'</td>';
    if($row->size != "") {
      $incoming_list .= '<td>'.$row->product_name.' -- ( '.$row->size.' )</td>';
    }
    else {
      $incoming_list .= '<td>'.$row->product_name.'</td>';
    }
    
    $incoming_list .= '<td>'.number_format($row->qty, 2, '.', ',').'</td>';
    $incoming_list .= '<td>'.$row->supplier_name.'</td>';
    $incoming_list .= '<td>'.date("F j, Y", strtotime($row->purchase_date)).'</td>';
    $incoming_list .= '<td>'.date("F j, Y", strtotime($row->eta)).'</td>';
    $incoming_list .= '<td>'.(($row->status == 0) ? "in-transit" : "received").'</td>';
    if($role == 'admin') {
      $incoming_list .= '<td>';
      $incoming_list .= '<a href="/incoming/'.$row->id.'/received" class="release-sales release-sales-'.$row->id.'" title="Confirm release"><i class="fas fa-check"></i> Received</a>&nbsp;&nbsp;&nbsp;';
      $incoming_list .= '<a href="/incoming/'.$row->id.'/edit" class="edit-incoming edit-incoming-'.$row->id.'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
      $incoming_list .= '<a href="/incoming/'.$row->id.'/delete" class="delete-incoming delete-incoming-'.$row->id.'"><i class="fas fa-trash-alt"></i></a>';
      $incoming_list .= '</td>';
    }
    $incoming_list .= '</tr>';
  }
  else {
    $received_list .= '<tr>';
    $received_list .= '<td>'.$row->receipt.'</td>';
    if($row->size != "") {
      $received_list .= '<td>'.$row->product_name.' -- ( '.$row->size.' )</td>';
    }
    else {
      $received_list .= '<td>'.$row->product_name.'</td>';
    }
    
    $received_list .= '<td>'.number_format($row->qty, 2, '.', ',').'</td>';
    $received_list .= '<td>'.$row->supplier_name.'</td>';
    $received_list .= '<td>'.date("F j, Y", strtotime($row->purchase_date)).'</td>';
    $received_list .= '<td>'.date("F j, Y", strtotime($row->eta)).'</td>';
    $received_list .= '<td>'.(($row->status == 0) ? "in-transit" : "received").'</td>';
    if($role == 'admin') {
      $received_list .= '<td>';      
      $received_list .= '</td>';
    }
    $received_list .= '</tr>';
  }
}

?>
<main class="withpadding">
<div class="row">
  <div class="col-12 col-md-10 mt-3 pt-3 pb-3 bg-white">
    <h1>Incoming Stocks</h1>
  </div>
  <div class="col-12 col-md-2 mt-3 pt-3 pb-3 bg-white">
    <?php if($role == 'admin'): ?>
    <a href="/incoming/add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Purchases</a>
    <?php endif; ?>
  </div>
</div>

<div class="row">
  <div class="col-12 mt-3 pt-3 pb-3 bg-white">
    <h4>Incoming list</h4>
    <table id="products_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
      <thead>
          <tr>
            <th>Receipt</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>Purchase Date</th>
            <th>ETA</th>
            <th>Status</th>
            <?php if($role == 'admin'): ?>
            <th>Action</th>
            <?php endif; ?>
          </tr>
      </thead>
      <tbody>
        <?php echo $incoming_list; ?>
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

<br />
<hr />

<div class="row">
  <div class="col-12 mt-3 pt-3 pb-3 bg-white">
    <h4>Received List</h4>
    <table id="received_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
      <thead>
          <tr>
            <th>Receipt</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Supplier</th>
            <th>Purchase Date</th>
            <th>ETA</th>
            <th>Status</th>
            <?php if($role == 'admin'): ?>
            <th>Action</th>
            <?php endif; ?>
          </tr>
      </thead>
      <tbody>
        <?php echo $received_list; ?>
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
  $(document).ready(function() {
    $('#received_list').DataTable();
  });
</script>

</main>