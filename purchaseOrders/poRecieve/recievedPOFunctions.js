var skuArray = new Array;

$(document).ready(function(){
    $('#ledger').find('tbody').find('tr:not(:first-child)').each(function () {
        skuArray.push($(this).find('td:eq(1)').text());
    });
    console.log(skuArray.toString());
});

function refresh(){
	window.location.reload();
}

function addRow(){
	if($("#sku1").val() && $("#qty1").val())
	{
		var sku = $("#sku1").val();		
		var qty = parseInt($("#qty1").val());
		if(indexSKU(sku) > -1){
			alert("SKU: " + sku + " is already on order.");
		}else{
			//add to sku check array
			skuArray.push(sku);
			var markup = "<tr><td><input type='checkbox' name='record' size='1'></td>";
			markup += "<td><input type='hidden' size='1' name='sku' id='sku' value='" + sku + "'>"+sku+"</td>";
      		markup += "<td><input type='text' name='qty' id='qty' size='1' value='0'></td>";
      		markup += "<td><input type='hidden' value='0'></td>";
      		markup += "<td><input type='text' value='"+ qty +"'></td>";
      		markup += "</tr>";
			$("#ledger").append(markup);
			$("#qty1").val("");
			$("#sku1").val("");
		}
	}else{
		alert("Are you retarded? Fill in SKU and Quantity.");
	}
}

function deleteRow(){
	$("table tbody").find('input[name="record"]').each(function(){
		if($(this).is(":checked")){
			var sku = $(this).parents('tr').find('td:eq(1)').text();
			$(this).parents("tr").remove();
			//remove elements @ sku
			var index = indexSKU(sku);
			if (index > -1) {
				skuArray.splice(index, 1);
			}
		}
	});
}

function indexSKU(skuVal) {  
  str =  "";  
  for (var i = 0; i < skuArray.length; i++) {
      str += i +",";
      if (skuArray[i] == skuVal) {
          return i;
      }
  }
  return -1;
} 

function submitRedirect(){
	location.replace("/purchaseOrders/purchaseOrders.php");
}

function formSubmit(){
	if($("#supplier").val() && $("#containerNo").val()){
		var skuArr = new Array, recArr = new Array, rbnoArr = new Array, qtyArr = new Array;
		$('#ledger').find('tbody').find('tr:not(:first-child)').each(function () {
			skuArr.push($(this).find('td:eq(1)').text()); 
			qtyArr.push(parseFloat($(this).find('td:eq(2)').find('input').val()));
			recArr.push(parseFloat($(this).find('td:eq(3)').find('input').val())); 
			rbnoArr.push(parseFloat($(this).find('td:eq(4)').find('input').val()));
		});
		var supplier = $("#supplier").val();
		var poNumb = $("#poNumb").val();
		var container = $("#containerNo").val();
		console.log(skuArr.toString());
    	console.log(recArr.toString());
			console.log(rbnoArr.toString());
			console.log(qtyArr.toString());
		if (confirm("Are you sure these values are correct?")) {
			$.ajax({
				method: 'POST',
				data:{
						'skuArr' : skuArr,
            'recArr' : recArr,
						 'rbnoArr' : rbnoArr,
						 'qtyArr' : qtyArr,
						'supplier' : supplier,
						'container' : container,
						'poNumb' : poNumb,
				},
				url: 'recieveDetails.php',
				success: function (response) {
					console.log(response);
				},
				error: function(){
					alert("No Bueno");
				}
			});
		}
	}else{
		alert("Supplier, container Number, and/or Ship Date - need to be set");
	}
}
