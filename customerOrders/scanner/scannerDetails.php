<?php
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
if(isset($_POST['skuArray']) && isset($_POST['qtyArray'])){
  $skuArray = $_POST['skuArray'];
  $qtyArray = $_POST['qtyArray'];
  $date = date('Y-m-d');
  for ($i = 0; $i < count($skuArray); $i++){
    $sku = $skuArray[$i];
    $qty = $qtyArray[$i];
    echo "$date  $sku   $qty  --";

    //Orders/Inventory
    $query = $db->prepare("INSERT INTO customerOrders VALUES (?,?,?)");
    $query->execute([$date,$sku,$qty]);
    $query = $db->prepare("UPDATE inventory SET stock = stock - ? WHERE sku = ?");
    $query->execute([$qty,$sku]);

    //Get Stock post-update
    $query = $db->prepare("SELECT stock FROM inventory WHERE sku = ?");
    $query->execute([$sku]);
    $stock = $query->fetchColumn();
  }
  //move from newSKU to oldSKU
  $files = glob("newSKU/*.csv");
  foreach($files as $file) {
      $fileName = basename($file);
      rename($file, "oldSKU/$fileName"); //rename moves despite it's name
  }
}else{
  echo 'no, ya dummy';
}
?>