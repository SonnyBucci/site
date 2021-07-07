<?php //Header
$tab = "reports";
$datePicker = true;
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3 align='center'><i>Charts</i></h3>
    <div id="chart">
      <table class='table-responsive-sm table-dark' align="center">
        <td>
          <select id="sku">
            <?php
            //DB 
            try {
              $result = $db->query("SELECT sku FROM product");
              foreach ($result as $row){
                echo '<option value="' . $row['sku'] . '">'.$row['sku'].'</option>';
              }
            }
            catch (PDOException $e)
            {
              echo $e->getMessage();
              die();
            }
            ?>
          </select>
        </td>
        <td>Stock <input type="checkbox" id="stock"></td>
        <td>Orders <input type="checkbox" id="orders"></td>
        <td>Start Date: <input type="text" id="startDate" size="7"></td>
        <td>End Date: <input type="text" id="endDate" size="7"></td>
        <td><input type="button" onclick="drawSKU()" name="drawSKU" value="Draw SKU"></td>
      </table>
    </div>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </div>
  </br>
  <script type="text/javascript" src="drawChart.js" async></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js" async></script>
</body>
</html>