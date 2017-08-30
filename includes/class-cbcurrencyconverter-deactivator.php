<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/includes
 * @author     codeboxr <info@codeboxr.com>
 */
class Cbcurrencyconverter_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		if ( ! current_user_can( 'activate_plugins' ) )
			return;
		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "deactivate-plugin_{$plugin}" );

	}

}
