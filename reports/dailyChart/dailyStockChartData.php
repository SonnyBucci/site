<?php 
    require_once "/var/www/skyysystems.com/public_html/assets/db.php";

    $sku = $_POST['sku'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $stockChecked = $_POST['stock'];
    $ordersChecked = $_POST['orders']; 
    $table = array();
    $rows = array();
    $num = 0;
    $checkNum = 0;

    if($stockChecked == "true" && $ordersChecked == "true"){
        $table['cols'] = array(
            array('label' => 'date', 'type' => 'string'),
            array('label' => 'stock', 'type' => 'number'),
            array('label' => 'orders', 'type' => 'number')
        );
    }elseif($stockChecked == "true"){
        $table['cols'] = array(
            array('label' => 'date', 'type' => 'string'),
            array('label' => 'stock', 'type' => 'number')
        );
    }elseif($ordersChecked == "true"){
        $table['cols'] = array(
            array('label' => 'date', 'type' => 'string'),
            array('label' => 'orders', 'type' => 'number')
        );
    }

    $query = $db->prepare("SELECT `date` FROM dailyStock WHERE sku=? AND dailyStock.date BETWEEN ? AND ? ORDER BY dailyStock.date ASC");
    $query->execute([$sku,$startDate,$endDate]);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    //create Array of Dates to cross reference
    $existingDates = array();
    foreach ($result as $row)
        array_push($existingDates, $row['date']);

    //date period to determine start and end
    $period = new DatePeriod(
        new DateTime($startDate),
        new DateInterval('P1D'),
        new DateTime($endDate)
    );
    
    //check against date array to determine actual start (avoid deadspace)
    foreach ($period as $key => $value) {
        $date = $value->format('Y-m-d');
        if(in_array($date, $existingDates)){
            //set period to new start date
            $period = new DatePeriod(
                new DateTime($date),
                new DateInterval('P1D'),
                new DateTime($endDate)
            );            
            break; //exit loop after finding first entry
        }
    }

    $lastStock = 0;
    //begin new loop through period for actual table
    foreach ($period as $key => $value) {
        $date = $value->format('Y-m-d');
        $temp = array();
        $temp[] = array('v' => $date);  //1 (date)
        if($stockChecked == "true"){
            if(in_array($date, $existingDates)){
                $query = $db->prepare("SELECT stock FROM dailyStock WHERE sku=? AND `date` = ?");
                $query->execute([$sku,$date]);
                $stock = $query->fetchColumn();
                $lastStock = $stock;
                $temp[] = array('v' => (int) $stock);  //2 (dailyStock using new stock count)
            }else{
                $temp[] = array('v' => (int) $lastStock);  //2 (dailyStock using last known count)
            }
        }
        if($ordersChecked == "true"){
            $query = $db->prepare("SELECT qty FROM customerOrders WHERE sku = ? AND customerOrders.date = ?");
            $query->execute([$sku,$date]);
            $qty = $query->fetchColumn();
            $temp[] = array('v' => (int)$qty); //3 (customerOrders)
        }
            $rows[] = array('c' => $temp);
    }

    $table['rows'] = $rows;

    $jsonTable = json_encode($table);
    echo "$jsonTable";
?>