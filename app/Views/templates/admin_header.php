<?php 
  $uri = service('uri');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">-->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="/assets/css/select2.min.css" />
    <link rel="stylesheet" href="/assets/css/datepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/css/fontawesome.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />

    <script type="text/javascript" src="/assets/fontawesome/js/all.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/assets/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="/assets/js/select2.min.js"></script>
    <script type="text/javascript" src="/assets/js/datepicker.min.js"></script>
    <script type="text/javascript" src="/assets/js/scripts.js"></script>
    <title>Inventory Management System</title>
  </head>
  <body>

  <div class="container-fluid">
    <div class="row">
      <div class="sidebarMenu-wrapper col col-sm-12 col-md-3 col-lg-2 bg-dkblue">
        <nav id="sidebarMenu" class="d-md-block text-light bg-dkblue sidebar collapse">
          <div class="position-sticky pt-3">
            <div class="company_logo mb-3">Controller</div>
            <hr />
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link <?php echo ($uri->getSegment(1) == 'dashboard' ? 'active' : null); ?>" aria-current="page" href="/dashboard">
                  <i class="fas fa-home"></i> Dashboard
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo (($uri->getSegment(1) == 'incoming' && $uri->getSegment(2) == '') ? 'active' : null); ?>" aria-current="page" href="/incoming">
                  <i class="fas fa-truck-moving"></i> Incoming Stocks
                </a>
                <ul class="submenu">
                  <li><a class="nav-link <?php echo (($uri->getSegment(1) == 'incoming' && $uri->getSegment(2) == 'add') ? 'active' : null); ?>" href="/incoming/add">Add Purchases</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo (($uri->getSegment(1) == 'sales' && $uri->getSegment(2) == '') ? 'active' : null); ?>" aria-current="page" href="/sales">
                  <i class="fas fa-shopping-cart"></i> Sales
                </a>
                <ul class="submenu">
                  <li><a class="nav-link <?php echo (($uri->getSegment(1) == 'sales' && $uri->getSegment(2) == 'add') ? 'active' : null); ?>" href="/sales/add">Create Sales Order</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo (($uri->getSegment(1) == 'products' && $uri->getSegment(2) == '') ? 'active' : null); ?>" aria-current="page" href="/products">
                  <i class="fas fa-box"></i> Current Inventory
                </a>
                <ul class="submenu">
                  <li><a class="nav-link <?php echo (($uri->getSegment(1) == 'products' && $uri->getSegment(2) == 'add') ? 'active' : null); ?>" href="/products/add">Add Product</a></li>
                  <li><a class="nav-link <?php echo ($uri->getSegment(1) == 'suppliers' ? 'active' : null); ?>" href="/suppliers">List Suppliers</a></li>
                  <!--<li><a class="nav-link" href="#">Brands</a></li>-->
                  <!--<li><a class="nav-link" href="#">Categories</a></li>-->
                </ul>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-user-friends"></i> Users
                </a>
              </li>-->
              <!--<li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-chart-bar"></i> Reports
                </a>
              </li>-->
            </ul>
          </div>
        </nav>
      </div>
      <div class="col col-sm-12 col-md-9 col-lg-10 nopadding">
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow full-width">
          <div class="navbar-brand col-md-3 col-lg-2 me-0 px-3"><?php echo ucwords(str_replace("-", " ", $uri->getSegment(1))); ?></div>
          
          <div class="navbar-nav logout-link">
            <div class="nav-item text-nowrap">
              <a class="nav-link nav-profile-link" href="/profile"><i class="fas fa-user"></i> <?php echo ucwords(session()->get('username')); ?></a> | <a class="nav-link nav-logout-link" href="/logout">Logout <i class="fas fa-power-off"></i></a>
            </div>
          </div>
        </header>
      

