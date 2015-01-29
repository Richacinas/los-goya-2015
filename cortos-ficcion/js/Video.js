var Video = function() {
	
};

Video.prototype.placeHomeVideo = function() {
	var videoW = $("#home-video").width();
	var videoH = $("#home-video").height();
	var videoRel = videoW/videoH;
	var windowH = $(window).height();
	var windowW = $(window).width();
	var windowRel = windowW/windowH;
	//if (windowRel <= videoRel) {
	if (windowW < windowH) {
		$("#home-video-preview").css('height', '100%');
		$("#home-video-preview").css('width', 'auto');
		$("#home-video-container").css('height', '100%');
		$("#home-video-container").css('width', 'auto');
		$("#home-video").css('height', '100%');
		$("#home-video").css('width', 'auto');
	} else {
		$("#home-video-preview").css('height', 'auto');
		$("#home-video-preview").css('width', '100%');
		$("#home-video-container").css('height', 'auto');
		$("#home-video-container").css('width', '100%');
		$("#home-video").css('height', 'auto');
		$("#home-video").css('width', '100%');
	}
};

Video.prototype.stopAll = function() {
	$("video").each(function() {
		$(this).get(0).pause();
	});
};

Video.prototype.loadVideos = function() {
	$("video").each(function(i, video) {
		var videoName = $(this).data("video");
		if (videoName !="")
		{
			$(this).children("source[type='video/mp4']").attr("src", 'videos/'+videoName+'.mp4');
			$(this).children("source[type='video/ogv']").attr("src", 'videos/'+videoName+'.ogv');
			$(this).children("source[type='video/webm']").attr("src", 'videos/'+videoName+'.webm');
			$(this).get(0).load();
		}
	});
};