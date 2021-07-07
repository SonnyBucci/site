<!doctype html>
<?php
  require_once "getAttachments.php";
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Asia Direct ERP | Scanner</title>
  <script src="http://use.edgefonts.net/sarina.js"></script>
  <link href="/styles/check_cs6.css" rel="stylesheet" type="text/css">
  <link href="/styles/spunky.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="scanner.js"></script>
</head>

<body>
  <div id="navbar">
    <ul>
      <li>
        <a href="/inventory.php">Inventory</a>
        <ul>
          <li><a href="/products/addProduct.php">Add Product</a></li>
          <li><a href="/products/editProduct.php">Edit Product</a></li>
        </ul>
      </li>
      <li>
        <a href="/purchaseOrders.php">Purchase Orders</a>
        <ul>
          <li><a href="/purchaseOrders/poForm/purchaseOrderForm.php">Create PO</a></li>
        </ul>
      </li>
      <li>
        <a href="/suppliers.php">Suppliers</a>
        <ul>
          <li><a href="/suppliers/addSupplier.php">Add Supplier</a></li>
        </ul>
      </li>
      <li class="current-menu-item">
        <a href="/customerOrders.php">Customer Orders</a>
        <ul>
          <li><a href="/scanner/scanner.php">Scanner</a></li>
        </ul>
      </li>
      <li><a href="/analytics.php">Analytics</a></li>
    </ul>
    <h2 align="right">Asia Direct ERP</h2>
  </div>
  <div id="container">
    <div id="display"></div>
    <div id="customerOrders">
      <!-- Header Table -->
      <table width=30% align="center">
        <tr>
          <th>SKU</th>
          <th>Quantity</th>
          <th></th>
        </tr>
        <tr>
          <td width=33%>
            <?php 
            $db = new PDO('mysql:host=localhost;dbname=ADI_BETA', 'root', '');
            $result = $db->query("SELECT sku FROM product");
            echo "<select id='sku'>";
            if($result){
                foreach($result as $row)
                  echo '<option value="' .$row['sku']. '">'.$row['sku'].'</option>';
            }else
                echo "<script>console.log('queryFailed');</script>";
            echo "</select>";
            ?>
          </td>
          <td width=33%><input type="text" id="qty" placeholder="Quantity" size="3"></td>
          <td width=33%><input type="button" onclick="addRow()" id="addRow" value="Add Row"></td>
        </tr>
      </table>
      <!-- Table to be populated by add-row function-->
      <table id="mainTable" width=30% align="center">
        <?php
        $files = glob("newSKU/*.csv");
        foreach($files as $file) {
            if (($handle = fopen($file, "r")) !== FALSE) {
              while(! feof($handle))
              {
                $data = fgetcsv($handle, 0, ",");
                if($data[0] != ""){
                  $qty = $data[0];
                  $upc = $data[1];
                  $query = $db->prepare("SELECT sku FROM product WHERE upc = ?");
                  $query->execute([$upc]);;
                  $result = $query->fetch(PDO::FETCH_OBJ);

                  if($result){
                    $sku = $result->sku;
                    echo "<tr><td width=33%><input type='hidden' name='sku' class='sku'>$sku";
                    echo "</td><td width=33%><input type='hidden' name='qty' class='qty'>$qty";
                    echo "</td><td width=33%><input type='checkbox' name='record'></td></tr>";
                  }else{
                    echo "<script>document.getElementById('display').innerHTML += 'UPC: $upc not found in DB';</script>";
                  }
                }
              }
              fclose($handle);
            } else {
                echo "<script>console.log('Could not open file:$file');</script>";
            }

        }
        ?>
      </table>
      <!-- Bottom -->
      <table width=30% align="center">
        <tr>
          <td width=33%><input type="button" onclick="formSubmit()" value = "Submit"></td>
          <td width=33%><input type="button" onclick="refreshPage()" value="Reset"></td>
          <td width=33%><input type="button" onclick="deleteRow()" value="Delete Row"></td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>
