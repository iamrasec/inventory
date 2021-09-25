<?php 
  $uri = service('uri');
  $isLoggedIn = session()->get('isLoggedIn');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">-->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="/assets/css/select2.min.css" />
    <link rel="stylesheet" href="/assets/css/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/css/fontawesome.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />

    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    <script type="text/javascript" src="/assets/fontawesome/js/all.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="/assets/js/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/datepicker.min.js"></script>
    <title><?php echo ucfirst($uri->getSegment(1)); ?></title>
  </head>
  <body>

  <div class="container-fluid">
    <div class="row">
      <div class="col col-12 col-sm-12 col-md-4 bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Inventory Management System</a>            
        </nav>
      </div>
      <div class="col col-12 col-sm-12 col-md-8 bg-dark pt-2">
        <?php if($isLoggedIn == 1): ?>
          <div class="row">
            <div class="col col-12 col-sm-12 col-md-8">
              <a href="/" class="btn btn-primary"><i class="fas fa-box"></i> Inventory</a>
              <a href="/incoming" class="btn btn-warning"><i class="fas fa-truck-moving"></i> Incoming Stocks</a>
              <a href="/sales" class="btn btn-success"><i class="fas fa-shopping-cart"></i> Sales List</a>
              <a href="/sales/add" class="btn btn-danger"><i class="fas fa-plus"></i> Create Sales</a>
            </div>
            <div class="col col-12 col-sm-12 col-md-4">
              <a class="nav-link nav-logout-link" href="/logout">Logout <i class="fas fa-power-off"></i></a>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col col-12 col-sm-12 col-md-12">

  