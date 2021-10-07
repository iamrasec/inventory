<?php
// print_r(session()->get());
// print_r($supplier);

$output = "";
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
      <h1>List Suppliers</h1>
    </div>
    <div class="col-12 col-md-2 mt-3 pt-3 pb-3 bg-white">
      <a href="/suppliers/add" class="btn btn-primary"><i class="fas fa-truck"></i> Add Suppliers</a>
    </div>
  </div>

  <div class="row">
    <div class="col-12 mt-3 pt-3 pb-3 bg-white">
      <table id="suppliers_list" class="table table-striped table-bordered custom-list-table" style="width:100%">
        <thead>
            <tr>
              <th>Name</th>
              <th>Code</th>
              <!--<th>Street Address</th>-->
              <!--<th>Barangay</th>-->
              <th>City</th>
              <!--<th>Province</th>-->
              <!--<th>Zip Code</th>-->
              <th>Phone Number</th>
              <th>Mobile Number</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($supplier as $row) {
              $output .= '<tr>';
              $output .= '<td class="name"><a href="/suppliers/'.$row->id.'" class="view-link-data">'.$row->name.'</a></td>';
              $output .= '<td>'.$row->code.'</td>';
              // $output .= '<td>'.$row->street_address.'</td>';
              // $output .= '<td>'.$row->barangay.'</td>';
              $output .= '<td>'.$row->city.'</td>';
              // $output .= '<td>'.$row->province.'</td>';
              // $output .= '<td>'.$row->zip_code.'</td>';
              $output .= '<td>'.$row->phone.'</td>';
              $output .= '<td>'.$row->mobile.'</td>';
              $output .= '<td><a href="/suppliers/'.$row->id.'/edit" class="edit-supplier edit-supplier-'.$row->id.'"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;';
              $output .= '<a href="/suppliers/'.$row->id.'/delete" class="delete delete-supplier delete-supplier-'.$row->id.'" data-id="'.$row->id.'"><i class="fas fa-trash-alt"></i></a></td>';
              $output .= '</tr>';
            }

            echo $output;
            ?>
        </tbody>
        <tfoot>
            <tr>
              <th>Name</th>
              <th>Code</th>
              <!--<th>Street Address</th>-->
              <!--<th>Barangay</th>-->
              <th>City</th>
              <!--<th>Province</th>-->
              <!--<th>Zip Code</th>-->
              <th>Phone Number</th>
              <th>Mobile Number</th>
              <th>Action</th>
            </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#suppliers_list').DataTable();

      $(".delete-supplier").click(function() {
        if(confirm("Are you sure you want to delete this?")){
          var deleteId = $(this).attr('data-id');
          $(this).attr("href", "/suppliers/"+ deleteId +"/delete");
        }
        else{
          return false;
        }
      });
    });
  </script>

</main>