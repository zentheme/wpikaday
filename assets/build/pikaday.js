/**
 * The main Pikaday datepicker control script.
 */

document.addEventListener( 'DOMContentLoaded', function( event ) {

	const api = wp.customize;
	const datepickers = document.querySelectorAll( '.pikaday-control' );

	for( let datepicker of datepickers ) {
		
		const setting = api.instance( datepicker.id );
		const control = api.control.instance( datepicker.id );
		const paramsObj = {
			field: datepicker
		};

		// Set all non-null control params
		getDatepickerParamNames().forEach( value => {

			if( typeof control.params[value] !== "undefined" ) {
				paramsObj[value] = control.params[value];
			}
		} );

		// Create the Pikaday Object
		new Pikaday( paramsObj );
	}

	function getDatepickerParamNames() {
		return [
			'trigger', 
			'bound', 
			'position', 
			'reposition', 
			'format', 
			'formatStrict', 
			'defaultDate', 
			'setDefaultDate', 
			'firstDay', 
			'disableWeekends', 
			'yearRange', 
			'showWeekNumber', 
			'isRTL', 
			'i18n', 
			'yearSuffix', 
			'showMonthAfterYear', 
			'showDaysInNextAndPreviousMonthsrendering', 
			'theme'];
	}

	// The datepicker gets buried under the overlay container when added to an input, so up the z-index to the overlay container+1 to make it visible.
	const overlayZindex = window.getComputedStyle( document.querySelector( '.wp-full-overlay' ) ).getPropertyValue( 'z-index' );
	const singlePikas = document.querySelectorAll( '.pika-single' );
	for( let singlePika of singlePikas ) {
		singlePika.style.zIndex = overlayZindex + 1;
	}
} );