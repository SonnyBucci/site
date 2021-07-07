<?php
//DB
require_once "/var/www/skyysystems.com/public_html/assets/db.php";

if(isset($_POST['skuArr']) && isset($_POST['qtyArr'])){
  $skuArr = $_POST['skuArr'];
  $qtyArr = $_POST['qtyArr'];
  $date = date('Y-m-d');

  for ($i = 0; $i < count($skuArr); $i++){
    $sku = $skuArr[$i];
    $qty = $qtyArr[$i];
    echo "$date  $sku   $qty\n";

    //Orders/Inventory
    $query = $db->prepare("INSERT INTO customerOrders VALUES (?,?,?)");
    $query->execute([$date, $sku, $qty]);
    $query = $db->prepare("UPDATE inventory SET stock = stock - ? WHERE sku = ?");
    $query->execute([$qty, $sku]);
    
    //Get Stock post-update
    $query = $db->prepare("SELECT stock FROM inventory WHERE sku = ?");
    $query->execute([$sku]);
    $result = $query->fetch(PDO::FETCH_OBJ);
    $stock = $result->stock;
    
    //Check Stock Existing
    $query = $db->prepare("SELECT stock FROM dailyStock WHERE `date` = ? AND sku = ?");
    $query->execute([$date, $sku]);
    $result = $query->fetch(PDO::FETCH_OBJ);
    if($result){
      $query = $db->prepare("UPDATE dailyStock SET stock = ? WHERE `date` = ? AND sku = ?");
      $query->execute([$stock, $date, $sku]);
      echo "DailyStock Updated";
    }else{
      $query = $db->prepare("INSERT INTO dailyStock VALUES (?, ?, ?)");
      $query->execute([$date, $sku, $stock]);
      echo "DailyStock Added";
    }

  }
}
else
{
  echo 'no, ya dummy';
}
?>