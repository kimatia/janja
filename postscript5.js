$(document).ready(function (ee) {
$("#uploadimage").on('submit',(function(ee) {
ee.preventDefault();
$("#message5").empty();

$.ajax({
url: "ajax_post5.php", // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{

//location.reload();
$("#message5").html(data);
}
});
}));
});
