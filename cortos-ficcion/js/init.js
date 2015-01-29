jQuery(function($) {
	$(document).ready(function() {
		var isAppleDevice = (
			(navigator.userAgent.toLowerCase().indexOf("ipad") > -1) ||
			(navigator.userAgent.toLowerCase().indexOf("iphone") > -1) ||
			(navigator.userAgent.toLowerCase().indexOf("ipod") > -1)
			);
		var isMobile = false;
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 			isMobile = true;
		}

		var video = new Video();
		var menu = new Menu();

		var setMainWidth = function() {
			if(isMobile) {
				var docw = $(document).innerWidth();
				$(".main-section, body, #wrapper, .video-preview-mask").width(docw);
				var headerW = $("header").innerWidth();
				$(".main-section, body, #wrapper, .video-preview-mask").width(headerW);
			
				// Article videos
				$(".article-video video").css("margin-left", (headerW - $(".article-video video:first").innerWidth())/2);
		    }
		};

		setMainWidth();
		menu.checkMenuActive();

		$(window).resize(function() {
			setMainWidth();
			menu.checkMenuActive();
		});

		// Main scroll
		$(window).on("scroll", function() {
			menu.checkMenuActive();
		});
		// Menu navigation
		$(".menu-item").on("click", function() {
			var sectionId = $(this).data('section');
			menu.navigateTo(sectionId);
		});

	});
});