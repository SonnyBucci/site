<?php
$tab = "reports";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";

$_SESSION['date'] = $_POST['date'];
$date = $_SESSION['date'];

$query = $db->prepare("SELECT customerOrders.sku, date, price, qty FROM customerOrders JOIN product ON customerOrders.sku = product.sku WHERE date=?");
$query->execute([$date]);
$result = $query->fetchAll(PDO::FETCH_ASSOC);
?>
  <div id="container">
    <h3 align='center'><i>Daily Revenue Report</i></h3>
    <table class='table-responsive-sm table-dark'>
    <tr>
      <th>Date</th>
      <th>SKU</th>
      <th>Price</th>
      <th>QTY</th>
      <th>Sub Total</th>
    </tr>
    <?php
    $totalRev = 0;
    $totalQty = 0;

    foreach ($result as $row){
      $sku = $row['sku'];
      $price = $row['price'];
      $formatted_price = number_format($price, 2);
      $qty = $row['qty'];
      $subTot = $qty*$price;
      $formatted_subTot = number_format($subTot, 2);
      $totalRev += $row['qty'] * $row['price'];
      $formatted_total = number_format($totalRev, 2);
      $totalQty += $row['qty'];
      $formatted_qty = number_format($totalQty);
      echo "<tr>";
      echo "<td>$date</td>";
      echo "<td>$sku</td>";
      echo "<td>$$formatted_price</td>";
      echo "<td>$qty</td>";
      echo "<td>$$formatted_subTot</td>";
      echo "</tr>";
    }
      echo "<tr style='background-color:#008000'>";
      echo "<td>Total</td>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td>$formatted_qty</td>";
      echo "<td>$$formatted_total</td>";
      echo "</tr>"

    /*
      echo "<tr>";
      echo "<td></td>";
      echo "<td></td>";
      echo "<td>Total</td>";
      echo "<td>$totalQty</td>";
      echo "<td>$$totalRev</td>";
      echo "</tr>";*/
    ?>
    </table>  
  </div>
</body>
</html>