var skuArray = new Array;
var sku = "", qty = 0, totalQTY = 0, str = "", index = 0, set = false;

$(document).ready(function(){
//INITIALIZING SKU ARRAY
	$('#mainTable').find('tr').each(function () {
		skuArray.push($(this).find('td:eq(0)').text());     
	});
  totalQTY = parseInt($('#totalQTY').text());
  console.log(skuArray.toString());
});

//add row and main array handeling
function addRow(){
  set = false; //set false and check if variables are set
  if($("#sku").val() && $("#qty").val()){
    sku = String($("#sku").val());
    qty = parseInt($("#qty").val());
    index = indexSKU(sku);
    if(index > -1){ //prevent duplicate sku
      document.getElementById("display").innerHTML += sku + " is on order.<br />";
    }else{
      if(typeof qty === 'number' && (qty%1) === 0){
          str = "<tr><td width=33%><input type='hidden' name='sku' class='sku'>" + sku;
          str += "</td><td width=33%><input type='hidden' name='qty' class='qty'>" + qty;
          str += "</td><td width=33%><input type='checkbox' name='record'></td></tr>";
          //set values based on id (needed for delete function to call parent tr/td values)
          document.getElementById("sku").value = sku;
          //document.getElementById("qty").value = qty; //only needed if dupe sku allowed
          //append after values set, then push arrays
          $("#mainTable").append(str);
          skuArray.push(sku);
          totalQTY += qty;
          $('#totalQTY').text(totalQTY);
      }else{
        document.getElementById("display").innerHTML += "Qty != number<br />";
      }
    }
  }else{ 
    if(!$("#sku").val())
      document.getElementById("display").innerHTML += "SKU not selected<br />";
    if(!$("#qty").val())
      document.getElementById("display").innerHTML += "Quantity not set<br />";
  }
}; 
// Find and remove selected table rows
function deleteRow(){
  $("#mainTable").find('input[name="record"]').each(function(){
    if($(this).is(":checked")){
          //get sku from parent row - eq starts @ 0
          sku = $(this).parents('tr').find('td:eq(0)').text();
          qty = parseInt($(this).parents('tr').find('td:eq(1)').text());
          totalQTY -= qty;
          $(this).parents("tr").remove();
          $('#totalQTY').text(totalQTY);
          //remove elements @ sku
          index = indexSKU(sku);
          if (index > -1)
            skuArray.splice(index, 1);
      }
  });
};
function indexSKU(skuVal) {  
  str =  "";  
  for (var i = 0; i < skuArray.length; i++) {
      str += i +",";
      if (skuArray[i] == skuVal)
          return i;
  }
  return -1;
}  
function refreshPage(){
  window.location.reload();
}

function formSubmit(){
    var skuArr = new Array, qtyArr = new Array;
    $('#mainTable').find('tr').each(function () {
        skuArr.push($(this).find('td:eq(0)').text()); 
        qtyArr.push(parseInt($(this).find('td:eq(1)').text()));    
    });
    if (confirm("Are you sure these values are correct?")) {
    $.ajax({
        method: 'POST',
        data: {'skuArray' : skuArr, 'qtyArray' : qtyArr},
        url: 'scannerDetails.php',
        success: function (response) {
        alert("Data Sent - View Console for Details");
        console.log(response);
        },
        error: function(){
        alert("No Bueno");
        }
    });
    }
};
