<?php 
  $uri = service('uri');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">-->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/css/fontawesome.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />

    <script type="text/javascript" src="/assets/fontawesome/js/all.js"></script>
    <title><?php echo ucfirst($uri->getSegment(1)); ?></title>
  </head>
  <body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-lg-12 bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">Inventory</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            
            </div>
        </nav>
      </div>
      <div class="col-md-12 col-lg-12">

  