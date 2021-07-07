<?php //Header
$tab = "suppliers";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
?>
  <div id="container">
    <div id="supplierChange">
      <form action='updateSupplier.php' method='POST' align='center'>
        <table class='table-responsive-sm table-dark' border=1 align='center'>
          <?php
            $query = $db->prepare("SELECT * FROM supplier WHERE supplier=?");
            $query->execute([$supplierOG]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            $supplier = $result->supplier;
            $name = $result->name;
            $street = $result->street;
            $city = $result->city;
            $state = $result->state;
            $zip = $result->zip;                
            echo "<tr><th>id: </th><td><input type='text' name='supplier' value='$supplier'/></td></tr>";
            echo "<tr><th>Name: </th><td><input type='text' name='name' value='$name'/></td></tr>";
            echo "<tr><th>Street: </th><td><input type='text' name='street' value='$street'/></td></tr>";
            echo "<tr><th>City: </th><td><input type='text' name='city' value='$city'/></td></tr>";
            echo "<tr><th>State: </th><td><input type='text' name='state' value='$state'/></td></tr>";
            echo "<tr><th>Zip: </th><td><input type='text' name='zip' value='$zip'/></td></tr>";
          ?>
          <tr>
            <td></td>
            <td><input type='submit' name='editSubmit' value='Submit' /></td>
          </tr>
          <?php  echo "<input type='hidden' name='supplierOG' value='$supplierOG'>";  ?>
        </table>
      </form>
    </div>
  </div>
</body>
</html>