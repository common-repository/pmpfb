(function( $ ) {
	'use strict';

	/**
	 * All of the code for admin-facing JavaScript source
	 */

	 $(function() {


		// Initialize tabs for PMPForm Builder
		var pmpfbTabs = tabs({
			el: '.pmpfb-tabs',
			tabNavigationLinks: '.nav-tab',
			tabContentContainers: '.pmpfb-tab'
		});
		pmpfbTabs.init();	 
	 
		// Initialize Checkout Repeatable
		$("#pmpfb-form .checkout_labels .repeatable").repeatable({
			addTrigger: "#pmpfb-form .add",
			deleteTrigger: ".checkout_labels .delete",
			template: "#checkout_labels",
			startWith: 1,
			// max: 5
		});



	});

})( jQuery );