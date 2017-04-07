$(document).ready(function () {

    $.getJSON("https://marc.tv/time2train/jsonp_results.php?callback=?", function (data) {
        var items = [];
        $.each(data, function (key, val) {
            items.push('<li class="connection" id="' + key + '">'
                + '<h2><span class="' + val.trainline.toLowerCase() + '">' + val.trainline + '</span> ➔ ' + val.to + '</h2>'
                + '<p>Abfahrt in <span data-departure-countdown-time="' + val.departure_countdown_time + '" class="countdown">' + val.departure_time_in_minutes + '</span> Minuten</p>'
                + '<!-- <div class="bar p20"></div> -->'
                + '</li>');
        });

        $("<ul/>", {
            "class": "my-new-list",
            html: items.join("")
        }).appendTo("body");

        $.each($('.countdown'), function (key, val) {
            $(val).countdown($(this).data('departure-countdown-time'), function (event) {
                $(this).html(event.strftime('%M:%S'));
            });
        });


    });




});
