
/* Waypoint Anchors
---------------------------------------------*/

(function($) {
	
	"use strict";

	jQuery(window).load( function($) {
		
		jQuery('.row.link_anchor').each(function(e) {
			var anchor_name = jQuery(this).attr('data-anchor-link'),
				anchor_link = '.row.link_anchor.anchor-' + anchor_name,
				offset = 0;
			
			if( jQuery('.header-wrap').hasClass('sticky-header') )
			{
				offset = jQuery('.header-wrap').height() * 2;	
			}
			
			jQuery(anchor_link).waypoint(function(down)
			{
				jQuery('#nv-tabs a').removeClass('waypoint_active');
				jQuery('#nv-tabs a').each(function() {
					if( jQuery(this).attr('href') == '#' + anchor_name )
					{
						jQuery(this).addClass('waypoint_active');
					}
				});
			},
			{
				offset: offset
			});	

			jQuery(anchor_link).waypoint(function(up)
			{
				jQuery('#nv-tabs a').removeClass('waypoint_active');
				jQuery('#nv-tabs a').each(function() {
					if( jQuery(this).attr('href') == '#' + anchor_name )
					{
						jQuery(this).addClass('waypoint_active');
					}
				});
			},
			{
				offset: -offset
			});						
					
        });
		
	});
	
})(jQuery);