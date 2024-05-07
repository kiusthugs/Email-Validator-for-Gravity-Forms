<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/kiusthugs
 * @since      1.0.0
 *
 * @package    Elvgf
 * @subpackage Elvgf/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Elvgf
 * @subpackage Elvgf/includes
 * @author     Kirt Perez, BTV Marketing <kirtperez3245@gmail.com>, Tom Madrid, MixTape Las Vegas
 */
class Elvgf_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'elvgf',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
