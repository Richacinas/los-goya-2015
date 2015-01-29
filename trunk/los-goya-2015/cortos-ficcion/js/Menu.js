var Menu = function () {
};

// Comprobacion del posicionamiento pagina/menu
Menu.prototype.checkMenuActive = function() {
	var self = this;
	var scrollTop = $(window).scrollTop();
	var middleScreen = scrollTop + ($(window).height() / 2);
	var sections = $(".main-section");
	$.each(sections, function(index, section) {
		var topSection = $(section).offset().top;
		var sectionId = $(section).attr("id");
		if (index+1 < sections.length) {
			var topNextSection = $(sections[index+1]).offset().top;
		} else {
			var topNextSection = $(window).height();
		}
		if (sectionId === 'home-section') {
			if (middleScreen < topNextSection) {
				self.moveMenuSelectorTo(sectionId);
				return false;
			}
		} else {
			if (middleScreen > topSection && middleScreen < topNextSection) {
				self.moveMenuSelectorTo(sectionId);
				return false;
			}
			else if (index === sections.length-1){
				self.moveMenuSelectorTo(sectionId);
				return false;
			}
		}
	});
};

// Barra de menu desplazable
Menu.prototype.moveMenuSelectorTo = function(sectionId) {
	var itemW = $("#menu-"+sectionId).width();
	var itemSelectorW = $("#menu-select").width();

	if (sectionId !== 'home-section') {
		var itemLeft = $("#menu-"+sectionId).offset().left;
	} else {
		var itemLeft = -$(window).width()/4;
	}
	var itemSelectorDiff = itemW - itemSelectorW;
	var itemSelectorPos = itemLeft + itemSelectorDiff/1.5;
	$("#menu-select").stop().animate(
	{
		"left": itemSelectorPos+"px"
	},
	100,'easeOutCirc');
};

// Ir a -> localizacion menu
Menu.prototype.navigateTo = function(sectionId) {
	var aTag = $("#"+ sectionId);
	$('html,body').stop().animate(
		{scrollTop: aTag.offset().top},
		1000,'easeOutCirc');
};