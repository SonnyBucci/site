<?php
if(isset($_POST['supplier'])){
    $supplier = $_POST['supplier'];
    require_once "/var/www/skyysystems.com/public_html/assets/db.php";
    try {
        $query = $db->prepare("SELECT name, street, city, state, zip FROM supplier WHERE supplier = ?");
        $query->execute([$supplier]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        //name street city zip
        foreach ($result as $row){
            echo $row['name'] ."</br></br>". $row['street'] ."</br></br>". $row['city'].", ".$row['state'].", ". $row['zip'];
        }
    }catch (PDOException $e){
        echo $e->getMessage();
        die();
    }
}else{
    echo 'no';
}
$db = null;
$result = null;
?>
