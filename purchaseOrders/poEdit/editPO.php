<?php //style sheet, meta, scripts
	$tab = "purchaseOrders";
	$datePicker = true;
  require_once "/var/www/skyysystems.com/public_html/assets/header.php";
	require_once "/var/www/skyysystems.com/public_html/assets/db.php";
	if(isset($_POST['edit'])){
		$poNumb =  $_POST['edit'];
	}
	$query = $db->prepare("SELECT * FROM purchaseOrders WHERE poNumb = ?");
	$query->execute([$poNumb]);
	$result = $query->fetch(PDO::FETCH_OBJ);
	$supplier = $result->supplier;
	$poDate = $result->poDate;
	$shipDate = $result->shipDate;
	$containerNumb = $result->container;
	$status = $result->status;
?>
	<div id="container">
		<!--HEADER-->
		<div id="left_column">
			<!--FORM <form action="POform_summary.php" method="GET"> -->
				<?php echo "<h1>Edit Purchase Order: $poNumb</h1>" ?>
				<p>Supplier:
					<!--SUPPLIER--> 
					<select name="supplier" id = "supplier">
						<?php
							try {
								$result = $db->query("SELECT supplier FROM supplier");
								foreach ($result as $row){
									if($row['supplier'] == $supplier)
									{
										echo '<option selected="selected" value="' .$row['supplier']. '">'.$row['supplier'].'</option>';
									}else{
										echo '<option value="' .$row['supplier']. '">'.$row['supplier'].'</option>';
									}
								}
							}
							catch (PDOException $e)
							{
								echo $e->getMessage();
								die();
							}
						?>
					</select>
				</p>
				<p id ='supplierDisplay'>
					<?php
						try {
							$result = $db->prepare("SELECT name, street, city, state, zip FROM supplier WHERE supplier = ?");
							$query->execute([$supplier]);
							$result = $query->fetchAll(PDO::FETCH_ASSOC);
							//name street city zip
							foreach ($result as $row){
								echo $row['name'] ."</br></br>". $row['street'] ."</br></br>". $row['city'].", ".$row['state'].", ". $row['zip'];
							}
						}catch (PDOException $e){
							echo $e->getMessage();
							die();
						}
					?>
				</p>
		</div>
		<div id="right_column">
			<!--DATE-->
			<?php 
				echo "<p>Date: <input type='text' size='7' name='poDate' id='poDate' value='$poDate'></p>";
			?>
		</div>
		<br>
		<div id="POform">
			<?php 
				echo "<p class='alignLeft'>Ship Date: <input type='text' size='7' maxlength='10' name= 'shipDate' id = 'shipDate' value='$shipDate'></p>";
			?>
			<p class='alignLeft'>Status: 
				<select name='status ' id='status'>
				<?php
					echo "<option selected='selected' value='$status'>$status</option>";
					if($status == "Open"){
						echo "<option value='Closed'>Closed</option>";
					}else{
						echo "<option value='Open'>Open</option>";
					}
				?>
				</select>
			</p>
			<?php
				echo "<p class='alignRight'>PO No.: <input type='text' size='7' maxlength='10' name = 'poNumb' id = 'poNumb' value='$poNumb'>";
				echo "<input type='hidden' name = 'ogPONumb' id = 'ogPONumb' value='$poNumb'></p>";
				echo "<p class='alignRight'>Container#: <input type='text' size='7' maxlength='10' name='containerNumb' id='containerNumb' value='$containerNumb'/></p>";
			?>
		</div>
		<div id="items">
			<br>
			<table class='table-responsive-sm table-dark' id="tblProducts">
				<thead>
					<tr>
					<th width=10%>SKU</th>
						<th width=40%>Product Name</th>
						<th width=10%>CBM</th>
						<th width=10%>Net CBM</th>
						<th width=10%>Qty</th>
						<th width=10%>Cost</th>
						<th width=10%>Net Cost</th>
						<th width=10%>ADD</th>
					</tr>
				</thead>
				<tbody>
					<tr><!--Row 1-->
						<td>
							<select id='sku1'>
								<option selected='selected' value=''>
								<?php
									try {
										$result = $db->query("SELECT sku FROM product");
										foreach ($result as $row)
											echo '<option value="' . $row['sku'] . '">'.$row['sku'].'</option>';
									}catch (PDOException $e){
										echo $e->getMessage();
										die();
									}
								?>
							</select>
						</td>
						<td width=40% id="prodName1"></td>
						<td width=10% id="cbm1"></td>
						<td width=10% id="netCBM1"></td>
						<td width=10%><input type="text" size="3" id="qty1"/></td>
						<td width=10% id="cost1"></td>
						<td width=10% id="netCost1"></td>
						<td><input type="button" id="addRow" value="Add Row"></td>
					</tr>	
				</tbody>
			</table>
			<table class='table-responsive-sm table-dark table-hover' id="ledger">
				<thead>
					<tr>
						<th width=10%>Select</th>
						<th width=10%>SKU</th>
						<th width=40%>ProdName</th>
						<th width=10%>NET CBM</th>
						<th width=10%>Quantity</th>
						<th width=10%>Unit Cost</th>
						<th width=10%>Net Cost</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						
					</tr>
					<?php    //poNumb, sku, qty, cost
						$query = $db->prepare("SELECT * FROM poDetails WHERE poNumb = ?");
						$query->execute([$poNumb]);
						$result = $query->fetchAll(PDO::FETCH_ASSOC);
						if($result){
							$grossCBM = 0;
							$grossCost = 0;
							foreach($result as $row) {
								$sku = $row['sku'];
								$qty = $row['qty'];
								//get CBM
								$prodQ = $db->prepare("SELECT `description`, `cbm`, `cost` FROM product WHERE sku = ?");
								$prodQ->execute([$sku]);
								$result = $prodQ->fetch(PDO::FETCH_OBJ);
								$cbm = $result->cbm;
								$desc = $result->description;
								$cost = $result->cost;
								//nets
								$netCBM = $qty * $cbm;
								$netCost = $qty * $cost;
								//number_format rounds but values are already proper size in DB - this is astectic only
								$netCBM = number_format($netCBM, 3, '.', '');
								$cost = number_format($cost, 2, '.', '');
								$netCost = number_format($netCost, 2, '.', '');
								$grossCBM += $netCBM;
								$grossCost += $netCost;
								echo "<tr>";
								echo "<td width=10%><input type='checkbox' name='record' size='1'></td>";
								echo "<td>$sku</td>";
								echo "<td>$desc</td>";
								echo "<td>$netCBM</td>";
								echo "<td>$qty</td>";
								echo "<td>$cost</td>";
								echo "<td>$netCost</td>";
								echo "</tr>";
							}
							$grossCBM = number_format($grossCBM, 3, '.', '');;
							$grossCost = number_format($grossCost, 2, '.', '');;
						}else{
							echo "Query Failed";
						}
						
					?>
				</tbody>
				<tfoot>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<?php
						echo "<td>Grand Total CBM: <input type='text' size='5' id='grossCBM' value='$grossCBM' readonly></td>";
						echo "<td></td><td></td>";
						echo "<td>Grand Total Cost: <input type='text' size='5' id='grossCost' value='$grossCost' readonly></td>";
						?>
					</tr>
				</tfoot>
			</table>
			<input type="button" id="deleteRow" value="Delete Row">
			<input type="button" id="refreshPage" value="Clear">
			<input type="button" onclick="formSubmit()" value="Submit">
			<br>
		</div>
	</div>
	<script type="text/javascript" src="editPOFunctions.js" async></script>
</body>
</html>
<?php session_write_close(); ?>