(function ($) {
	"use strict";

	jQuery(document).ready(function ($) {


		$('.toggle-topbar').click(function () {
			var container_expand = $(this).attr('href');
			var link = $(this);

			if ($('.show-container').attr('id') == container_expand.substring(1)) {
				$(container_expand).removeClass('show-container');


			} else if (!$('div').hasClass('show-container')) {
				$(container_expand).addClass('show-container');


			} else {
				$('.show-container').removeClass('show-container');
				$(container_expand).addClass('show-container');


			}

			if (link.hasClass('active-toggle')) {
				link.removeClass('active-toggle');
			} else {
				link.addClass('active-toggle');
			}

			return false;
		});

		if ('embed') {

			$("embed").each(function (index) {
				var height = $(this).attr('height');
				var width = $(this).attr('width');

				$(this).width(width);
				$(this).height(height);
			});

		}
		/*ADD photoswipe*/
		if ($(".gallery-icon a").length != 0)
			var myPhotoSwipe = $(".gallery-icon a").photoSwipe({ enableMouseWheel:false, enableKeyboard:false, captionAndToolbarAutoHideDelay:0, captionAndToolbarFlipPosition:true });
		//fixed menu
		var nav = $('.fixed-menu');
		var max_margin = $('#page').height();
		var front_page_header_height = $('.frontpage-header').height();
		$(window).scroll(function () {
			var scrollTop = $(this).scrollTop();
			if (scrollTop > 230) {
				if (scrollTop < max_margin - 230)
					nav.css("margin-top", scrollTop - 70 - front_page_header_height);
			} else {
				nav.css("margin-top", 0);
			}
		});
		if (Modernizr.touch) {
			jQuery('#top-bar').fadeIn();
			topNavScroll();
		}
	});
	var isHidden = false;
	function topNavScroll() {
		jQuery(window).scroll(function () {

			if (!isHidden) {
				//Animate off the screen while scrolling
				jQuery('#top-bar').animate({
					top:'-55px'
				}, 250, function () {
					//Make hidden to disable re-rendering
					jQuery('#top-bar')[0].style.visibility = "hidden";
				});
				isHidden = true;
			}
			clearTimeout(jQuery.data(this, 'scrollTimer'));
			jQuery.data(this, 'scrollTimer', setTimeout(function () {
				//Animate back on the screen when finished scrolling and make visible
				jQuery('#top-bar')[0].style.visibility = "visible";
				jQuery('#top-bar').animate({
					top:'0px'
				}, 250, function () {
				});
				isHidden = false;
			}, 500));
		});
	}
})(jQuery);








