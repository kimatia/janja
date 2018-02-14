$(document).ready(function() {

    $.get("chatFetch.php", function(data) {
        $("#chatarea").html(data);
    });

  
}); // document ready close
