$(document).ready(function () {
	$.nette.ext('on', {}, {
		before: function (callback) {
			this.ext('snippets').before($.proxy(function ($el) {
				callback($el);
			}, this));
			return this;
		},
		after: function (callback) {
			this.ext('snippets').after($.proxy(function ($el) {
				callback($el);
			}, this));
			callback($(document));
			return this;
		},
		complete: function (callback) {
			this.ext('snippets').complete($.proxy(function ($el) {
				callback($el);
			}, this));
			callback($(document));
			return this;
		}
	});

	$.nette.ext('on').after(function ($el) {
		$el.find('input[type=checkbox], input[type=radio]').iCheck({
			checkboxClass: 'icheckbox_minimal-green',
			radioClass: 'iradio_minimal-green'
		}).on('ifChanged', function () {
			$(this).parents('form').submit();
		});

		$el.find('.datepicker').datepicker({
			orientation: 'left bottom'
		});
	});

	$.nette.init();
});
