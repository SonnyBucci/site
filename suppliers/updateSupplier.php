<?php   
  $supplier = $_POST['supplier'];
  $name = $_POST['name'];
  $street = $_POST['street'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  require_once "/var/www/skyysystems.com/public_html/assets/db.php";

  //set script based on which submit form is sent (edit/add submit)
  if(isset($_POST['editSubmit'])){
    $supplierOG = $_POST['supplierOG'];
    //echo "$supplierOG, $supplier, $name, $street, $city, $state, $zip";
    if($supplierOG == $supplier){
      $query = $db->prepare("UPDATE supplier SET name = ?, street = ?, city = ?, state = ?, zip = ? WHERE supplier = ?");
      $query->execute($name,$street,$city,$state,$zip,$supplier);
    }else{
      $query = $db->prepare("UPDATE supplier SET supplier = ?, name = ?, street = ?, city = ?, state = ?, zip = ? WHERE supplier = ?");
      $query->execute($supplier,$name,$street,$city,$state,$zip,$supplierOG);
    }
    echo "<h2>Supplier Updated!</h2>";
  }elseif(isset($_POST['addSubmit'])){
    $query = $db->prepare("INSERT INTO supplier VALUES (?,?,?,?,?,?)");
    $query->execute($supplier,$name,$street,$city,$state,$zip);
    echo "<h2>Supplier Added!</h2>";
  }
  echo "<a href='suppliers.php'>Return</a>";
?>