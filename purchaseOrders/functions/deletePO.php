<?php
    $poNumb = $_POST['poNumb'];
    require_once "/var/www/skyysystems.com/public_html/assets/db.php";

    $query = $db->prepare("SELECT sku,qty FROM poDetails WHERE poNumb = ?");
    $query->execute([$poNumb]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    if(!$result)
        echo "$poNumb     no retard/n";
    foreach($result as $row) {
        $qty = $row['qty'];
        $sku = $row['sku'];
        echo "$sku   $qty";
        $query = $db->prepare("UPDATE inventory SET ordered = ordered - ? WHERE sku = ?");
        $query->execute([$qty, $sku]);
    }
    $query = $db->prepare("DELETE FROM purchaseOrders WHERE poNumb = ?");
    $query->execute([$poNumb]);
    echo "Sucessfull deletion of PO#:$poNumb";
    $db = null;
    $query = null;
?>