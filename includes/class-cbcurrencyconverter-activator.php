<?php

/**
 * Fired during plugin activation
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/includes
 * @author     codeboxr <info@codeboxr.com>
 */
class Cbcurrencyconverter_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$check_cbcurrencyconvert_options_ = (array());
		$check_cbcurrencyconvert_options = (get_option('cbcurrencyconverter_global_settings'));


		if(is_string($check_cbcurrencyconvert_options) && $check_cbcurrencyconvert_options == ''){
			$check_cbcurrencyconvert_options_['cbcurrencyconverter_defaultlayout']   = 'cal';
		}

		update_option('cbcurrencyconverter_global_settings',$check_cbcurrencyconvert_options_);

		$check_cbcurrencyconvert_options = (get_option('cbcurrencyconverter_calculator_settings'));

		if(is_string($check_cbcurrencyconvert_options) && $check_cbcurrencyconvert_options == ''){

			$check_cbcurrencyconvert_options['cbcurrencyconverter_fromcurrency']                 = 'USD';
			$check_cbcurrencyconvert_options['cbcurrencyconverter_tocurrency']                   = 'USD';
			$check_cbcurrencyconvert_options['cbcurrencyconverter_defaultamount_for_calculator'] = 1;
			$check_cbcurrencyconvert_options['cbcurrencyconverter_title_cal']                    = __('Calculator', 'cbcurrencyconverter');
			$check_cbcurrencyconvert_options['cbcurrencyconverter_decimalpoint']                 = 2;

		}

		update_option('cbcurrencyconverter_calculator_settings',$check_cbcurrencyconvert_options);

		$check_cbcurrencyconvert_options = (get_option('cbcurrencyconverter_list_settings'));

		if(is_string($check_cbcurrencyconvert_options) && $check_cbcurrencyconvert_options == ''){

			$check_cbcurrencyconvert_options['cbcurrencyconverter_defaultcurrency_list']                 = 'USD';
			$check_cbcurrencyconvert_options['cbcurrencyconverter_tocurrency_list']                      =  array( 'ALL'=>'ALL');
			$check_cbcurrencyconvert_options['cbcurrencyconverter_defaultamount_forlist']                = 1;
			$check_cbcurrencyconvert_options['cbcurrencyconverter_title_list']                           = __('List', 'cbcurrencyconverter');
			$check_cbcurrencyconvert_options['cbcurrencyconverter_decimalpoint']                         = 2;
		}
		update_option('cbcurrencyconverter_list_settings',$check_cbcurrencyconvert_options);

	}

}
