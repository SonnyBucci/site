<?php
$poNumb = $_POST['poNumb'];
$skuArray = $_POST['skuArr'];
$qtyArr = $_POST['qtyArr'];
$recArray = $_POST['recArr'];
$rbnoArray = $_POST['rbnoArr'];
$supplier = $_POST['supplier'];
$container = $_POST['container'];
$tempArray = array();
$date = date('Y-m-d');
require_once "/var/www/skyysystems.com/public_html/assets/db.php";

//update poDetails @ existing skus
$query = $db->prepare("SELECT sku FROM poDetails WHERE poNumb = ?");
$query->execute([$poNumb]);
$result = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row){ //get existing sku's from PO
	$sku = $row['sku'];
	for ($i = 0; $i < count($skuArray); $i++){
		if($skuArray[$i] == $sku){ //compare form sku's to existing in DB, if same update
			$rec = $recArray[$i];
			$rbno = $rbnoArray[$i];
			array_push($tempArray, $sku); //add updated values to temp Array for insert loop below
			$query = $db->prepare("UPDATE poDetails SET recieved = ?, rbno = ? WHERE sku = ? AND poNumb = ?");
			$query->execute([$rec,$rbno,$sku,$poNumb]);
			echo "poDetails Updated @$sku\n";
		}
	}
}
$insertArray = array_diff($skuArray, $tempArray); //find unused sku's
//Insert remaining sku's to poDetails
for ($i = 0; $i < count($skuArray); $i++){
	$sku = $skuArray[$i];
	if (in_array($sku, $insertArray)){ //if sku in unused
		$rec = $recArray[$i];
		$rbno = $rbnoArray[$i];
		$query = $db->prepare("INSERT INTO poDetails VALUES (?,?,?,?,?)");
		$query->execute([$poNumb,$sku,0,$rec,$rbno]);
		echo "poDetails Added @$sku";
	}
}

for ($i = 0; $i < count($skuArray); $i++){
	$sku = $skuArray[$i];
	$recieved = $recArray[$i];
	$rbno = $rbnoArray[$i];
	$qty = $qtyArr[$i];
	//Inventory
	$query = $db->prepare("UPDATE inventory SET stock = stock + ? + ?, ordered = ordered - ? WHERE sku = ?");
	$query->execute([$recieved,$rbno,$qty,$sku]);
	echo "Inventory Updated @$sku\n";
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

//Purchase Orders
$query = $db->prepare("UPDATE purchaseOrders SET supplier = ?, status = ?, container = ?, shipDate = ? WHERE poNumb = ?");
$query->execute([$supplier,"Closed",$container,$date,$poNumb]);
?>

