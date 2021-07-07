function deletePO(poNumb){
  if (confirm("Are you sure you want to delete Purchase Order #" + poNumb + "? This can not be undone.")) {
    $.ajax({
      method: 'POST',
      data: {'poNumb' : poNumb},
      url: 'functions/deletePO.php',
      success: function (response) {
        alert("Purchase Order #" + poNumb + " Removed.");
        window.location.reload();
        console.log(response);
      },
      error: function(){
        alert("No Bueno");
      }
    });
  }
}

function toggle(name){
  var table = document.getElementById(name);
  //if(name == "poTableOpen")
    //var header = document.getElementById('open');
  //else
    //var header = document.getElementById('closed');
  

  if (table.style.display === "none") {
    table.style.display = "table";
    //header.style.display = "block";
  } else {
    table.style.display = "none";
    //header.style.display = "none";
  }
}

function sortTable(n,name) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(name);

  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc";
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("tr");
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next
      Also check for grossCost row to parseFloat */
      if(n == 5){
        x = parseFloat(rows[i].getElementsByTagName("td")[n].innerHTML);
        y = parseFloat(rows[i + 1].getElementsByTagName("td")[n].innerHTML);
      }else{
        x = rows[i].getElementsByTagName("td")[n].innerHTML;
        y = rows[i + 1].getElementsByTagName("td")[n].innerHTML;
      }
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
      if (dir == "asc") {
        if (x > y) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }else if (dir == "desc"){
        if (x < y) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

jQuery(function(){
  jQuery('#closed').click();
})