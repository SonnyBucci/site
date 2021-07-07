<?php
	$poNumb = $_POST['poNumb'];
	$skuArr = $_POST['skuArr'];
	$qtyArr = $_POST['qtyArr'];
	$grossCost = $_POST['grossCost'];
	$grossCBM = $_POST['grossCBM'];
	$containerNum = $_POST['containerNum'];
	$shipDate = $_POST['shipDate'];
	$date = date('Y-m-d');

	//$temp = date_create_from_format('Y-m-d', $shipDate);
	//$poNumb = date("dmY", strtotime($shipDate));
	require_once "/var/www/skyysystems.com/public_html/assets/db.php";

	$query = $db->prepare("INSERT INTO purchaseOrders VALUES (?,?,?,?,?,?,?)");
	$query->execute([$poNumb,'Yao',$containerNum,'Open',$date,$shipDate,$grossCost]);
	echo "$poNumb  $date  $grossCost  $grossCBM \n";
	for ($i = 0; $i < count($skuArr); $i++){
		$sku = $skuArr[$i];
		$qty = $qtyArr[$i];
		$query = $db->prepare("INSERT INTO poDetails VALUES (?,?,?,?,?)");
		$query->execute([$poNumb,$sku,$qty,0,0]);
		$query = $db->prepare("UPDATE inventory SET ordered = ordered + ? WHERE sku=?");
		$query->execute([$qty,$sku]);
		echo "$sku  $qty\n";
	}
	$db = null;
	$result = null;
?>
