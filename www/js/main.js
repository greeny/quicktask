$(document).ready(function () {

	function debounce(func, wait, immediate) {
		var timeout;
		return function () {
			var context = this, args = arguments;
			var later = function () {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	}

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

		$el.find('.js-submit-on-change').on('input', debounce(function () {
			$(this).parents('form').submit();
		}, 500));

		$el.find('.datepicker').datepicker({
			orientation: 'left bottom'
		});

		$el.find('.js-autofocus').focus();
	});

	$.nette.init();
});
