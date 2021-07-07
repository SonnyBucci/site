<?php //Header
  $tab = "customerOrders";
  $jquery = true;
  require_once "/var/www/skyysystems.com/public_html/assets/header.php";
  require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3 align='center'><i>Customer Orders</i></h3>
    <div id="display"></div>
      <!-- Header Table -->
      <table class="table-responsive-sm table-dark" width=50% align="center">
        <tr>
          <th>SKU</th>
          <th>Quantity</th>
          <th></th>
        </tr>
        <tr>
          <td width=50%>
            <?php 
            //DB
            $result = $db->query("SELECT sku FROM product");
            echo "<select id='sku'>";
            if($result){
                foreach($result as $row) {
                  echo '<option value="' .$row['sku']. '">'.$row['sku'].'</option>';
                }
            }else{
                console.log("queryFailed");
            }
            echo "</select>";
            ?>
          </td>
          <td width=33%><input type="text" id="qty" size='7' placeholder="Quantity" size="3"></td>
          <td width=33%><input type="button" onclick="addRow()" id="addRow" value="Add Row"></td>
        </tr>
      </table>
      <!-- Table to be populated by add-row function-->
      <table class="table-responsive-sm table-dark" id="mainTable" width=50% align="center"></table>
      <!-- Bottom -->
      <table class="table-responsive-sm table-dark" width=50% align="center">
        <tr>
          <td width=33%><input type="button" onclick="formSubmit()" value = "Submit"></td>
          <td width=33%><input type="button" onclick="refreshPage()" value="Reset"></td>
          <td width=33%><input type="button" onclick="deleteRow()" value="Delete Row"></td>
        </tr>
      </table>
      <!-- <button type="button" name="print" onclick="printArray()" class="printArray">Print Array</button> -->
      <!-- display console-->
  </div>
  <script src="customerOrders.js" type="text/javascript" async></script>
</body>
</html>