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
		// Video preview if apple device
		if (isAppleDevice) {
			$("#play-icon").show();
			$("#preview-video-texto-apple").show().on("click", function() {
				$("#preview-video-texto-apple").stop().fadeOut("fast");
				$("#play-icon").stop().fadeOut("fast");
				$("#video-texto").get(0).play();
			});
			$("#play-icon2").show();
			$("#preview-video-apple1").show().on("click", function() {
				$("#preview-video-apple1").stop().fadeOut("fast");
				$("#play-icon2").stop().fadeOut("fast");
				$("#video-apple-1").get(0).play();
			});
			$("#play-icon3").show();
			$("#preview-video-apple2").show().on("click", function() {
				$("#preview-video-apple2").stop().fadeOut("fast");
				$("#play-icon3").stop().fadeOut("fast");
				$("#video-apple-2").get(0).play();
			});
		}
	});
});