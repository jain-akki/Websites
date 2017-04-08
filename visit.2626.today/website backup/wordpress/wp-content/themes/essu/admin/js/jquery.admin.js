jQuery(document).ready(function ($) {
	String.prototype.bool = function () {
		return (/^true$/i).test(this);
	};

	// Message popups
	$.fn.center = function () {
		this.css({
			"position" : "fixed",
			"left" : $("#wpbody").css('margin-left'),
			"top" : $(window).height() / 2 - this.height() + "px"
		});
		return this;
	}
	$(window).scroll(function () {
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
	});
	$(window).scroll();

	// Tabs fading
	$('.group').hide();
	$('.group:first').fadeIn();
	$('.group .collapsed').each(function () {
		$(this).find('input:checked').parent().parent().parent().nextAll().each(function () {
			if ($(this).hasClass('last')) {
				$(this).removeClass('hidden');
				return false;
			}
			$(this).filter('.hidden').removeClass('hidden');
		});
	});

	// Tabs navigation fading
	$('#of-nav li:first').addClass('current');
	$('#of-nav li a').click(function (e) {
		var clicked_group = $(this).attr('href');
		$('#of-nav li').removeClass('current');
		$(this).parent().addClass('current');
		$('.group').hide();
		$(clicked_group).fadeIn(100);
		e.preventDefault();
	});

	// Colorpicker
	$('.color_picker .preview').each(function () {
		var elem = $(this);
		var color = elem.parent().find('input').val();
		elem.css('backgroundColor', color).ColorPicker({
			color : color,
			onShow : function (cp) {
				$(cp).fadeIn(100);
				return false;
			},
			onHide : function (cp) {
				$(cp).fadeOut(100);
				return false;
			},
			onChange : function (hsb, hex, rgb) {
				elem.css('backgroundColor', '#' + hex).parent().find('input').attr('value', '#' + hex);
			}
		});
	});
	$('.color_picker :input').blur(function () {
		$(this).parent().find(".preview").css('backgroundColor', $(this).val());
	});

	// Range slider
	$(window).load(function () {
		$('.kk_range_slider').each(function () {
			var elem = $(this);

			elem.bind("slider:changed", function (event, data) {
				// The currently selected value of the slider
				elem.parent().find('.regular-text').attr('value', data.value);

			});
		});
	});

	// AJAX Upload
	$('.image_upload_button').each(function () {
		var clickedObject = $(this);
		var clickedID = $(this).attr('id');
		new AjaxUpload(clickedID, {
			action : kk_ajax_data.ajaxurl,
			name : clickedID,
			data : {
				action : 'of_ajax_post_action',
				type : 'upload',
				data : clickedID
			},
			autoSubmit : true,
			responseType : false,
			onChange : function (file, extension) {},
			onSubmit : function (file, extension) {
				clickedObject.text('Uploading');
				this.disable();
				interval = window.setInterval(function () {
						var text = clickedObject.text();
						if (text.length < 13) {
							clickedObject.text(text + '.');
						} else {
							clickedObject.text('Uploading');
						}
					}, 200);
			},

			onComplete : function (file, response) {
				window.clearInterval(interval);
				clickedObject.text('Upload Image');
				this.enable();
				if (response.search('Upload Error') > -1) {
					var buildReturn = '<span class="upload-error">' + response + '</span>';
					$(".upload-error").remove();
					clickedObject.parent().after(buildReturn);
				} else {
					var buildReturn = '<img class="hide of-option-image" id="image_' + clickedID + '" src="' + response + '" alt="" />';
					$(".upload-error").remove();
					$("#image_" + clickedID).remove();
					clickedObject.parent().after(buildReturn);
					$('img#image_' + clickedID).fadeIn();
					clickedObject.next('span').fadeIn();
					clickedObject.parent().prev('input').val(response);
				}
			}
		});
	});

	// AJAX Remove (clear option value)
	$('.image_reset_button').click(function () {
		var clickedObject = $(this);
		var clickedID = $(this).attr('id');
		var theID = $(this).attr('title');

		var ajax_url = kk_ajax_data.ajaxurl;
		var data = {
			type : 'image_reset',
			action : 'of_ajax_post_action',
			data : theID
		};
		$.post(ajax_url, data, function (response) {
			var image_to_remove = $('#image_' + theID);
			var button_to_hide = $('#reset_' + theID);
			image_to_remove.fadeOut(500, function () {
				$(this).remove();
			});
			button_to_hide.fadeOut();
			clickedObject.parent().prev('input').val('');
		});

		return false;
	});

	// Save everything else
	$('#ofform').submit(function () {
		$(":checkbox").each(function () {
			this.value = this.checked;
			this.checked = true
		});
		var serializedReturn = $("#ofform").serialize();
		$(":checkbox").each(function () {
			this.checked = this.value.bool()
		});

		$('.ajax-loading-img').fadeIn();
		var ajax_url = kk_ajax_data.ajaxurl;
		var data = {
			type : 'save',
			action : 'of_ajax_post_action',
			data : serializedReturn
		};
		$.post(ajax_url, data, function (response) {
			$('.ajax-loading-img').fadeOut();
			var success = $('#of-popup-save');
			success.fadeIn();
			window.setTimeout(function () {
				success.fadeOut();
			}, 1000);
		});

		return false;
	});

	// Reset all options
	$('#ofform-reset').submit(function () {
		var ajax_url = kk_ajax_data.ajaxurl;
		var data = {
			type : 'reset',
			action : 'of_ajax_post_action',
		};
		$.post(ajax_url, data, function (response) {
			var reset = $('#of-popup-reset');
			reset.fadeIn();
			window.setTimeout(function () {
				location.reload()
			}, 250);
		});

		return false;
	});

});