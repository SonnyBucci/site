<?php
  	if(isset($_POST['sku'])){
        $sku = $_POST['sku'];
        require_once "/var/www/skyysystems.com/public_html/assets/db.php";
        $query = $db->prepare("SELECT description, cbm, cost FROM product WHERE sku = ?");
        $query->execute([$sku]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        //name street city zip
        foreach ($result as $row){
            echo $row['description'] .",". $row['cbm'] .",". $row['cost'];
        }
	}else{
		echo 'sku not set';
	}
	$db = null;
	$result = null;
?>
