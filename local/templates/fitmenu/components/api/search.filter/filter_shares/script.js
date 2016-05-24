$(document).on('ready', function() {
	
	var filter = $('.ts-filter');
	var filterParams = filter.find('.ts-filter__params');
	var paramsTrigger = filter.find('.ts-name');
	
	paramsTrigger.on('click', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active').parent().find(filterParams).hide();
		} else {
			paramsTrigger.removeClass('active');
			filterParams.hide();
			$(this).addClass('active').parent().find(filterParams).show();	
		}
	})

	// Адаптив
	if (screen.width < 480) {
		var tsFilterTitle = $('.ts-filter__title');
		tsFilterTitle.insertBefore('.ts-items');

		var tsFilterParams = $('.ts-items');
		tsFilterTitle.on('click', function () {
			if ($(this).hasClass('active')) {
				$(this).addClass('active');
				tsFilterParams.show();
			} else {
				$(this).removeClass('active');
				tsFilterParams.hide();
			}
		})
	}

});