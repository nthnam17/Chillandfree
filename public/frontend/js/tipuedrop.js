(function ($) {

    $.fn.tipuedrop = function (options) {

        var set = $.extend({
            'show': 1000000000000,
            'speed': 300,
            'newWindow': false,
            'mode': 'static',
            'contentLocation': 'tipuedrop/tipuedrop_content.json'
        }, options);

        return this.each(function () {

            var tipuedrop_in = {
                pages: []
            };
            $.ajaxSetup({
                async: false
            });

            if (set.mode == 'json') {
                $.getJSON(set.contentLocation)
                    .done(function (json) {
                        tipuedrop_in = $.extend({}, json);
                    });
            }

            if (set.mode == 'static') {
                tipuedrop_in = $.extend({}, tipuedrop);
            }

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content'), 6);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_7'), 7);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_2'), 2);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_3'), 3);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_4'), 4);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_5'), 5);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_8'), 8);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_9'), 9);
            });

            $(this).on('input', function (event) {
                getTipuedrop($(this), $('#tipue_drop_content_10'), 10);
            });


            function getTipuedrop($obj, $contentContainer, category) {
                if ($obj.val()) {
                    var c = 0;
                    for (var i = 0; i < tipuedrop_in.pages.length; i++) {
                        var pat = new RegExp($obj.val(), 'iu');
                        if ((tipuedrop_in.pages[i].title.search(pat) != -1 || tipuedrop_in.pages[i].text.search(pat) != -1) && c < set.show) {
                            if (c == 0) {
                                var out = '<div class="tipue_drop_box"><div id="tipue_drop_wrapper">';
                            }
                            var encodedTitle = encodeURIComponent(tipuedrop_in.pages[i].title).replace(/%20/g, '+');
                            out += '<a href="/tim-kiem-' + category + '?param=' + encodedTitle + '"';
                            if (set.newWindow) {
                                out += ' target="_blank"';
                            }
                            out += '><div class="tipue_drop_item"><div class="tipue_drop_right">' + tipuedrop_in.pages[i].title + '</div></div></a>';
                            c++;
                        }
                    }
                    if (c != 0) {
                        out += '</div></div>';
                        $contentContainer.html(out);
                        $contentContainer.fadeIn(set.speed);
                    }
                } else {
                    $contentContainer.fadeOut(set.speed);
                }
            }

            // Prevent the default click behavior when clicking inside the dropdown
            $('#tipue_drop_content, #tipue_drop_content_7, #tipue_drop_content_2, #tipue_drop_content_3, #tipue_drop_content_4, #tipue_drop_content_5, #tipue_drop_content_8, #tipue_drop_content_9, #tipue_drop_content_10').on('click', function (event) {
                event.stopPropagation();
            });

            // Close the dropdown when clicking outside
            $('html').click(function () {
                $('#tipue_drop_content, #tipue_drop_content_7, #tipue_drop_content_2, #tipue_drop_content_3, #tipue_drop_content_4, #tipue_drop_content_5, #tipue_drop_content_8, #tipue_drop_content_9, #tipue_drop_content_10').fadeOut(set.speed);
            });

        });
    };

})(jQuery);
