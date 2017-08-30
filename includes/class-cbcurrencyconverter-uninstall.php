<?php

    /**
     * Fired during plugin uninstallation
     *
     * @link       http://codeboxr.com
     * @since      1.0.0
     *
     * @package    Cbcurrencyconverter
     * @subpackage Cbcurrencyconverter/includes
     */

    /**
     * Fired during plugin uninstallation.
     *
     * This class defines all code necessary to run during the plugin's deactivation.
     *
     * @since      1.0.0
     * @package    Cbcurrencyconverter
     * @subpackage Cbcurrencyconverter/includes
     * @author     codeboxr <info@codeboxr.com>
     */
    class Cbcurrencyconverter_Uninstall {

        /**
         * Short Description. (use period)
         *
         * Long Description.
         *
         * @since    1.0.0
         */
        public static function uninstall() {

            if ( ! current_user_can( 'activate_plugins' ) ) {
                return;
            }

            check_admin_referer( 'bulk-plugins' );

            // Important: Check if the file is the one
            // that was registered during the uninstall hook.
            if ( __FILE__ != WP_UNINSTALL_PLUGIN )
                return;

            $cbcurrencyconverter_tools = get_option('cbcurrencyconverter_tools');

            if(isset($cbcurrencyconverter_tools['cbcurrencyconverter_delete_options']) && $cbcurrencyconverter_tools['cbcurrencyconverter_delete_options'] == 'on' ){

                //delete all option entries created by this plugin
                delete_option('cbcurrencyconverter_global_settings');
                delete_option('cbcurrencyconverter_calculator_settings');
                delete_option('cbcurrencyconverter_list_settings');
                delete_option('cbcurrencyconverter_tools');
                delete_option('cbcurrencyconverter_integration');
            }

        }

    }
