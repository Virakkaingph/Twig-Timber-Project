
$(document).ready(function () {

	// Use FastClick
	FastClick.attach(document.body);

	// Maintain dynamic grid element heights
	$('.grid-cell').responsiveEqualHeightGrid();

	// Keep nav grid aspect ratios for most screens
	$('.grid-menu li a').responsiveAspectRatioGrid();

	// Reload vimeo iframe on lightbox close
	$('.lightbox-close').click(function () {
		var src = $('#player').attr('src');
		$('#player').attr('src', src);
	});


	// Toggle mobile menu
	var $win = $(window),
		$body = $('body'),
		$hammie = $('.menu-switch');

	var toggleMobileMenu = function () {
		$body.toggleClass('menu-open');
	};

	var removeMobileMenu = function () {
		$body.removeClass('menu-open');
		$hammie.removeClass('close-btn');
	};

	$hammie.on('click', function (e) {
		e.preventDefault();
		$hammie.toggleClass('close-btn');
		toggleMobileMenu();
	});

	$win.resize(function () {
		// Passing medium breakpoint?
		if ($win.outerWidth() > 768) {
			removeMobileMenu();
		}
	});


	// Close lightbox/menu on 'esc' key
	$(document).keyup(function (e) {
		if (e.keyCode === 27) { // esc
			removeMobileMenu();
			$('.lightbox-close').get(0).click();
		}
	});

});
