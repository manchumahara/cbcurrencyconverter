<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/includes
 * @author     codeboxr <info@codeboxr.com>
 */
class Cbcurrencyconverter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cbcurrencyconverter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
