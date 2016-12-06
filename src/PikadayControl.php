<?php 
/**
 * A Datepicker Control for the Wp Customizer based on Pikaday.
 * Some of the calendar configuration options accept a js function as a value so have been left out of this version.
 *
 * @see https://github.com/dbushell/Pikaday The Pikaday project on github.
 * 
 * @version 1.0.1
 */

namespace Zentheme\Customizer\Control;

use \WP_Customize_Control;


class PikadayControl extends WP_Customize_Control {

	/**
	 * Declare the control type
	 * @var string
	 */
	
	public $type = 'wpikaday';

	/**
	 * Use a different element to trigger opening the datepicker, see trigger example (default to field)
	 * @var string
	 */
	public $trigger;

	/**
	 * Automatically show/hide the datepicker on field focus.
	 * default: true if field is set
	 * @var boolean
	 */
	public $bound;

	/**
	 * Preferred position of the datepicker relative to the form field.
	 * default: 'bottom left'
	 * @var string
	 */
	public $position;

	/**
	 * Can be set to false to not reposition datepicker within the viewport, forcing it to take the configured
	 * position.
	 * default: true
	 * @var boolean
	 */
	public $reposition;

	/**
	 * The default output format for .toString() and field value.
	 * @see http://momentjs.com/ Moment.js for format suggestions.
	 * @var string
	 */
	public $format;

	/**
	 * The default flag for Moment's strict date parsing (requires Moment.js for custom formatting)
	 * @var boolean
	 */
	public $formatStrict;

	/**
	 * The initial date to view when first opened
	 * @var string (Date)
	 */
	public $defaultDate;

	/**
	 * Make the defaultDate the initial selected value
	 * @var string (Date)
	 */
	public $setDefaultDate;

	/**
	 * First day of the week (0: Sunday, 1: Monday, etc)
	 * @var integer
	 */
	public $firstDay;

	/**
	 * Disallow selection of Saturdays or Sundays
	 * @var boolean
	 */
	public $disableWeekends;

	/**
	 * Number of years either side (e.g. 10) or array of upper/lower range (e.g. [1900,2015])
	 * @var integer|array
	 */
	public $yearRange;

	/**
	 * Show the ISO week number at the head of the row.
	 * default: false
	 * @var boolean
	 */
	public $showWeekNumber;

	/**
	 * Reverse the calendar for right-to-left languages
	 * @var boolean
	 */
	public $isRTL;

	/**
	 * language defaults for month and weekday names.
	 * @var array
	 */
	public $i18n;

	/**
	 * Additional text to append to the year in the title.
	 * @var string
	 */
	public $yearSuffix;

	/**
	 * Render the month after year in the title.
	 * default: false
	 * @var boolean
	 */
	public $showMonthAfterYear;

	/**
	 * Render days of the calendar grid that fall in the next or previous months to the current month 
	 * instead of an empty table cell.
	 * default: false
	 * @var boolean
	 */
	public $showDaysInNextAndPreviousMonthsrendering; 

	/**
	 * Define a classname that can be used as a hook for styling different themes.
	 * default: null
	 * @var string
	 */
	public $theme;

	/**
	 * Enqueue the styles and scripts
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {

		wp_enqueue_script( 'moment', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js' );
		wp_enqueue_script( 'pikaday', '//cdnjs.cloudflare.com/ajax/libs/pikaday/1.5.1/pikaday.min.js', ['moment'] );
		wp_enqueue_script( 'pikaday-control', $this->assetUri( 'pikaday.min.js' ), ['pikaday', 'customize-controls'] );

		wp_enqueue_style( 'pikaday', '//cdnjs.cloudflare.com/ajax/libs/pikaday/1.5.1/css/pikaday.min.css' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 * Note: This method uses snake case since it overrides the parent method.
	 *
	 * @since 1.0.0	
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {

		parent::to_json();

		$params =  $this->getDatepickerParamNames();
		array_walk( $params, [$this, 'setJsonParam'] );
	}

	/**
	 * Render the content on the theme customizer page.
	 * Note: This method uses snake case since it overrides the parent method.
	 *
	 * @since 1.0.0	
	 */
	public function render_content() { ?>

		<label>
			<span class="customize-pikaday-control"><?php echo esc_html( $this->label ); ?></span>
			<input type="text" id="<?php echo $this->id; ?>" value="<?php echo $this->value(); ?>" class="pikaday-control" <?php $this->link(); ?> />
		</label>
	<?php
	}

	/**
	 * Load the assets for the Calendar.
	 *
	 * @since  1.0.0	
	 * @param  string $assetName The asset filename (including extension).
	 * @return string            The absolute url path to the asset.
	 */
	private function assetUri( $assetName ) {

		$path = content_url( str_replace( WP_CONTENT_DIR, '', dirname( __DIR__ ) ) );
		$assetType = pathinfo( $assetName, PATHINFO_EXTENSION );

		switch( $assetType ) {
			case 'js':
				return "{$path}/assets/js/{$assetName}";
			case 'css':
				return "{$path}/assets/css/{$assetName}";
			case 'jpg': case 'png': case 'gif': case 'svg':
				return "{$path}/assets/img/{$assetName}";
		}
		return "{$path}/assets";
	}

	/**
	 * Set a Json param variable. 
	 * Only sets values that have been explicitly defined in the Control config.
	 * 
	 * @since 1.0.0	
	 * @param string $name The param field name
	 */
	private function setJsonParam( $name ) {

		if( isset( $this->$name ) ) {
			$this->json[$name] = $this->$name;
		}
	}

	private function getDatepickerParamNames() {
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
}

