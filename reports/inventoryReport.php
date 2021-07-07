<?php //Header
$tab = "reports";
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3 align='center'><i>Inventory Report</i></h3>
    <table width="100%" class='table-responsive-sm table-dark table-hover'>
      <tr>
        <th>SKU</th>
        <th>Stock</th>
        <th>Ordered</th>
        <th>Cost</th>
        <th>Inventory Cost</th>
        <th>Price</th>
        <th>Revenue Potential</th>
      </tr>
      <?php
      $totalStock = 0; 
      $totalIC = 0;
      $totalSP = 0;
      try{
        foreach($db->query("SELECT inventory.sku, stock, ordered, cost, stock*cost AS inventoryCost, price, stock*price AS salesPotential FROM inventory JOIN product ON inventory.sku = product.sku") as $row){
          $sku = $row['sku'];
          $stock = $row['stock'];
          $formattedStock = number_format($stock);
          $ordered = $row['ordered'];
          $formattedOrdered = number_format($ordered);
          $cost = $row['cost'];
          $formattedCost = number_format($cost, 2);
          $inventoryCost = $row['inventoryCost'];
          $formattedIC = number_format($inventoryCost, 2);
          $price = $row['price'];
          $formattedPrice = number_format($price, 2);
          $salesPotential = $row['salesPotential'];
          $formattedSP = number_format($salesPotential, 2);
          //Totals
          $totalStock += $row['stock'];
          $formattedTS = number_format($totalStock);
          $totalIC += $row['stock'] * $row['cost'];
          $formattedTIC = number_format($totalIC, 2);
          $totalSP += $row['stock'] * $row['price'];
          $formattedTSP = number_format($totalSP, 2);
          echo "<tr>";
          echo "<td>$sku</td>";
          echo "<td>$formattedStock</td>";
          echo "<td>$formattedOrdered</td>";
          echo "<td>$$formattedCost</td>";
          echo "<td>$$formattedIC</td>";
          echo "<td>$$formattedPrice</td>";
          echo "<td>$$formattedSP</td>";
          echo "</tr>";
        }
        echo "<tr style='background-color:#008000'>";
        echo "<td>Total</td>";
        echo "<td>$formattedTS</td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td>$$formattedTIC</td>";
        echo "<td></td>";
        echo "<td>$$formattedTSP</td>";
        echo "</tr>";
      }catch (PDOException $e){
        echo $e->getMessage();
        die();
      }
      ?>  
    </table>
  </div>
  </br>
</body>
</html>