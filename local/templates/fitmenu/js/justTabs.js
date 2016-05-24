(function($) {
$(function() {

$.fn.justTabs = function(options) {
	var _container = this;
	var _tabs = _container.children('div');
	
	var options = $.extend({
		nav: false,
		openDefault: _tabs.eq(0),
		effect: 'fade',
		fadeSpeed: 300,
		animateHeight: true,
		heightSpeed: 300
	}, options);
	
	var _links = $(options.nav).find('a');
	var _activeTab = options.openDefault;
	var _activeLink;
	
	if(!options.nav) {
		alert('Enter a navigation ul');
	}
	else {
	
		if(options.animateHeight) {
			_tabs.each(function(){
				$(this).height($(this).height());
			});
			if(options.openDefault) {
				_container.height(_activeTab.height());
			}
		}
		
		_tabs.hide();
		
		if(options.openDefault) {
			_activeTab.addClass('active-tab').show();
		}
		
		_links.each(function(){
			if($(this).attr('href') == '#'+$(_activeTab).attr('id')) {
				_activeLink = $(this);
				_activeLink.addClass('active');
				return false;
			}
		});
		
		_links.click(function(){
			if(!$(this).hasClass('active')) {
				if(_activeLink != undefined) {
					$(_activeLink).removeClass('active');
				}
				_activeLink = $(this);
				_activeLink.addClass('active');
				
				if(_activeTab != undefined) {
					$(_activeTab).removeClass('active-tab').hide();
				}
				_activeTab = $($(this).attr('href'));
				
				function showTab() {
					if(options.effect == "fade") {
						_activeTab.addClass('active-tab').css('opacity', 0).show().animate({'opacity': 1}, {duration: options.fadeSpeed, queue: false});
					}
					else if(options.effect == "show") {
						_activeTab.addClass('active-tab').show();
					}
				}
				
				if(options.animateHeight) {
					_container.animate({'height': _activeTab.outerHeight()}, { duration: options.heightSpeed, queue:false, complete: function(){
						showTab();
					}});
				}
				else {
					showTab();
				}
			}
			return false;
		});
		
	}
	
}

});
})(jQuery);