jQuery(window).on('load',function(){
	jQuery('.filtr-container').filterizr();
	jQuery('.simplefilter li').click(function() {
        jQuery('.simplefilter li').removeClass('active');
        jQuery(this).addClass('active');
    });
    
    //Shuffle control
    jQuery('.shuffle-btn').click(function() {
        jQuery('.sort-btn').removeClass('active');
    });
    //Sort controls
   jQuery('.sort-btn').click(function() {
        jQuery('.sort-btn').removeClass('active');
        jQuery(this).addClass('active');
    });
	jQuery('.phoen_filter_loader')	.hide();
});