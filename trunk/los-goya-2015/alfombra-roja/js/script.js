Cufon.replace('.section-left h2, .section-right h3, span[class^=heading]');

$(function() {
	
	$('.top-panel').bind('mousewheel', function(event, delta) {
		var target = $('.scroll-panel')[0];
		var newScrollTop = target.scrollTop - delta*60;
		if ( newScrollTop < 0 ) newScrollTop = 0;
		target.scrollTop = newScrollTop;
	});

	$('.menu-items').each(function() {
		$('li', this).not(':first').hide();
	});

	var menuExpanded = false;
	var expandedMenu = null;
	
	function expandMenu() {
		if ( targetMenu == null ) return;
		if ( menuExpanded ) return;
		
		menuExpanded = true;
		expandedMenu = targetMenu;
		$('li', targetMenu).not(':first').show();
		setTimeout(function() {
			var yChange = $(targetMenu).height() - 20;
			var newMenuHeight = 35 + yChange;
			var newContentHeight = 157 + yChange + ( infoPanelExpanded ? 165 : 0 );
			$('.nav-menu').animate({height: newMenuHeight + 'px'}, 250, 'swing');
			$('.scroll-inner-panel').animate({'padding-top': newContentHeight + 'px'}, 250, 'swing');
		}, 10);
	}
	
	function collapseMenu() {
		if ( expandedMenu == null ) return;
		
		menuExpanded = false;
		$('li', expandedMenu).not(':first').hide();
		setTimeout(function() {
			if ( !menuExpanded ) {
				$('.nav-menu').animate({height:'35px'}, 200, 'swing');
				
				var newPadding = 157 + ( infoPanelExpanded ? 165 : 0 );
				$('.scroll-inner-panel').animate({'padding-top':newPadding + 'px'}, 200, 'swing');
			}
		}, 250);
	}
	
	function collapseAll() {
		menuExpanded = false;
		$('.menu-items').each(function() {
			$('li', this).not(':first').hide();
		});		
		$('.nav-menu').animate({height:'35px'}, 200, 'swing');

		var newPadding = 157 + ( infoPanelExpanded ? 165 : 0 );
		$('.scroll-inner-panel').animate({'padding-top':newPadding + 'px'}, 200, 'swing');
	}
	
	var targetMenu = null;
	var expandMenuLock = false;
	
	$('.menu-items').bind('mouseenter', function(e) {
		targetMenu = this;
		if ( !expandMenuLock ) {
			expandMenuLock = true;
			setTimeout(function() {
				if ( expandMenuLock ) {
					expandMenuLock = false;
					expandMenu();
				}
			}, 200);
		}
	});

	$('.menu-items').bind('mouseleave', function(e) {
		targetMenu = null;
		expandMenuLock = false;
		collapseMenu();
	});
	
	var infoPanelExpanded = false;
	
	$('.nav-panel .right-text, .nav-panel .connect-button').click(function() {
		if ( !infoPanelExpanded ) {
			infoPanelExpanded = true;
			$('.nav-panel .connect-button').addClass('close');
			$('.info-panel').slideDown(250);
			$('.scroll-inner-panel').animate({'padding-top':'322px'}, 250, 'swing');
		} else {
			infoPanelExpanded = false;
			$('.nav-panel .connect-button').removeClass('close');
			$('.info-panel').slideUp(250);
			$('.scroll-inner-panel').animate({'padding-top':'157px'}, 250, 'swing');
		}
	});
	
	if ( $('.image-carousel').size() > 0 ) {
		
		var changeLock = false;
		
		$('.image-carousel').jcarousel({
			vertical: false,
			start: 1,
			scroll: 1,
			animation: 500,
			easing: 'easeOutQuad',
			wrap: null,
			itemVisibleInCallback: function() {
				changeLock = false;
			},
			buttonNextCallback: function(carousel, element, enabled) {
				if ( enabled ) {
					$('.slide-right').addClass('slide-right-enabled');
				} else {
					$('.slide-right').removeClass('slide-right-enabled');
				}
			},
			buttonPrevCallback: function(carousel, element, enabled) {
				if ( enabled ) {
					$('.slide-left').addClass('slide-left-enabled');
				} else {
					$('.slide-left').removeClass('slide-left-enabled');
				}
			}
			
	    });
		
		var carousel = $('.image-carousel').data('jcarousel');
		var slideIndex = carouselIndex;
		var slideItems = $('.image-carousel li').size();
		
		if ( slideItems > 0 ) {
				$('.slide-pager li:first').addClass('selected');
		$('.slider-container').append('<ul class="slide-pager"></ul>');
			for ( i = 0; i < slideItems; i++ ) {
				$('.slide-pager').append('<li>' + ( i + 1 ) + '</li>');
			}
			$('.image-carousel li img').not('.image-carousel li:first img').css('opacity', 0.2);
		}
	
		$('.slide-pager li').click(function(e) {
			if ( $(this).hasClass('selected') && changeLock ) return;
			
			changeLock = true;
			
			var newSlideIndex = $('.slide-pager li').index(this) + 1;
			
			carousel.scroll(newSlideIndex);
			$('.slide-pager li:nth-child(' + slideIndex + ')').removeClass('selected');
			$('.image-carousel li:nth-child(' + slideIndex + ') img').animate({'opacity':0.2}, 700, 'swing');
			slideIndex = newSlideIndex;
			$('.slide-pager li:nth-child(' + slideIndex + ')').addClass('selected');
			$('.image-carousel li:nth-child(' + slideIndex + ') img').animate({'opacity':1.0}, 700, 'swing');
			
		});
		
		$('.slide-left').click(function(e) {
			if ( slideIndex > 1 && !changeLock ) {
				changeLock = true;
				carousel.prev();
				$('.slide-pager li:nth-child(' + slideIndex + ')').removeClass('selected');
				$('.image-carousel li:nth-child(' + slideIndex + ') img').animate({'opacity':0.2}, 700, 'swing');
				slideIndex--;
				$('.slide-pager li:nth-child(' + slideIndex + ')').addClass('selected');
				$('.image-carousel li:nth-child(' + slideIndex + ') img').animate({'opacity':1.0}, 700, 'swing');
			}
		});
		
		$('.slide-right').click(function(e) {
			if ( slideIndex < slideItems && !changeLock ) {
				changeLock = true;
				carousel.next();
				$('.slide-pager li:nth-child(' + slideIndex + ')').removeClass('selected');
				$('.image-carousel li:nth-child(' + slideIndex + ') img').animate({'opacity':0.2}, 700, 'swing');
				slideIndex++;
				$('.slide-pager li:nth-child(' + slideIndex + ')').addClass('selected');
				$('.image-carousel li:nth-child(' + slideIndex + ') img').animate({'opacity':1.0}, 700, 'swing');
			}
		});
	}
	
	$('a.top').click(function(e) {
		var startTop = $(window).scrollTop();
		$('body').css('left', startTop);
		$('body').animate({'left': 0}, {duration: 400, easing: 'easeOutQuad', step: function(currentValue) {
			$(window).scrollTop(currentValue);
		}});
		e.preventDefault();
	});
        
        $('.slide-pager li')[slideIndex].click();
        changeLock = false;

});