<?php
    require_once "/var/www/skyysystems.com/public_html/assets/db.php";
    $skuArray = $_POST['skuArray'];
    $qtyArray = $_POST['qtyArray'];
    $date = date('Y-m-d');

    for ($i = 0; $i < count($skuArray); $i++){
        $sku = $skuArray[$i];
        $qty = $qtyArray[$i];
        echo "$date  $sku   $qty\n";
        //Orders/Inventory
        //$db->exec("INSERT INTO customerOrders VALUES ('$date','$sku','$qty')");
        //$db->exec("UPDATE inventory SET stock = stock - '$qty' WHERE sku = '$sku'");
    }
    //move from newSKU to oldSKU
    $files = glob("newSKU/*.csv");
    foreach($files as $file) {
        $fileName = basename($file);
        rename($file, "oldSKU/$fileName"); //rename moves despite it's name
    }

?>