<?php //Header
$tab = "reports";
if(isset($_POST['reportSubmit'])){
  //$day = $_SESSION['day'];
  $month = $_SESSION['month'];
  $year = $_SESSION['year'];
}
require_once "/var/www/skyysystems.com/public_html/assets/header.php";
require_once "/var/www/skyysystems.com/public_html/assets/db.php";
?>
  <div id="container">
    <h3 align='center'><i>Monthly Report<i></h3>
    <form method='post' action='reportDetails.php'>
      <table width="100%" class='table-responsive-sm table-dark table-hover' id='report'>
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
            <input type="submit" onclick="report()" name="reportSubmit" id="reportSubmit" value="Submit">
          </td>
        </tr>
      </table>
    </form>
  </div>
  </br>
  <script type="text/javascript" src="report.js" async></script>
</body>
</html>