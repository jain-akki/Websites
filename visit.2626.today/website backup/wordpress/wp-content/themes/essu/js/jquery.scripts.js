jQuery(function ($) {

	"use strict";
	var body,
	resizeTimer,
	resizeTimer2;

	var $titleEl = $('h1.entry-title');
	$titleEl.contents().filter(function () {
		return this.nodeType == 3;
	}).wrap('<span class="hide-title"><span></span></span>');
	
	$('br', $titleEl).remove();

	// Lazy load

	var bLazy = new Blazy({
			selector : '.doLazyLoad',
			src : 'data-original',
			success : function (ele) {
				// Image has loaded
				$(ele).parent().css({
					paddingBottom : ''
				}).addClass('img-loaded');

				if ($().mixItUp && $('.kktfwp-masonry').length) {
					$('.kktfwp-secondCol').masonry('reload');
				}
			},
			error : function (ele, msg) {
				if (msg === 'missing') {
					// Data-src is missing
					console.log('missing');
				} else if (msg === 'invalid') {
					// Data-src is invalid
					console.log('invalid');
				}
			}
		});

	// Masonry
	if ($().mixItUp && $('.kktfwp-masonry').length) {
		$('.kktfwp-secondCol').masonry({
			itemSelector : '.img-wr',
			columnWidth : '.img-wr',
			percentPosition : true
		});
	};

	// Check item visibility

	var check = function (i) {
		$(window).scroll(function () {
			if ($('.is-inview').visible(true)) {
				if (i == true) {
					$('.is-inview').parent().removeClass('is-inview-false');
				}
				i = false;
			} else {
				if (i != true) {
					$('.is-inview').parent().addClass('is-inview-false');
				}
				i = true;
			}

		});
	};

	if ($().visible) {
		if ($('.is-inview').visible(true)) {
			check(true);
		} else {
			check(false);
		}
	}

	// Sticky

	if ( typeof kktfwp.layoutVis !== 'undefined' && kktfwp.layoutVis.style === 'is-sticky' ) {

		var window_width = $(window).width();
			
		var kktfwp_make_sticky = function () {
			$(".is-sticky").stick_in_parent({
				inner_scrolling : false,
				offset_top : 40
			});
		};

		if (window_width < 1000) {
			$('.is-sticky').trigger('sticky_kit:detach');
		} else {
			kktfwp_make_sticky();
		};

		$(window).on( 'resize', function () {
			window_width = $(window).width();

			if (window_width < 1000) {
				$('.is-sticky').trigger('sticky_kit:detach');
			} else {
				kktfwp_make_sticky();
			}
		});
	}

	// Preloader

	if ( typeof kktfwp.preloader !== 'undefined' && kktfwp.preloader.state === '1' ) {
		$(window).on('load', function () {
			$('body').removeClass('kktfwp-preloader').addClass('kktfwp-loaded');
			$mix();
		});
		
		$(window).on('pageshow', function (event) {
			if (event.originalEvent.persisted) {
				$('body').removeClass('kktfwp-preloader');
			}
		});
	}

	// Filter

		var $mix = function() {
		$('.kktfwp-projects').mixItUp({
			selectors : {
				target : '.filterable-project',
				filter : '.kktfwp-filter-btn'
			},
			load : {
				filter : '.all'
			},
			animation : {
				duration : 400,
				effects : 'fade stagger(120ms) translateY(100px)',
				easing : 'cubic-bezier(0.4, 0.29, 0.26, 0.96)'

			},
			callbacks : {
				onMixStart : function (state, futureState) {
					//console.log(futureState.$show);
				},
				onMixEnd : function (state) {
					//console.log(state.$show);
				},
				onMixLoad : function (state) {}
			}
		});

		$('.kktfwp-filter-btn').on('click', function (e) {
			e.preventDefault();
		});
	}
	
	if ($().mixItUp && typeof kktfwp.preloader !== 'undefined' && kktfwp.preloader.state !== '1' ) {
		$mix();
	}

	// Love button

	$('.kktfwp-love').on('click', 'a', function (e) {
		e.preventDefault();
		var _this = $(this);

		if (_this.data('requestSend')) {
			return;
		}
		_this.data('requestSend', true);

		var post_id = _this.data('loveid');

		$.ajax({
			url : kktfwp.postlove.ajax_url,
			type : 'post',
			beforeSend : function () {
				_this.find('i').addClass('in-process');
			},
			data : {
				action : 'kktfwp_post_love',
				post_id : post_id,
				_wpnonce : kktfwp.postlove.ajax_nonce,
			},
			success : function (response) {
				if (response.success == true) {
					_this.find('i').toggleClass('kktfwp-i-heart-empty kktfwp-i-heart'); ;
					$('.love-count').html(response.data);
				} else {
					return;
				}
			},
			complete : function () {
				_this.data('requestSend', true).find('i').toggleClass('in-process is-liked');
			}
		});
	})

	// Share button

	$('.kktfwp-proj-meta').on('click', '.kktfwp-share > a', function (e) {
		e.preventDefault();
	});

	$('.kktfwp-proj-meta').on('hover', '.kktfwp-share', function (e) {

		e.preventDefault();
		var time = 50;
		$(this).find('.sh-btn').each(function (index) {

			var _this = $(this);
			setTimeout(function () {
				_this.toggleClass('kktfwp-in');
			}, time)
			time += 50;

		});
		$(this).closest('.kktfwp-proj-meta').toggleClass('is-hovered');

	});

	function kktfwp_windowPopup(url, width, height) {

		var left = (screen.width / 2) - (width / 2),
		top = (screen.height / 2) - (height / 2);

		window.open(
			url,
			"",
			"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left);
	}

	$('.kktfwp-share-icons').on('click', '.sh-btn:not([class*="email"])', function (e) {
		e.preventDefault();
		kktfwp_windowPopup($(this).attr('href'), 600, 460);
	});

	// Add 'larger-than-content' class to elements.

	function largerThanContent(param) {
		if (body.hasClass('search') || body.hasClass('single-attachment') || body.hasClass('error404')) {
			return;
		}

		$('.single-entry-content, .entry-content').find(param).each(function () {
			var element = $(this),
			elementPos = element.offset(),
			elementPosTop = elementPos.top,
			entryFooter = element.closest('article').find('.entry-meta'),
			entryFooterPos = entryFooter.offset(),
			entryFooterPosBottom = (entryFooterPos) ? entryFooterPos.top + (entryFooter.height() + 30) : 1,
			caption = element.closest('figure'),
			newImg;

			// Add 'larger-than-content' to elements below the entry meta.
			if (elementPosTop > entryFooterPosBottom || body.hasClass('page')) {

				// Check if full-size images and captions are larger than or equal to 840px.
				if ('img.size-full' === param) {

					// Create an image to find native image width of resized images (i.e. max-width: 100%).
					newImg = new Image();
					newImg.src = element.attr('src');

					$(newImg).on('load', function () {
						if (newImg.width >= 1200) {
							element.addClass('larger-than-content');

							if (caption.hasClass('wp-caption')) {
								caption.addClass('larger-than-content');
								caption.removeAttr('style');
							}
						}
					});
				} else {
					element.addClass('larger-than-content');
				}
			} else {
				element.removeClass('larger-than-content');
				caption.removeClass('larger-than-content');
			}
		});
	}
	$(document).ready(function () {
		body = $(document.body);

		$(window)
		.on('resize', function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function () {
					largerThanContent('img.size-full');
				}, 300);
		});

		largerThanContent('img.size-full');
	});

	// Mobile menu events

	$('nav.kktfwp-main-navigation li:has(ul)').doubleTap();

	$('body').on('click', '.kktfwp-mobile, #close-sb-menu, .kktfwp-overlay', function (e) {
		$('body').toggleClass('menu-is-opened');
	});

	// No Right Click

	if (kktfwp.rightClick.click == 'true') {

		$(this).bind('contextmenu', function (e) {
			e.preventDefault();
			alert(kktfwp.rightClick.message);
		});
	}

	// Min-height

	var kktfwpheight = (function () {
		var pageHeight = $('#kktfwp-page').height(),
		i = $(window).height(),
		target = $('.kktfwp-site-content');

		if (pageHeight < i) {
			var height = target.height() + i - pageHeight;
			target.css('min-height', height + 'px');
		}
	})();

	// Sidebar menu events

	if ($('body').hasClass('menu-sb')) {

		var kktfwpheight = (function () {
			var viewport = $(window).width();

			if (viewport <= 1199)
				return;

			$(document).on('click', '.kktfwp-primary-menu li.menu-item-has-children > a', function (e) {

				e.preventDefault();
				var _this = $(this).parent();

				if (!_this.hasClass('this-active')) {
					_this.parent().find('.this-active').removeClass('this-active').transition({
						'min-height' : '',
						'height' : ''
					});
				}

				if (_this.children('ul').length && !_this.hasClass('this-active')) {
					_this.addClass('this-active').transition({
						'min-height' : _this.height() + _this.children('ul').outerHeight(true) + 'px'

					}, 250, 'ease', function () {
						_this.css({
							'height' : 'auto'
						});
					});

				} else if (_this.children('ul').length && _this.hasClass('this-active')) {
					_this.removeClass('this-active').transition({
						'min-height' : '',
						'height' : ''
					});
				}

			});

		})();

	};

}); ;
(function ($, window, document, undefined) {
	$.fn.doubleTap = function (params) {
		if (!('ontouchstart' in window) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match(/windows phone os 7/i))
			return false;

		this.each(function () {
			var curItem = false;

			$(this).on('click', function (e) {
				var item = $(this);
				if (item[0] != curItem[0]) {
					e.preventDefault();
					curItem = item;
				}
			});

			$(document).on('click touchstart MSPointerDown', function (e) {
				var resetItem = true,
				parents = $(e.target).parents();

				for (var i = 0; i < parents.length; i++)
					if (parents[i] == curItem[0])
						resetItem = false;

				if (resetItem)
					curItem = false;
			});
		});
		return this;
	};
})(jQuery, window, document);
