<?php
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";

$date = date("Y-m-d");
$month = date("m");
$year = date("Y");
?>

<div id='container'>
  <h3 align="center"><i>Ship Plan <?php echo "$year"; ?></i></h3>

<?php
echo "<h3>Q1</h3>";

//FETCH Q1
$q = $db->prepare("SELECT poNumb FROM purchaseOrders WHERE MONTH(shipDate) BETWEEN '01' AND '03' AND YEAR(shipDate) = '$year'");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_COLUMN, 0);

foreach($result as $key => $value){
  echo "
    <table width=10% class='table-responsive-sm table-dark table-hover' style='float:left; margin-right:10px'>
      <tr>
        <th bgcolor='#f2ae1b' colspan='2'>$value</th>
      </tr>

  ";
  foreach($db->query("SELECT sku, qty FROM poDetails WHERE poNumb='$value'")as $row){
    $sku = $row['sku'];
    $qty = $row['qty'];
    echo "
      <tr>
        <td>$sku</td>
        <td>$qty</td>
      </tr>";
  }  
  echo "</table>";
}
echo "<br style='clear:both' />";
echo "<h3>Q2</h3>";

//FETCH Q2
$q = $db->prepare("SELECT poNumb FROM purchaseOrders WHERE MONTH(shipDate) BETWEEN '04' AND '06'");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_COLUMN, 0);

foreach($result as $key => $value){
  echo "
    <table width=10% class='table-responsive-sm table-dark table-hover' style='float:left; margin-right:10px'>
      <tr>
        <th bgcolor='#f2ae1b' colspan='2'>$value</th>
      </tr>

  ";
  foreach($db->query("SELECT sku, qty FROM poDetails WHERE poNumb='$value'")as $row){
    $sku = $row['sku'];
    $qty = $row['qty'];
    echo "
      <tr>
        <td>$sku</td>
        <td>$qty</td>
      </tr>";
  }  
  echo "</table>";
}
echo "<br style='clear:both'>";
echo "<h3>Q3</h3>";

//FETCH Q3
$q = $db->prepare("SELECT poNumb FROM purchaseOrders WHERE MONTH(shipDate) BETWEEN '07' AND '09' AND YEAR(shipDate) = '$year'");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_COLUMN, 0);

foreach($result as $key => $value){
  echo "
    <table width=10% class='table-responsive-sm table-dark table-hover' style='float:left; margin-right:10px'>
      <tr>
        <th bgcolor='#f2ae1b' colspan='2'>$value</th>
      </tr>

  ";
  foreach($db->query("SELECT sku, qty FROM poDetails WHERE poNumb='$value'")as $row){
    $sku = $row['sku'];
    $qty = $row['qty'];
    echo "
      <tr>
        <td>$sku</td>
        <td>$qty</td>
      </tr>";
  }  
  echo "</table>";
}
echo "<br style='clear:both' />";

echo "<h3>Q4</h3>";
//FETCH Q4
$q = $db->prepare("SELECT poNumb FROM purchaseOrders WHERE status='Open' AND MONTH(shipDate) BETWEEN '10' AND '12'");
$q->execute();
$result = $q->fetchAll(PDO::FETCH_COLUMN, 0);

foreach($result as $key => $value){
  echo "
    <table width=10% class='table-responsive-sm table-dark table-hover' style='float:left'; margin-right:10px>
      <tr>
        <th bgcolor='#f2ae1b' colspan='2'>$value</th>
      </tr>

  ";
  foreach($db->query("SELECT sku, qty FROM poDetails WHERE poNumb='$value'")as $row){
    $sku = $row['sku'];
    $qty = $row['qty'];
    echo "
      <tr>
        <td>$sku</td>
        <td>$qty</td>
      </tr>";
  }  
  echo "</table>";
}

?>
</div>
</body>
</html>