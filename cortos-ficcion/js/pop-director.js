jQuery(function($) {
	// Mostramos pop-up con el trailler de cada director
	$(".director").on("click", function() {
		showTrailer(this);
	});
	$("#fondo-trailers").on("click", function() {
		hideTrailer();
	});
	var AppleDevice = (
			(navigator.userAgent.toLowerCase().indexOf("ipad") > -1) ||
			(navigator.userAgent.toLowerCase().indexOf("iphone") > -1) ||
			(navigator.userAgent.toLowerCase().indexOf("ipod") > -1)
			);
	//Mostrar mascara y div trailer
	function showTrailer(director){
		$("#trailer-mp4").attr("src","videos/trailer-"+director.id+".mp4");
		$("#trailer-ogv").attr("src","videos/trailer-"+director.id+".ogv");
		$("#trailer-webm").attr("src","videos/trailer-"+director.id+".webm");
		$("#video-trailer").load();
		if (AppleDevice) {
			$("#video-trailer").get(0).play();
		}
		else
		{
			$("#video-trailer").attr("poster","http://lab.pre.rtve.es/los-goya-2015/cortos-ficcion/images/trailer-"+director.id+".png");
		}
		$("#fondo-trailers").fadeIn("slow");
		$("#trailers").fadeIn("slow");
	}

	//Ocultar mascara y div trailer
	function hideTrailer(){
		$("#fondo-trailers").fadeOut( "slow" );
		$("#video-trailer").get(0).pause();
		$("#trailers").fadeOut( "slow" );
		$("#trailer-mp4").attr("src","");
		$("#trailer-ogv").attr("src","");
		$("#trailer-webm").attr("src","");
		$("#video-trailer").attr("poster","");
	}	
});