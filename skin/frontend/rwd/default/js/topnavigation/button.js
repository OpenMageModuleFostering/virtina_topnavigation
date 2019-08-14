/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

jQuery(document).ready(function() {
	// add button
   jQuery('.mega-menu > .nav-column').append(jQuery('<button class="close">X</button>'));

   // for dropdown
   jQuery('ul.nav > li').hover(function(){
    	jQuery(this).children('.mega-menu').stop().removeClass('deactivate').toggleClass('active');
   });

   //for close dropdown
   jQuery('.close').click(function(){
   		jQuery('.mega-menu').addClass('deactivate');
   });

});
