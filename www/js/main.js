$(document).ready(function () {
	$.nette.init();

	$('.datepicker').datepicker({
		orientation: 'left top'
	});

	$('input[type=checkbox], input[type=radio]').iCheck({
		checkboxClass: 'icheckbox_minimal-green',
		radioClass: 'iradio_minimal-green'
	}).on('ifChanged', function () {
		$(this).parents('form').submit();
	})
});
