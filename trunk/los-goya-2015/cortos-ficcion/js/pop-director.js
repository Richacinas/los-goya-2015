jQuery(function($) {
	// Mostramos pop-up con el trailler de cada director
	$(".director").on("click", function() {
		showTrailer(this);
	});
	$("#fondo-trailers").on("click", function() {
		hideTrailer();
	});

	//Mostrar mascara y div trailer
	function showTrailer(director){
		$("#video-trailer").attr("poster","images/trailer-"+director.id+".png");
		$("#trailer-mp4").attr("src","videos/trailer-"+director.id+".mp4");
		$("#trailer-ogv").attr("src","videos/trailer-"+director.id+".ogv");
		$("#trailer-webm").attr("src","videos/trailer-"+director.id+".webm");
		$("#video-trailer").load();
		$("#fondo-trailers").fadeIn( "slow" );
		$("#trailers").fadeIn( "slow" );
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
		$("#preview-video-trailer").attr("src","");
	}	
});