/*
 * Custom jQuery plugins
 */

/*var message = 'Starting plugin';

$(document).ready(function () {

	console.log(message);

});*/


// http://jqueryscript.net/demo/Minimalist-jQuery-Responsive-Equal-Height-Grid-Layout-Javascript-Grids/

	/**
	 * Set all elements within the collection to have the same height.
	 */
	$.fn.equalHeight = function () {
		var heights = [];
		$.each(this, function (i, element) {
			var $element = $(element);
			var elementHeight;
			// Should we include the elements padding in it's height?
			var includePadding = ($element.css('box-sizing') === 'border-box') ||
								 ($element.css('-moz-box-sizing') === 'border-box');
			if (includePadding) {
				elementHeight = $element.innerHeight();
			} else {
				elementHeight = $element.height();
			}
			heights.push(elementHeight);
		});
		this.height(Math.max.apply(window, heights));
		return this;
	};

	/**
	 * Create a grid of equal height elements.
	 */
	$.fn.equalHeightGrid = function (columns) {
		var $tiles = this,
			i;
		$tiles.css('height', 'auto');
		for (i = 0; i < $tiles.length; i++) {
			if (i % columns === 0) {
				var row = $($tiles[i]);
				for (var n = 1; n < columns; n++) {
					row = row.add($tiles[i + n]);
				}
				row.equalHeight();
			}
		}
		return this;
	};

	/**
	 * Detect how many columns there are in a given layout.
	 */
	$.fn.detectGridColumns = function () {
		var offset = 0,
			cols = 0;
		this.each(function (i, elem) {
			var elemOffset = $(elem).offset().top;
			if (offset === 0 || elemOffset === offset) {
				cols++;
				offset = elemOffset;
			} else {
				return false;
			}
		});
		return cols;
	};

	/**
	 * Ensure equal heights now, on ready, load and resize.
	 */
	$.fn.responsiveEqualHeightGrid = function () {
		var _this = this;
		function syncHeights() {
			var cols = _this.detectGridColumns();
			_this.equalHeightGrid(cols);
		}
		$(window).bind('resize load', $.throttle( 250, syncHeights ));
		syncHeights();
		return this;
	};

	/**
	 * Base grid element heights on their widths.
	 */
	$.fn.appxAspectRatio = function (ratio) {
		var $tiles = this,
			len = this.length,
			bodyWidth = $('body').width(),
			newHeight, threshold = 1280, // 1152
			aboveThreshold, i, tile;
		// Ease growth after threshold width
		if (bodyWidth > threshold) {
			aboveThreshold = bodyWidth - threshold;
			ratio = ratio + (1 / (2800/ (aboveThreshold + 5600) - 1) + 2);
		}
		if (len > 0) {
			newHeight = $($tiles[0]).width() / ratio;
		}
		for (i = 0; i < len; i++) {
			tile = $($tiles[i]);
			tile.css('height', newHeight);
		}
		return this;
	};

	/**
	 * Ensure aspect heights now, on ready, load and resize.
	 */
	$.fn.responsiveAspectRatioGrid = function (ratio) {
		var _this = this;
		if (!ratio) ratio = 1.618;
		function syncHeights() {
			_this.appxAspectRatio(ratio);
		}
		$(window).bind('resize load', $.throttle( 83, syncHeights ));
		syncHeights();
		// $(window).bind('resize load', $.throttle( 250, this.appxAspectRadio ));
		// this.appxAspectRadio();
		return this;
	};
