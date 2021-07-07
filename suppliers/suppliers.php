<?php //Header
$tab = "suppliers";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <div id="suppliers">
      <form action='editSuppliers.php' method='POST'>
        <table class='table-responsive-sm table-dark' border=1 align="center">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Street</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
          </tr>
          <?php    //supplier, name, street, city, zip
          $result = $db->query("SELECT * FROM supplier");
          if($result){
            foreach($result as $row) {
              $supplier = $row['supplier'];
              echo "<tr><td><button type='submit' name='supplier' value='$supplier'>$supplier</button></td>";
              echo "<td>".$row['name']."</td>";
              echo "<td>".$row['street']."</td>";
              echo "<td>".$row['city']."</td>";
              echo "<td>".$row['state']."</td>";
              echo "<td>".$row['zip']."</td>";
            }
          }else{
            echo "Query Failed";
          }
          if (isset($_POST['supplier'])){
            $supplier = $_SESSION['supplier'];
          }
          ?>
        </table>
      </form>
    </div>
  </div>
</body>
</html>