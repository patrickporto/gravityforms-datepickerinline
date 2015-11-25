(function ($) {
    $(document).bind('gform_post_render', function() {
        $( ".dateinline" ).each(function () {
            element = $(this);
            element.datepicker({
                altField:  element.parent().find('input')
            });
        });
    });
})(jQuery);
