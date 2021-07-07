<?php
$skuArr = $_POST['skuArr'];
$qtyArr = $_POST['qtyArr'];
$costArr = $_POST['costArr'];
$grossCost = $_POST['grossCost'];
$grossCBM = $_POST['grossCBM'];
$shipDate = $_POST['shipDate'];
$supplier = $_POST['supplier'];
$poNumb = $_POST['poNumb'];
$ogPONumb = $_POST['ogPONumb'];
$poDate = $_POST['poDate'];
$status = $_POST['status'];
require_once "/var/www/skyysystems.com/public_html/assets/db.php";

//update existing PO entry    
if($poNumb == $ogPONumb){
  $query = $db->prepare("UPDATE purchaseOrders SET supplier = ?, status = ?, grossCost = ?, shipDate = ?, `poDate` = ? WHERE poNumb = ?");
  $query->execute([$supplier,$status,$grossCost,$shipDate,$poDate,$poNumb]);
}else{
  $query = $db->prepare("UPDATE purchaseOrders SET poNumb = ?, supplier = ?, status = ?, grossCost = ?, shipDate = ?, `poDate` = ? WHERE poNumb = ?");
  $query->execute([$poNumb,$supplier,$status,$grossCost,$shipDate,$poDate,$ogPONumb]);
}
  echo "$poNumb  $poDate  $supplier  $shipDate  $grossCost  $grossCBM \n";
//update poDetails
for ($i = 0; $i < count($skuArr); $i++) {
  $query = $db->prepare("SELECT qty FROM poDetails WHERE poNumb = ? AND sku = ?");
  $query->execute([$poNumb, $skuArr[$i]]);
  $result = $query->fetch(PDO::FETCH_OBJ);
  if($result){ //check if sku exists in array | result = qty
    $qty = $result->qty;
    echo $skuArr[$i] . "   " . $qty . "\n";
    if($qty != $qtyArr[$i]){
      $query = $db->prepare("UPDATE poDetails SET qty = ? WHERE poNumb = ? AND sku = ?"); 
      $query->execute([$qty, $poNumb, $skuArr[$i]]);
    }
  }else{ //sku not in DB
    $query = $db->prepare("INSERT INTO poDetails VALUES (?,?,?,?,?)");
    $query->execute([$poNumb, $skuArr[$i], $qtyArr[$i],0,0]);
    echo $skuArr[$i] . "   " . $qtyArr[$i] . "\n";
  }
}
$db = null;
$result = null;
?>