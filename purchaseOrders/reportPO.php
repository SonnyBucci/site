<?php //Header
$tab = "purchaseOrders";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3>Purchase Order Report</h3>
    
    <table class='table-responsive-sm table-dark'>
      <tr>
        <th>P.O No.</th>
        <th>Issue Date</th><!--Date-->
        <th>Container#</th>
        <th>Recieved Date</th><!--Ship Date-->
        <th>Gross Cost</th>
      </tr>
      <tr>
        <?php //poNumb, supplier, status, poDate, shipDate, grossCost
        $poNumb = $_POST['poNumb'];
        $query = $db->prepare("SELECT shipDate, container, poDate, grossCost FROM purchaseOrders WHERE poNumb = ?");
        $query->execute([$poNumb]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if($result){
            foreach($result as $row) {
                echo "<td>$poNumb</td>";
                echo "<td>".$row['poDate']."</td>";
                if($row['container'] == 0)
                {
                    echo "<td></td>";
                }else{
                    echo "<td>".$row['container']."</td>";
                }
                echo "<td>".$row['shipDate']."</td>";
                echo "<td>".$row['grossCost']."</td>";
            }
        }else{
            echo "Query Failed";
        };
        ?>
      </tr>
    </table>
    <br>
    <table class='table-responsive-sm table-dark table-hover' border=1 width=100%>
      <tr>
        <th>SKU</th>
        <th>Quantity</th>
        <th>Recieved</th>
        <th>RBNO</th>
        <th>CBM</th>
        <th>Net CBM</th>
        <th>Cost</th>
        <th>Net Cost</th>
      </tr>
        <?php    //poNumb, sku, recieved, rbo, cost
        $query = $db->prepare("SELECT * FROM poDetails WHERE poNumb = ?");
        $query->execute([$poNumb]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
          $sku = $row['sku'];
          $qty = $row['qty'];
          $recieved = $row['recieved'];
          $rbno = $row['rbno'];
          //get CBM
          $query = $db->prepare("SELECT cbm, cost FROM product WHERE sku = ?");
          $query->execute([$sku]);
          $result = $query->fetch(PDO::FETCH_OBJ);
          $cbm = $result->cbm;
          $cost = $result->cost;
          //nets
          $netCBM = ($qty * $cbm) + ($qty * $cbm);
          $netCost = ($qty * $cost) + ($qty * $cbm);
          echo "<tr>";
          echo "<td>$sku</td>";
          echo "<td>$qty</td>";
          echo "<td>$recieved</td>";
          echo "<td>$rbno</td>";
          echo "<td>$cbm</td>";
          echo "<td>$netCBM</td>";
          echo "<td>$cost</td>";
          echo "<td>$netCost</td>";
          echo "</tr>";
        }
        ?>
    </table>
  </div>
</body>
</html>
<?php
  $db = null;
  $result = null;
?>