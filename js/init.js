$( document ).ready(function() {

  $.getJSON( "https://marc.tv/time2train/jsonp_results.php?callback=?", function( data ) {
var items = [];
$.each( data, function( key, val ) {
  items.push( '<li class="connection" id="' + key + '">'
  +  '<h2><span class="' + val.trainline.toLowerCase() + '">' + val.trainline + '</span> ➔ ' + val.to + '</h2>'
  +  '<p class="countdown">' + val.departure_countdown_time + '</p>'
  +  '<div class="bar p20"></div>'
  + '</li>' );
});

$( "<ul/>", {
  "class": "my-new-list",
  html: items.join( "" )
}).appendTo( "body" );
});


$('.countdown').countdown('04/06/2017 22:30:00', function(event) {
  $(this).html(event.strftime('%H:%M:%S'));
});



/*
function getData() {
    $.getJSON("new_json_file.json", function (data) {
        $.each(data, function (i, item) {
            //Here I am working on the data
        });
        setTimeout(getData, 300000);
    });
}
getData(); // run once to start it
*/


});
