<?php
// print_r(session()->get());
// print_r($sales);

$output = "";

$role = session()->get('role');
date_default_timezone_set('Asia/Manila');

$today = date("F j, Y");

/* $date = new DateTime();
$timeZone = $date->getTimezone();
echo $timeZone->getName(); */
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
    <h1>Sales List</h1>
  </div>
  <div class="col-12 col-md-2 mt-3 pt-3 pb-3 bg-white">
    <?php if($role == 'admin'): ?>
    <a href="/sales/add" class="btn btn-primary"><i class="fas fa-plus"></i> Create Sales</a>
    <?php endif; ?>
  </div>
</div>

<div class="row">
  <div class="col-12 mt-3 pt-3 pb-3 bg-white">
    <table id="sales_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
      <thead>
          <tr>
            <th>Sales Order No.</th>
            <th>Receipt No.</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Action</th>
          </tr>
      </thead>
      <tbody>
          <?php 
          foreach($sales as $row) {
            $order_date = date("F j, Y", strtotime($row->order_date));

            if($order_date == $today) {
              $output .= '<tr>';
              $output .= '<td><a href="/sales/'.$row->id.'" title="View Order Details">'.$row->id.'</a></td>';
              $output .= '<td><a href="/sales/'.$row->id.'" title="View Order Details">'.$row->receipt.'</a></td>';
              $output .= '<td>'.$row->customer.'</td>';
              $output .= '<td>Php '.number_format($row->total, 2, '.', ',').'</td>';
              $output .= '<td>'.(($row->status == "0") ? "pending" : "released").'</td>';
              $output .= '<td>'.date("F j, Y g:i A", strtotime($row->order_date)).'</td>';
              $output .= '<td>';
              if($row->status == "0") {
                $output .= '<a href="/sales/'.$row->id.'/release" class="release-sales release-sales-'.$row->id.'" title="Confirm release"><i class="fas fa-check"></i> Release</a>';
                // $output .= '<a href="/sales/'.$row->id.'/release" class="release-sales release-sales-'.$row->id.'" title="Confirm release"><i class="fas fa-check"></i></a>&nbsp;&nbsp;&nbsp;';
                // $output .= '<a href="/sales/'.$row->id.'/edit" class="edit-sales edit-sales-'.$row->id.'" title="Edit Order Data"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
              }
              $output .= '&nbsp;&nbsp;&nbsp;<a href="/sales/'.$row->id.'/delete" class="delete delete-sales delete-sales-'.$row->id.'" title="Delete Order"><i class="fas fa-trash-alt"></i></a>';
              $output .= '</td>';
              $output .= '</tr>';
            }
          }

          echo $output;
          ?>
      </tbody>
      <tfoot>
          <tr>
            <th>Sales Order No.</th>
            <th>Receipt No.</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Order Date</th>
            <th>Action</th>
          </tr>
      </tfoot>
    </table>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#sales_list').DataTable({
      "order": [[0, "desc"]],
    });
  });
</script>

</main>