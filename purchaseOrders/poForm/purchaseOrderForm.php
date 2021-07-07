<?php //style sheet, meta, scripts
    $tab = "purchaseOrders";
    $datePicker = true;
    require_once "/var/www/skyysystems.com/public_html/assets/header.php";
    require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3 align='center'><i>Purchase Order Form</i></h3>
    <div id="items"> 
      <p>
        Purchase Order No: <input type='text' size='7' id='poNumb'> 
        Ship Date: <input type='text' size='8' id='shipDate'> 
        Container: <input type='text' id='containerNum' size='3' value='0'>
      </p>
      <table class='table-responsive-sm table-dark' id="tblProducts">
        <thead>
          <tr>
            <th width=10%>SKU</th>
            <th width=40%>Product Name</th>
            <th width=10%>CBM</th>
            <th width=10%>Net CBM</th>
            <th width=10%>Qty</th>
            <th width=10%>Cost</th>
            <th width=10%>Net Cost</th>
            <th width=10%>ADD</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <!--Row 1-->
            <td>
              <select id='sku1'>
            <option selected='selected' value=''>
            <?php
              $result = $db->query("SELECT sku FROM product");
              foreach ($result as $row){
                echo '<option value="' . $row['sku'] . '">'.$row['sku'].'</option>';
              }
            ?>
          </select>
            </td>
            <td width=40% id="prodName1"></td>
            <td width=10% id="cbm1"></td>
            <td width=10% id="netCBM1"></td>
            <td width=10%><input type="text"  id="qty1" /></td>
            <td width=10% id="cost1"></td>
            <td width=10% id="netCost1"></td>
            <td><input type="button" id="addRow" value="Add Row"></td>
          </tr>
        </tbody>
      </table>
      </br>
      <table class='table-responsive-sm table-dark table-hover' id="ledger">
        <thead>
          <tr>
            <th width=10%>Select</th>
            <th width=10%>SKU</th>
            <th width=40%>ProdName</th>
            <th width=10%>NET CBM</th>
            <th width=10%>Quantity</th>
            <th width=10%>Unit Cost</th>
            <th width=10%>Net Cost</th>
          </tr>
        </thead>
        <tbody>
          <tr>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input type="text"  id="grossCBM" readonly></td>
            <td></td>
            <td></td>
            <td><input type="text"  id="grossCost" readonly></td>
          </tr>
        </tfoot>
      </table>
      <input type="button" id="deleteRow" value="Delete Row">
      <input type="button" id="refreshPage" value="Clear">
      <input type="button" onclick="formSubmit()" value="Submit">
      <br>
    </div>
  </div>
  <script type="text/javascript" src="POfunctions.js" async></script>
</body>
</html>