'use strict';

/**
 * The main Pikaday datepicker control script.
 */

document.addEventListener('DOMContentLoaded', function (event) {

	var api = wp.customize;
	var datepickers = document.querySelectorAll('.pikaday-control');

	var _iteratorNormalCompletion = true;
	var _didIteratorError = false;
	var _iteratorError = undefined;

	try {
		var _loop = function _loop() {
			var datepicker = _step.value;


			var setting = api.instance(datepicker.id);
			var control = api.control.instance(datepicker.id);
			var paramsObj = {
				field: datepicker
			};

			// Set all non-null control params
			['format', 'position', 'i18n'].forEach(function (value) {

				if (typeof control.params[value] !== "undefined") {
					paramsObj[value] = control.params[value];
				}
			});

			// Create the Pikaday Object
			new Pikaday(paramsObj);
		};

		for (var _iterator = datepickers[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
			_loop();
		}

		// The datepicker gets buried under the overlay container when added to an input, so up the z-index to the overlay container+1 to make it visible.
	} catch (err) {
		_didIteratorError = true;
		_iteratorError = err;
	} finally {
		try {
			if (!_iteratorNormalCompletion && _iterator.return) {
				_iterator.return();
			}
		} finally {
			if (_didIteratorError) {
				throw _iteratorError;
			}
		}
	}

	var overlayZindex = window.getComputedStyle(document.querySelector('.wp-full-overlay')).getPropertyValue('z-index');
	var singlePikas = document.querySelectorAll('.pika-single');
	var _iteratorNormalCompletion2 = true;
	var _didIteratorError2 = false;
	var _iteratorError2 = undefined;

	try {
		for (var _iterator2 = singlePikas[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
			var singlePika = _step2.value;

			singlePika.style.zIndex = overlayZindex + 1;
		}
	} catch (err) {
		_didIteratorError2 = true;
		_iteratorError2 = err;
	} finally {
		try {
			if (!_iteratorNormalCompletion2 && _iterator2.return) {
				_iterator2.return();
			}
		} finally {
			if (_didIteratorError2) {
				throw _iteratorError2;
			}
		}
	}
});