$(document).ready(function () {

    function getData() {

        var getvars = getUrlVars();
        var id = getvars['id']

        if(id !== "undefined") {
            $.getJSON("output/?callback=?&id=" + id, function (data) {

                var items = [];
                var from = '';
                $.each(data, function (key, val) {
                    items.push('<li class="connection" id="' + key + '">'
                        + '<h2><span class="' + val.trainline.toLowerCase() + '">' + val.trainline + '</span> ➔ ' + val.to + '</h2>'
                        + '<p><span data-departure-countdown-time="' + val.departure_countdown_time + '" class="countdown">' + val.departure_time_in_minutes + '</span> Minuten</p>'
                        + '<!-- <div class="bar p20"></div> -->'
                        + '</li>');

                        from = val.from;
                });
                $("body").empty();
                $("<ul/>", {
                    "class": "connections",
                    html: items.join("")
                }).appendTo("body");

                $('<h1>' + from + '</h1>').prependTo("body");

                $.each($('.countdown'), function (key, val) {
                    $(val).countdown($(this).data('departure-countdown-time'), function (event) {
                        $(this).html(event.strftime('%M:%S'));
                    });
                });
                setTimeout(getData, 30000);
            });
        } else {
            alert('Please specify an id first.')
        }


    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }

    getData(); // run once to start it

});
