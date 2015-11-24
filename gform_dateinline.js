jQuery(document).ready(function($) {
    $( ".dateinline" ).each(function () {
        $that = $(this);
        $that.datepicker({
            altField:  $that.parent().find('input')
        });
    });
});
