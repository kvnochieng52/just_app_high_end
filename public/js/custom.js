(function ($) {
	"use strict";

	// ______________ Cover-image
	$(".cover-image").each(function () {
		var attr = $(this).attr('data-bs-image-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background', 'url(' + attr + ') center center');
		}
	});

	// ______________ Global Loader
	$(window).on("load", function (e) {
		$("#global-loader").fadeOut("slow");
	})

	// ______________ Color-skin
	$(document).ready(function () {
		$("a[data-theme]").click(function () {
			$("head link#theme").attr("href", $(this).data("theme"));
			$(this).toggleClass('active').siblings().removeClass('active');
		});
		$("a[data-effect]").click(function () {
			$("head link#effect").attr("href", $(this).data("effect"));
			$(this).toggleClass('active').siblings().removeClass('active');
		});
	});


	// ______________Tooltip
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	// ______________Popover
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl)
	})

	// ______________Rating Stars
	var ratingOptions = {
		selectors: {
			starsSelector: '.rating-stars',
			starSelector: '.rating-star',
			starActiveClass: 'is--active',
			starHoverClass: 'is--hover',
			starNoHoverClass: 'is--no-hover',
			targetFormElementSelector: '.rating-value'
		}
	};
	$(".rating-stars").ratingStars(ratingOptions);

	// ______________Active Class
	$(document).ready(function () {
		$(".horizontalMenu-list li a").each(function () {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) {
				$(this).addClass("active");
				$(this).parent().addClass("active"); // add active to li of the current link
				$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
				$(this).parent().parent().prev().click(); // click the item to make it drop
			}
		});
	});

	// ______________ Back to Top
	$(window).on("scroll", function (e) {
		if ($(this).scrollTop() > 0) {
			$('#back-to-top').fadeIn('slow');
		} else {
			$('#back-to-top').fadeOut('slow');
		}
	});
	$("#back-to-top").on("click", function (e) {
		$("html, body").animate({
			scrollTop: 0
		}, 100);
		return false;
	});

	// ______________Chart-circle
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function () {
			let $this = $(this);
			$this.circleProgress({
				fill: {
					color: $this.attr('data-color')
				},
				size: $this.height(),
				startAngle: -Math.PI / 4 * 2,
				emptyFill: '#f9faff',
				lineCap: ''
			});
		});
	}
	const DIV_CARD = 'div.card';

	// ______________Card Remove
	$('[data-bs-toggle="card-remove"]').on('click', function (e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});

	// ______________Card Collapse
	$('[data-bs-toggle="card-collapse"]').on('click', function (e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-collapsed');
		e.preventDefault();
		return false;
	});

	// ______________Card Full Screen
	$('[data-bs-toggle="card-fullscreen"]').on('click', function (e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');
		e.preventDefault();
		return false;
	});

	//Increment & Decrement
	var quantitiy = 0;
	$('.quantity-right-plus').on('click', function (e) {
		e.preventDefault();
		var quantity = parseInt($('.quantity').val());
		$('.quantity').val(quantity + 1);

	});
	$('.quantity-left-minus').on('click', function (e) {
		e.preventDefault();
		var quantity = parseInt($('.quantity').val());
		if (quantity > 0) {
			$('.quantity').val(quantity - 1);
		}
	});
	// ______________Quantity-right-plus
	var quantitiy = 0;
	$('.quantity-right-plus').on('click', function (e) {
		e.preventDefault();
		var quantity = parseInt($('#quantity').val());
		$('#quantity').val(quantity + 1);
	});
	$('.quantity-left-minus').on('click', function (e) {
		e.preventDefault();
		var quantity = parseInt($('#quantity').val());
		if (quantity > 0) {
			$('#quantity').val(quantity - 1);
		}
	});


})(jQuery);

// ______________ Modal
$(document).ready(function () {
	$('#more-filters-div').hide()
	$("#myModal").modal('show');
	$("#more-filters").click(function (e) {
		$('#more-filters-div').toggle();
	})

	///$('.select2').select2();
	$('#myCarousel').carousel({
		interval: false
	});
	$('#carousel-thumbs').carousel({
		interval: false
	});

	// handles the carousel thumbnails
	// https://stackoverflow.com/questions/25752187/bootstrap-carousel-with-thumbnails-multiple-carousel
	$('[id^=carousel-selector-]').click(function () {
		var id_selector = $(this).attr('id');
		var id = parseInt(id_selector.substr(id_selector.lastIndexOf('-') + 1));
		$('#myCarousel').carousel(id);
	});
	// Only display 3 items in nav on mobile.
	if ($(window).width() < 575) {
		$('#carousel-thumbs .row div:nth-child(4)').each(function () {
			var rowBoundary = $(this);
			$('<div class="row mx-0">').insertAfter(rowBoundary.parent()).append(rowBoundary.nextAll().addBack());
		});
		$('#carousel-thumbs .carousel-item .row:nth-child(even)').each(function () {
			var boundary = $(this);
			$('<div class="carousel-item">').insertAfter(boundary.parent()).append(boundary.nextAll().addBack());
		});
	}
	// Hide slide arrows if too few items.
	if ($('#carousel-thumbs .carousel-item').length < 2) {
		$('#carousel-thumbs [class^=carousel-control-]').remove();
		$('.machine-carousel-container #carousel-thumbs').css('padding', '0 5px');
	}
	// when the carousel slides, auto update
	$('#myCarousel').on('slide.bs.carousel', function (e) {
		var id = parseInt($(e.relatedTarget).attr('data-slide-number'));
		$('[id^=carousel-selector-]').removeClass('selected');
		$('[id=carousel-selector-' + id + ']').addClass('selected');
	});
	// when user swipes, go next or previous
	$('#myCarousel').swipe({
		fallbackToMouseEvents: true,
		swipeLeft: function (e) {
			$('#myCarousel').carousel('next');
		},
		swipeRight: function (e) {
			$('#myCarousel').carousel('prev');
		},
		allowPageScroll: 'vertical',
		preventDefaultEvents: false,
		threshold: 75
	});

	$(document).on('click', '[data-toggle="lightbox"]', function (event) {
		event.preventDefault();
		$(this).ekkoLightbox();
	});


	$('#myCarousel .carousel-item img').on('click', function (e) {
		var src = $(e.target).attr('data-remote');
		if (src) $(this).ekkoLightbox();
	});

});
