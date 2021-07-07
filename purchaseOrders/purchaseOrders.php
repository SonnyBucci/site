<?php //Header
$tab = "purchaseOrders";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3 align='center'><i>Purchase Orders</i></h3>
    <div id="purchaseOrders">
      <form action='reportPO.php' method='POST'>
      <input type="button" onclick="toggle('poTableOpen')" value="Open Orders" style="width:15%"></input>
        <table width="100%" class="table-responsive-sm table-dark table-hover" id="poTableOpen" align='center'>
          <tr>
            <th class="sort" onclick="sortTable(0,'poTableOpen')">PO Number</th>
            <th class="sort" onclick="sortTable(1,'poTableOpen')">Ship Date</th>
            <th class="sort" onclick="sortTable(2,'poTableOpen')">Date Issued</th>
            <th class="sort" onclick="sortTable(3,'poTableOpen')">Gross Cost</th>
            <th>Edit</th>
            <th>Recieved</th>
            <th>Delete</th>
          </tr>
          <?php
            drawTable("Open",$db); //String must be equal to an order status in DB
          ?>
        </table>
        <br>
        <input type="button"  onclick="toggle('poTableClosed')" value="Closed Orders" style="width:15%" id='closed'></input>
        <table width="100%" class="table-responsive-sm table-dark table-hover" id="poTableClosed" align='center'>
          <tr>
            <th class="sort" onclick="sortTable(0,'poTableClosed')">PO Number</th>
            <th class="sort" onclick="sortTable(1,'poTableClosed')">Ship Date</th>
            <th class="sort" onclick="sortTable(2,'poTableClosed')">Date Issued</th>
            <th class="sort" onclick="sortTable(3,'poTableClosed')">Gross Cost</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
          <?php
            drawTable("Closed",$db); //String must be equal to an order status in DB
          ?>
        </table>
      </form>
    </div>
    <script type="text/javascript" src="purchaseOrders.js" async></script>
  </body>
</html>
<?php
function drawTable($type,$db)
{
  $query = $db->prepare("SELECT * FROM purchaseOrders WHERE status=?");
  $query->execute([$type]);
  $result = $query->fetchAll(PDO::FETCH_ASSOC);
  foreach($result as $row) {
    $grossCost = $row['grossCost'];
    $formatted_grossCost = number_format($grossCost, 2);
    $poNumb = $row['poNumb'];
    echo "<tr>";
    echo "<td width='20%'><button type='submit' name='poNumb' class='poNumb' value='$poNumb'>$poNumb</button></td>";
    echo "<td width='20%'>".$row['shipDate']."</td>";
    echo "<td width='20%'>".$row['poDate']."</td>";
    echo "<td width='20%'>$$formatted_grossCost</td>";
    echo "<td border='0' width='10%'><button type='submit' name='edit' formaction='/purchaseOrders/poEdit/editPO.php' value='$poNumb'>Edit</button></td>";
    if($type == "Open")
      echo "<td width='10%'><button type='submit' name='recieved' formaction='/purchaseOrders/poRecieve/recievedPO.php' value='$poNumb'>Recieved</button></td>";
    echo "<td width='10%'><button type='button' name='delete' onclick='deletePO($poNumb)'>Delete</button></td>";
    echo "</tr>";
  }
}
?>