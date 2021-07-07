<?php //Header
$tab = "purchaseOrders";
$datePicker = true;
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
$poNumb = $_POST['recieved'];
?>
  <div id="container">
    <?php
    echo "<h1>Recieved PO $poNumb</h1>";
    echo "<input type='hidden' id='poNumb' value='$poNumb'/>";
    //DATE
    $date = date("Y-m-d");
    echo "<p>Date: <input type='text' size='7' value='$date' readonly/></p>";

    //SUPPLIER
    echo "<p>Supplier: ";
    echo "<select name='supplier' id='supplier'>";
    $result = $db->query("SELECT supplier FROM supplier");
    foreach ($result as $row){
      if($row['supplier'] == $supplier)
      {
        echo '<option selected="selected" value="' .$row['supplier']. '">'.$row['supplier'].'</option>';
      }else{
        echo '<option value="' .$row['supplier']. '">'.$row['supplier'].'</option>';
      }
    }
    echo "</select>";
    echo "</p>";
    $query= $db->prepare("SELECT container FROM purchaseOrders WHERE poNumb = ?");
    $query->execute([$poNumb]);
    $containerNo = $query->fetchColumn();
    echo "<p>Containter #: <input type='text' id='containerNo' value='$containerNo'></p>";
    ?>
    <table class='table-responsive-sm table-dark' id='tblProducts'>
      <thead>
        <tr>
          <th>SKU</th>
          <th>Qty</th>
          <th>Add Row</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <select id='sku1'>
              <option selected='selected' value=''>
              <?php
                $result = $db->query("SELECT sku FROM product");
                foreach ($result as $row)
                  echo '<option value="' . $row['sku'] . '">'.$row['sku'].'</option>';
              ?>
            </select>
          </td>
          <td><input type='text' size='3' id='qty1' /></td>
          <td><input type='button' onclick='addRow()' value='Add Row'></td>
        </tr>
      </tbody>
    </table>
    <table class='table-responsive-sm table-dark' id='ledger' width=50%>
      <thead>
        <tr>
          <th>Select</th>
          <th>SKU</th>
          <th>QTY</th>
          <th>Recieved</th>
          <th>Recieved But Not Ordered</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        <!-- ROW FOR ENTRIES -->
        </tr>
        <?php
        $query = $db->prepare("SELECT * FROM poDetails WHERE poNumb = ?");
        $query->execute([$poNumb]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
          $sku = $row['sku'];
          $qty = $row['qty'];
          $rec = $row['recieved'];
          $rbno = $row['rbno'];
          echo "<tr>";
          echo "<td width=10%><input type='checkbox' name='record' size='1'></td>";
          echo "<td>$sku</td>";
          echo "<td><input type='text' name='qty' id='qty' value='$qty'></td>";
          echo "<td><input type='text' name='recieved' value='$qty'></td>";
          echo "<td><input type='hidden' name='rbno' value='0'></td>";
          echo "</tr>";
        }
        ?>
      </tbody>
      <tr>
        <td><input type='button' onclick='deleteRow()' value='Delete Row' /></td>
        <td><input type='button' onclick='refresh()' value='Refresh' /></td>
        <td><input type='button' onclick='formSubmit();submitRedirect()' value='Submit' /></td>
      </tr>
    </table>
  </div>
  <script type='text/javascript' src='recievedPOFunctions.js' async></script>
</body>
</html>