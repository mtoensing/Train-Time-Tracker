(function ($) {

    $.fn.TrainTimeTracker = function (options) {

        var opts = $.extend( {}, $.fn.TrainTimeTracker.defaults, options );
        var obj = $(this);
        var getvars = getUrlVars();
        var identifier = getvars['id'];
        $(obj).addClass('traintimetracker');

        $.getJSON("output/?callback=?&id=" + identifier, function (data) {

            var items = [];
            var from = '';
            var to = '';
            var classvalue = '';

            $.each(data, function (key, val) {

                if (val.trainline != null) {

                    if (key > 1) {
                        classvalue = 'hidden';
                    }

                    items.push('<li class="connection ' + classvalue + '" id="item' + key + '">'
                        + '<h2><span class="' + val.trainline.toLowerCase() + '">' + val.trainline + '</span> ➔ ' + val.to + '</h2>'
                        + '<p><span data-departure-countdown-time="' + val.departure_countdown_time + '" class="countdown">' + val.departure_time_in_minutes + '</span> Minuten</p>'
                        + '</li>');

                    from = val.from;
                    to = val.to;
                } else {
                    items.push(val);
                }

            });


            if (to != '') {
                $('title').html(to);
            }

            $(obj).empty();

            $("<ul/>", {
                "class": "connections",
                html: items.join("")
            }).appendTo(obj);

            $('<h1>' + from + '</h1>').prependTo(obj);

            $.each($('.countdown'), function (key, val) {

                $(val).countdown($(this).data('departure-countdown-time'), function (event) {
                    $(this).html(event.strftime('%M:%S'));
                    if (event.elapsed) {
                        $(this).parent().parent().addClass('hidden');
                        $('#item2').show();
                    }
                });

            });

            if(opts.recursion == true){
                setTimeout(function () {
                    $('#data').TrainTimeTracker();
                }, 10000)
            }
        });

        $(obj).unbind().click(function () {
            $('body').addClass('flash');
            $(obj).TrainTimeTracker({
                recursion: false
            });
            setTimeout(function () {
                $('body').removeClass('flash');
            }, 1100);
        });

    };

    $.fn.TrainTimeTracker.defaults = {
        recursion: true
    };


    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }

}(jQuery));
