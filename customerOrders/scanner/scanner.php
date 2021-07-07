<!doctype html>
<?php
  $tab = "customerOrders";
  $jquery = true;
  require_once "/var/www/skyysystems.com/public_html/assets/header.php";
  require_once "/var/www/skyysystems.com/public_html/assets/db.php";
  require_once "getAttachments.php";
?>
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
        $totalQTY = 0;
        foreach($files as $file) {
            if (($handle = fopen($file, "r")) !== FALSE) {
              while(! feof($handle))
              {
                $data = fgetcsv($handle, 0, ",");
                if($data[0] != ""){
                  $qty = $data[0];
                  $upc = $data[1];
                  $totalQTY += $qty;
                  //remove 0 from start (sku app from iphone)
                  if(substr($upc,0,1) == "0")
                  {
                    $upc = substr($upc, 1);
                  }
                  
                  $query = $db->prepare("SELECT sku FROM product WHERE upc = ?");
                  $query->execute([$upc]);
                  $result = $query->fetch(PDO::FETCH_OBJ);

                  if($result){
                    $sku = $result->sku;
                    echo "<tr><td width=33%><input type='hidden' name='sku' class='sku'>$sku";
                    echo "</td><td width=33%><input type='hidden' name='qty' class='qty'>$qty";
                    echo "</td><td width=33%><input type='checkbox' name='record'></td></tr>";
                  }else{
                    echo "<script>document.getElementById('display').innerHTML += 'UPC: $upc not found in DB</br>';</script>";
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
          <td width=33% id="totalQTY"><?php echo $totalQTY ?></td>
          <td width=33%><input type="button" onclick="deleteRow()" value="Delete Row"></td>
        </tr>
      </table>
    </div>
  </div>
  <script type="text/javascript" src="scanner.js" async></script>
</body>

</html>
