<?php
$files = glob("newSKU/*.csv");
foreach($files as $file) {
    if (($handle = fopen($file, "r")) !== FALSE) {
        while(! feof($handle))
        {
        $data = fgetcsv($handle, 0, ",");
        if($data[0] != ""){
            $qty = $data[0];
            $sku = $data[1];
            echo "<tr><td width=33%><input type='hidden' name='sku' class='sku'>$sku";
            echo "</td><td width=33%><input type='hidden' name='qty' class='qty'>$qty";
            echo "</td><td width=33%><input type='checkbox' name='record'></td></tr>";
        }
        }
        fclose($handle);
    } else {
        echo "Could Not Open File";
    }

}
?>