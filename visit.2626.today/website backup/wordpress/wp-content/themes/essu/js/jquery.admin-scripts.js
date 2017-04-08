jQuery(function ($) {

	"use strict";

	$(document).ajaxComplete(function (event, xhr, settings) {
		var match;
		if (typeof settings.data === 'string'
			 && /action=get-post-thumbnail-html/.test(settings.data)
			 && xhr.responseJSON && typeof xhr.responseJSON.data === 'string') {
			match = /<img[^>]+src="([^"]+)"/.exec(xhr.responseJSON.data);

			if (match !== null) {
				var image = new Image();
				$(image).load(function () {

					var colorThief = new ColorThief();
					var col = colorThief.getColor(image);

					colourBrightness(col);
				});
				image.src = match[1];
			}
		}
	});

	var do_ajax = function (c, t) {

		$.ajax({
			url : kktfwp_ajax_object.ajax_url,
			type : 'post',
			data : {
				action : 'kktfwp_setImageBg',
				post_id : kktfwp_ajax_object.id,
				_wpnonce : kktfwp_ajax_object.ajax_nonce,
				r : c[0],
				g : c[1],
				b : c[2],
				t : t
			},
			success : function (response) {}
		})

	};

	var colourBrightness = function (c) {

		var r,
		g,
		b,
		brightness,
		text,
		colour = c;

		r = colour[0];
		g = colour[1];
		b = colour[2];

		brightness = (r * 299 + g * 587 + b * 114) / 1000;

		//console.log(brightness);

		if (brightness < 202) {
			// white text
			//console.log('Dark BG');
			text = '#ffffff';

		} else {
			// black text
			//console.log('White BG');
			text = '#444444';
		}

		return do_ajax(colour, text);
	};

	// Admin settings

	var dColor = $('#essu_theme_dominant_color').val($(this).is(':checked'));

	dColor.change(function() {
        if( $(this).is(':checked') ) {
			$('.dominant_color_custom').slideUp(300);
			$('.dominant_color_text').slideUp(300);
        } else {
			$('.dominant_color_custom').slideDown(300);
			$('.dominant_color_text').slideDown(300);
		}       
    });
	
	if( dColor.is(':checked') ) {
		$('.dominant_color_custom').hide();
		$('.dominant_color_text').hide();
	}

	// Metaboxes

	(function () {

		$('#_kktfwp_type').change(function () {

			if ($(this).val() == 'images') {
				$('.projimg_wrapper').slideDown(300);
				$('.kktfwp-envira-wrapper').slideUp(300);
				$('.kktfwp-video-wrapper').slideUp(300);
				$('.kktfwp-img-layout').slideDown(300);
			} else if ($(this).val() == 'videos') {
				$('.projimg_wrapper').slideUp(300);
				$('.kktfwp-envira-wrapper').slideUp(300);
				$('.kktfwp-video-wrapper').slideDown(300);
				$('.kktfwp-img-layout').slideUp(300);
			} else {
				$('.projimg_wrapper').slideUp(300);
				$('.kktfwp-envira-wrapper').slideDown(300);
				$('.kktfwp-video-wrapper').slideUp(300);
				$('.kktfwp-img-layout').slideUp(300);
			}

		});

		// Project type settings
		var pType = $('#_kktfwp_type option:selected').val();

		switch (pType) {
		case 'images':
			$('.projimg_wrapper').show();
			break;
		case 'videos':
			$('.kktfwp-video-wrapper').show();
			break;
		case 'gallery':
			$('.kktfwp-envira-wrapper').show();
			break;
		}

		var pType = $('#_kktfwp_layout option:selected').val();

		switch (pType) {
		case 'left':
			$('.kktfwp-visibility-wrapper').show();
			break;
		case 'right':
			$('.kktfwp-visibility-wrapper').show();
			break;
		}

		$('#_kktfwp_layout').change(function () {
			if ($(this).val() == 'left' || $(this).val() == 'right') {
				$('.kktfwp-visibility-wrapper').slideDown(300);
			} else {
				$('.kktfwp-visibility-wrapper').slideUp(300);
			}
		});

		// Portfolio page settings

		var hSet = $('#kktfwp-homepage-settings');
		var pSet = $('.kktfwp-filter-wrapper, .kktfwp-columns-wrapper, .kktfwp-gaps-wrapper');

		hSet.insertBefore('#postimagediv');

		$('#page_template').change(function () {

			if ($(this).val() == 'template-portfolio.php') {
				hSet.slideDown(300);
				pSet.slideDown(300);
			} else {
				hSet.slideUp(300);
				pSet.slideUp(300);
			}

		});

		if ($('#page_template option:selected').val() == 'template-portfolio.php') {
			hSet.show();
			pSet.show();
		}

	}
		());

});
