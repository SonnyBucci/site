$(function () {
      $("#startDate").datepicker({
        dateFormat: "yy-mm-dd"
      }).val()
    });
    $(function () {
      $("#endDate").datepicker({
        dateFormat: "yy-mm-dd"
      }).val()
    });

    function drawSKU() {
      // Load the Visualization API and the piechart package.
      google.charts.load('current', {
        'packages': ['corechart']
      });
      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);
    }

    function drawChart() {
      var sku = String($("#sku").val());
      var startDate = $("#startDate").val();
      var endDate = $("#endDate").val()
      var stock = $("#stock").prop("checked");
      var orders = $("#orders").prop("checked");
      console.log("Stock: " + stock + " Orders: " + orders);
      if ((new Date(startDate).getTime() < new Date(endDate).getTime())) {
        $.ajax({
          method: 'POST',
          url: "dailyStockChartData.php",
          data: {
            'sku': sku,
            'startDate': startDate,
            'endDate': endDate,
            'stock' : stock,
            'orders' : orders
          },
          async: false,
          success: function (response) {
            console.log(response);
            //var string = new string.html;
            var data = new google.visualization.DataTable(response);
            // Create our data table out of JSON data loaded from server.
            //var data = new google.visualization.DataTable(tableData);
            var options = {
              //title: sku,
              //curveType: 'function',
              legend: {
                position: 'right'
              }
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          },
          error: function () {
            alert("No Bueno");
          }
        });
      } else {
        alert("Your dates are backwards");
      }
    }