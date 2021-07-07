<?php //Header
$tab = "suppliers";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
?>
  <div id="container">
    <div id="supplierChange">
      <form action='updateSupplier.php' method='POST' align='center'>
        <table class='table-responsive-sm table-dark' border=1 align='center'>
          <tr>
            <th>id: </th>
            <td><input type='text' name='supplier' /></td>
          </tr>
          <tr>
            <th>Name: </th>
            <td><input type='text' name='name' /></td>
          </tr>
          <tr>
            <th>Street: </th>
            <td><input type='text' name='street' /></td>
          </tr>
          <tr>
            <th>City: </th>
            <td><input type='text' name='city' /></td>
          </tr>
          <tr>
            <th>State: </th>
            <td><input type='text' name='state' /></td>
          </tr>
          <tr>
            <th>Zip: </th>
            <td><input type='text' name='zip' /></td>
          </tr>
          </tr>
          <tr>
            <td></td>
            <td><input type='submit' name='addSubmit' value='Submit' /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</body>
</html>