<?php require_once "/var/www/skyysystems.com/public_html/user/session.php"; ?>
<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asia Direct ERP | <?php echo basename($_SERVER['PHP_SELF']); ?></title>
  <!--STYLES--> 
  <?php 
    if (isset($datePicker))
      require_once "/var/www/skyysystems.com/public_html/assets/datePicker.html";
    else
      echo "<script src='/assets/jquery-3.3.1.js'></script>";
  ?>
  <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/spunky.css">
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
  <a class="navbar-brand" href="../../home.php">Asia Direct</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav mr-auto">
      <li <?php if ($tab=="inventory") echo " class=\"nav-item dropdown active\""; else echo " class=\"nav-item dropdown\""; ?>>
        <a class="nav-link dropdown-toggle" id="inventoryDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Inventory
        </a>
        <div class="dropdown-menu" aria-labelledby="inventoryDropdown">
          <a class="dropdown-item" href="/products/inventory.php">View Products</a>
          <a class="dropdown-item" href="/products/addProduct.php">Add Product</a>
          <a class="dropdown-item" href="/products/editProduct.php">Edit Product</a>
        </div>
      </li>
      <li <?php if ($tab=="purchaseOrders") echo " class=\"nav-item dropdown active\""; else echo " class=\"nav-item dropdown\""; ?>>
        <a class="nav-link dropdown-toggle" id="poDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Purchase Orders
        </a>
        <div class="dropdown-menu" aria-labelledby="poDropdown">
          <a class="dropdown-item" href="/purchaseOrders/purchaseOrders.php">View Orders</a>
          <a class="dropdown-item" href="/purchaseOrders/poForm/purchaseOrderForm.php">Create Order</a>
        </div>
      </li>
      <li <?php if ($tab=="customerOrders") echo " class=\"nav-item active\""; else echo " class=\"nav-item\""; ?>> 
        <a class="nav-link" href="/customerOrders/customerOrders.php">Customer Orders <?php if ($tab=="customerOrders") echo "<span class=\"sr-only\">(current)</span>";?></a>
      </li>
      <li <?php if ($tab=="reports") echo " class=\"nav-item dropdown active\""; else echo " class=\"nav-item dropdown\""; ?>>
        <a class="nav-link dropdown-toggle" id="reportsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Reports
        </a>
        <div class="dropdown-menu" aria-labelledby="reportsDropdown">
          <a class="dropdown-item" href="/reports/revenue/monthReport.php">Monthly Report</a>
          <a class="dropdown-item" href="/reports/inventoryReport.php">Inventory Report</a>
          <a class="dropdown-item" href="/reports/dailyChart/dailyChart.php">Trends Chart</a>
          <a class="dropdown-item" href="/reports/shipPlan.php">Ship Plan</a>
        </div>
      </li>
      <li <?php if ($tab=="workerTimeSheet") echo " class=\"nav-item active\""; else echo " class=\"nav-item\""; ?>> 
        <a class="nav-link" href="/operations/workerTimeSheet.php">Time Card<?php if ($tab=="workerTimeSheet") echo "<span class=\"sr-only\">(current)</span>";?></a>
      </li>
      </ul>
      <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="/user/img/knuckles.jpg" height="30" width="30"> 
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="/user/profile.php">Profile</a>
          <a class="dropdown-item" href="/user/logout.php?logout=true">Log Out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>