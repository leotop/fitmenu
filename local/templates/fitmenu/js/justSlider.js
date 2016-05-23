(function($) {
$(function() {

$.fn.justSlider = function(options) {
	var options = $.extend({
		effect: 'slide',
		speed: 500,
		pause: 5000,
		prevNext: true,
		navigation: true,
		pauseHover: false,
		recurrence: true,
		slideNumbers: false,
		autoHeight: false,
		resize: false
	}, options);
	
	return this.each(function(){
		
		var sliderObject = this;
		var _slider = $(this);
		
		//Reload Slider
		if(_slider.find('.js-slide')) {
			clearTimeout(sliderObject.timeout);
			_slider.find('.slider-nav, .prev, .next').remove();
			_slider.find('.js-slide').unwrap().unwrap();
		}
		
		//Variables
		var _slides = _slider.children();
		var _width = _slider.width();
		var _number = _slides.length;
		var index = 0;
		var _next;
		var _prev;
		var _flag = true;
		var _links;
		var direction;
		var nextIndex;
		
		if(_number > 1) {
			
			function maxHeightEl(sel) {
				var maxH = 0;
				sel.each(function(){
					var thisEl = $(this);
					var thisElHeight = thisEl.height();
					if(maxH < thisElHeight) maxH = thisElHeight;
				});
				return maxH;
			}
			
			if(!options.pause) {options.pauseHover = false;}
			
			//Preload
			_slides.wrapAll('<div class="slideWrapper"></div>')
			.addClass('js-slide');
			
			var _wrapper = _slider.children($('div.slideWrapper'));
			
			_wrapper.css({
				'overflow':'visible',
				'position':'relative',
				'left':0,
				'top':0
			})
			.width(_width).height(_slides.height())
			.wrap('<div class="slide-overflow"></div>');
			
			_slider.css('overflow', 'visible');
			var _overflow = _slider.children('div.slide-overflow');
			_overflow.css({
				'overflow': 'hidden',
				'position': 'relative',
				'zoom':1
			});
			
			if(options.autoHeight) {
				_wrapper.height(maxHeightEl(_slides));
				_overflow.height(_slides.height());
				_slider.css('height', 'auto');
			}
			
			_slides.css({
				'display':'none',
				'position':'absolute',
				'top':0, 'zIndex':100
			});
			
			if(options.effect == 'slide') {
				_slides.eq(0).css({'display':'block', 'left':0});
				_slides.eq(1).css({'display':'block', 'left':_width});
			}
			else {
				_slides.css('left', 0);
				_slides.eq(0).css({'display':'block', 'zIndex':110});
				_slides.eq(1).css({'display':'block'});
			}
			
			
			//Move Slider Function
			var moveSlider = function(nextIndex) {
			
				if(options.pause != 0) {
					sliderObject.timeout = setTimeout(function(){moveSlider();}, options.pause);
				}
				
				if(nextIndex === undefined) nextIndex = index + 1;
				if(nextIndex > index) {
					direction = true;
				}
				else {
					direction = false;
				}
				var _prevSlide = _slides.eq(index);
				if(direction) {
					if(index == _number - 1) {
						if(options.recurrence) index = 0;
						else {clearTimeout(sliderObject.timeout); return false;}
					}
					else {
						index = nextIndex;
					}
				}
				else {
					if(index == 0) {
						if(options.recurrence) index = _number - 1;
						else return false;
					}
					else {
						index = nextIndex;
					}
				}
				
				var _nextSlide = _slides.eq(index);
				
				if(options.navigation) {
					_links.removeClass('active');
					_links.eq(index).addClass('active');
				}
				
				if(options.effect === 'slide') {
					_slides.css('display', 'none');
					if(direction) {
						_prevSlide.css({'display': 'block', 'left':0});
						_nextSlide.css({'display': 'block', 'left':_width});
						_wrapper.animate({'left': - _width}, options.speed, function(){
							_wrapper.css('left', 0);
							_prevSlide.css('display', 'none');
							_nextSlide.css('left', 0);
						});
					}
					else {
						_prevSlide.css({'display': 'block', 'left':0});
						_nextSlide.css({'display': 'block', 'left': - _width});
						_wrapper.animate({'left': _width}, options.speed, function(){
							_wrapper.css('left', 0);
							_prevSlide.css('display', 'none');
							_nextSlide.css('left', 0);
						});
					}
				}
				else {
					_prevSlide.css({'display':'block', 'zIndex':110});
					_nextSlide.css({'display':'block'});
					_prevSlide.fadeOut(options.speed, function(){
						_prevSlide.css('zIndex', 100).hide();
						_nextSlide.css('zIndex', 110);
					});
				}
				
				if(options.autoHeight) {
					var nextSlideH = _nextSlide.height();
					_overflow.animate({
						'height': nextSlideH
					}, options.speed);
				}
				
				if(options.slideNumbers) {
					_slideNumbers.text((index+1)+options.slideNumbers+_number);
				}
			
			}
			
			
			//Prev Next Btns
			function prevNextSlide() {
			
				_slider.append('<a href="#" class="prev"></a><a href="#" class="next"></a>');
				_next = _slider.children('a.next');
				_prev = _slider.children('a.prev');
				
				_next.click(function(){
					if(!$(_slider).find(':animated').length) {
						if(options.pause != 0) {
							clearTimeout(sliderObject.timeout);
						}
						moveSlider(index + 1);
					}
					return false;
				});
				
				_prev.click(function(){
					if(!$(_slider).find(':animated').length) {
						if(options.pause != 0) {
							clearTimeout(sliderObject.timeout);
						}
						moveSlider(index - 1);
					}
					return false;
				});
			}
			
			//Pause Hover
			function hoverPause() {
				_overflow.hover(function(){
					clearTimeout(sliderObject.timeout);
				}, function(){
					clearTimeout(sliderObject.timeout);
					sliderObject.timeout = setTimeout(function(){moveSlider();}, options.pause);
				});
			}
			
			
			//Slider Navigation
			function sliderNav() {
				var _li = "";
				for(var i = 0; i < _number; i++) {
					_li = _li + '<li><a href="#">'+(i+1)+'</a></li>';
				}
				_slider.append('<div class="slider-nav"><ul>'+_li+'</ul></div>');
				_links = _slider.find('div.slider-nav a');
				_links.eq(index).addClass('active');
				_links.click(function(){
					if(!$(this).hasClass('active')) {
						if($(_slider).find(':animated').size() == 0) {
							_links.removeClass('active');
							$(this).addClass('active');
							
							if(options.pause != 0) {
								clearTimeout(sliderObject.timeout);
							}	
							
							moveSlider(_links.index(this));
						}
					}
					return false;
				});
			}
			
			
			//Slide Numbers
			function slideNumbers() {
				_slider.append('<div class="slide-number"></div>');
				_slideNumbers = _slider.children('div.slide-number');
				_slideNumbers.text((index+1)+options.slideNumbers+_number);
			}
			
			//Resize
			function sliderResize() {
				$(window).resize(function(){
					_width = _slider.width();
				});
			}
			
			
			//Calling Funcitons
			if(options.navigation) {
				sliderNav();
			}
			if(options.pause != 0) {
				sliderObject.timeout = setTimeout(function(){moveSlider();}, options.pause);
			}
			
prevNextSlide();

			if(options.pauseHover) {
				hoverPause();
			}
			if(options.slideNumbers) {
				slideNumbers();
			}
			if(options.resize) {
				sliderResize();
			}
		
		}
	});
}

});
})(jQuery);