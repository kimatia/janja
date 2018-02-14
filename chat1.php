<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="postscript.js"></script>
  <script>
  var timer=10;
  var view="";
  $(function (){
    function onTime(){
      setTimeout(onTime, 1000);
 
      if(timer==10){
       //alert("at 8")
  
       $.post("chat.php",{viewing:view},function(data){
        $(".realTimeChat h5").html(data);
       })
       timer=11;
       clearTimeout(onTime); 
      }
      timer--;
    }

    onTime(); 
  });
</script>
<div class="realTimeChat"><h5>Loading chats...</h5></div>