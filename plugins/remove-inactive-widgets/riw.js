(function( $ ){
    $(document)
    .ready(
        function () {

        var 
            wp_inactive_widgets = $('#wp_inactive_widgets'),
            btn                 = $('<a href="#" class="button">Remove inactive widgets</a>')
                                        .insertAfter( wp_inactive_widgets );

            btn.wrap( 
                '<p class="description" style="clear:both;line-height: 26px;">Press the following button will remove all of these inactive widgets </p>'
            )
            .click(
                function () {
                    $.post(
                        ajaxurl, {
                            action          : 'riw_async',
                            riw_asyncnonce  : $('#riw_asyncnonce').val()
                        }, 
                        function (data) {
                            wp_inactive_widgets.empty();
                        }
                    );
                }
            );
        }
    );
})(jQuery);