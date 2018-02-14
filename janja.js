$(document).ready(function() {

    $.get("view.php", function(data) {
        $("#table_content").html(data);
    });

  
}); // document ready close

$(document).ready(function() {

    $.get("chatFetch.php", function(data) {
        $("#chatarea").html(data);
    });

  
}); // document ready close


$(document).ready(function() {

    $.get("userFetch.php", function(data) {
        $("#loginperson").html(data);
    });

  
}); // document ready close


	var timer=10;
	var view="";
	$(function (){
    function inTime(){
      setTimeout(inTime, 1000);
 
      if(timer==8){
       //alert("at 8")
       	$(".realTime h2");
       $.post("chatFetch.php",{viewing:view},function(data){
       	$(".realTime h2").html(data);
       })
       timer=11;
       clearTimeout(inTime); 
      }
      timer--;
    }

    inTime(); 
	});


