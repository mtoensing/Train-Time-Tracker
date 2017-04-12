$(document).ready(function () {

    function getData(auto) {

        var getvars = getUrlVars();
        var identifier = getvars['id'];

        $.getJSON("output/?callback=?&id=" + identifier, function (data) {

            var items = [];
            var from = '';
            var to = '';

            $.each(data, function (key, val) {


                if (val.trainline != null) {
                    items.push('<li class="connection" id="' + key + '">'
                        + '<h2><span class="' + val.trainline.toLowerCase() + '">' + val.trainline + '</span> ➔ ' + val.to + '</h2>'
                        + '<p><span data-departure-countdown-time="' + val.departure_countdown_time + '" class="countdown">' + val.departure_time_in_minutes + '</span> Minuten</p>'
                        + '</li>');

                    from = val.from;
                    to = val.to;
                } else {
                    items.push(val);
                }

            });

            $('body').empty();

            if(to != ''){
                $('title').html(to);
            }

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

            setTimeout(function () {
                getData(true);
            }, 10000)

        });

    }


    function getDataWrapper() {
        getData(false);
    }


    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }

    $("body").click(function () {

        $(this).addClass('flash');
        getDataWrapper();
        setTimeout(function () {
            $('body').removeClass('flash');
        }, 1100);
    });


    getData(); // run once to start it

});
