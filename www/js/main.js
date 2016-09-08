$(document).ready(function(){
    $.nette.init();

    $('.datepicker').datepicker({
        orientation: 'left top'
    });

    $('.js-submit-on-change').on('change', function () {
        $(this).parents('form').submit();
    })
});
