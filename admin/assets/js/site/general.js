$(document).ready(function() {
	//Slider
	$("#slider").carousel({
		interval: 3000
	});
	
    $('#accordion').on('shown', function (e) {    
        $(e.target).prev('.accordion-heading').find('.accordion-toggle span').removeClass('icon-caret-right').addClass('icon-caret-down');
        $(e.target).prev('.accordion-heading').addClass('active');
    })
    
    $('#accordion').on('hidden', function (e) {
        $(e.target).prev('.accordion-heading').find('.accordion-toggle span').removeClass('icon-caret-down').addClass('icon-caret-right');
        $(this).find('.accordion-heading').not($(e.target)).removeClass('active');
    });
    
    if(exists('a[rel^="shadowbox"]')) {
        Shadowbox.init();
    }
    
    if($.supersized !== undefined) {
        init_supersized();
    }
    
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
    });
    
    if(exists('iframe')) {
        $('iframe').each(function () {/*fix youtube z-index*/
            var url = $(this).attr("src");
            if (url.indexOf("youtube.com") >= 0) {
                if (url.indexOf("?") >= 0) {
                    $(this).attr("src", url + "&wmode=transparent");
                } else {
                    $(this).attr("src", url + "?wmode=transparent");
                }
            }
        });
    }

});


function init_supersized(){
    jQuery(function($){
        $.supersized({
        	// Functionality
        	slideshow               :   1,			// Slideshow on/off
        	autoplay				:	1,			// Slideshow starts playing automatically
        	start_slide             :   1,			// Start slide (0 is random)
        	stop_loop				:	0,			// Pauses slideshow on last slide
        	random					: 	0,			// Randomize slide order (Ignores start slide)
        	slide_interval          :   5000,		// Length between transitions
        	transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        	transition_speed		:	1000,		// Speed of transition
        	new_window				:	1,			// Image links open in new window/tab
        	pause_hover             :   0,			// Pause slideshow on hover
        	keyboard_nav            :   1,			// Keyboard navigation on/off
        	performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
        	image_protect			:	1,			// Disables image dragging and right click with Javascript
        											   
        	// Size & Position						   
        	min_width		        :   0,			// Min width allowed (in pixels)
        	min_height		        :   0,			// Min height allowed (in pixels)
        	vertical_center         :   1,			// Vertically center background
        	horizontal_center       :   1,			// Horizontally center background
        	fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
        	fit_portrait         	:   1,			// Portrait images will not exceed browser height
        	fit_landscape			:   0,			// Landscape images will not exceed browser width
        											   
        	// Components							
        	slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
        	thumb_links				:	1,			// Individual thumb links for each slide
        	thumbnail_navigation    :   0,			// Thumbnail navigation
        	slides 					:  	[			// Slideshow Images
        										{image : _base_url+'uploads/slides/slide1.jpg', title : '<h1>Hi, we are <span class="pink raleway">Pixopolus</span></h1>', thumb : _base_url+'uploads/slides/slide1_thumb.jpg'},
        										{image : _base_url+'uploads/slides/slide2.jpg', title : '<h1>Photographer<br>&Design<span class="pink raleway">Agency</span></h1>', thumb : _base_url+'uploads/slides/slide2_thumb.jpg'},
        										{image : _base_url+'uploads/slides/slide3.jpg', title : '<h1>with an eye for <span class="pink raleway">detail.</span></h1>', thumb : _base_url+'uploads/slides/slide3_thumb.jpg'},
        										{image : _base_url+'uploads/slides/slide4.jpg', title : '<h1>Based in <br><span class="pink raleway">New York</span></h1>', thumb : _base_url+'uploads/slides/slide4_thumb.jpg'}
        										],
        	// Theme Options			   
        	progress_bar			:	1,			// Timer for each slide							
        	mouse_scrub				:	0
        	
        });   
    });
    
}