
<?php
  $tab = "reports";
  require_once "/var/www/skyysystems.com/public_html/assets/header.php";
  require_once "/var/www/skyysystems.com/public_html/assets/db.php";
$_SESSION['month'] = $_POST['month'];
$_SESSION['year'] = $_POST['year'];
 
//$day = $_SESSION['day'];
$month = $_SESSION['month'];
$year = $_SESSION['year'];

$query = $db->prepare("SELECT customerOrders.sku, date, SUM(price*qty), SUM(qty) FROM customerOrders JOIN product ON customerOrders.sku = product.sku WHERE MONTH(date) = ? AND YEAR(date) = ? GROUP BY date");
$query->execute([$month, $year]);
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['reportSubmit'])){
  $month = $_SESSION['month'];
  $year = $_SESSION['year'];
}
?>
  <!--CONTAINER OPEN-->
  <div id="container">
    <h3 align='center'><i>Monthly Revenue Report</i></h3>
    <form method='post' action='reportDetails.php'>
      <table class='table-responsive-sm table-dark' id='report'>
        <tr>
          <td align='center'>
            Year:
            <select name="year" id="year">
              <option selected="selected" value=""></option> 
              <option value="2017">2017</option>
              <option value="2018">2018</option>
            </select>
            Month: 
            <select name="month" id="month">
              <option selected="selected" value=""></option>
              <?php 
                for ($i = 1; $i <= 12; $i++){
                  if ($i < 10)
                    $i = sprintf("%02d", $i);
                  echo "<option value='$i'>$i</option>";
                }
              ?>
            </select>
              <!--Day:
            <select name="day" id="day">
              <option selected="selected" value=""></option>
                <option selected="selected" value=""></option>
                <-?php
                for ($i = 1; $i <= 31; $i++){
                  if ($i < 10)
                    $i = sprintf("%02d", $i);
                  echo "<option value='$i'>$i</option>";
                }
              ?>
            </select>-->
            <input type="submit" onclick="report()" name="reportSubmit" id="reportSubmit" value="Submit">
          </td>
        </tr>
      </table>
    </form>
    <?php
      echo "<form action='dailyReport.php' method='post'>";
      echo "<table class='table-responsive-sm table-dark table-hover'><tr><th>Date</th><th>Revenue</th><th>Quantity Shipped</th></tr>";
      $totalRev = 0;
      $totalQty = 0;
      foreach($result as $row) {
        $date = $row['date'];
        $revenue = $row['SUM(price*qty)'];
        $formatted_revenue = number_format($revenue, 2);
        $qty = $row['SUM(qty)'];
        $formatted_qty = number_format($qty);
        $totalRev += $revenue;
        $formatted_totalRev = number_format($totalRev, 2);
        $totalQty += $qty;
        $formatted_totalQty = number_format($totalQty);
        echo "<tr>";
        echo "<td><button type='submit' formtarget='_blank' name='date' value='$date'>$date</button></td>";
        echo "<td>$$formatted_revenue</td>";
        echo "<td>$formatted_qty</td>";
        echo "</tr>";
      }
      echo "<tr style='background-color:#008000'>";
      echo "<td>Total</td>";
      echo "<td>$$formatted_totalRev</td>";
      echo "<td>$formatted_totalQty</td>";
      echo "</tr>";
      echo "</table>";
      echo "<br>";
    ?>
  </div>
  <script type="text/javascript" src="report.js" async></script>
</body>
</html>