$(function(){
    $('.gallery').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a.a',
    		type: 'image',
    		tLoading: 'Loading image #%curr%...',
    		mainClass: 'mfp-img-mobile',
    		gallery: {
    			enabled: true,
    			navigateByImgClick: true,
    			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    		},
    		image: {
    			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
    			titleSrc: function(item) {
    				return item.el.attr('title') + '<small class="copyright"> &copy; Фитменю</small>';
    			}
    		}
        });
    });
    
})