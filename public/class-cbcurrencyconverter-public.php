<?php

    /**
     * The public-facing functionality of the plugin.
     *
     * @link       http://codeboxr.com
     * @since      1.0.0
     *
     * @package    Cbcurrencyconverter
     * @subpackage Cbcurrencyconverter/public
     */

    /**
     * The public-facing functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Cbcurrencyconverter
     * @subpackage Cbcurrencyconverter/public
     * @author     codeboxr <info@codeboxr.com>
     */
    class Cbcurrencyconverter_Public {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $plugin_name The ID of this plugin.
         */
        private $plugin_name;

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private $version;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         *
         * @param      string $plugin_name The name of the plugin.
         * @param      string $version     The version of this plugin.
         */
        public function __construct($plugin_name, $version) {

            $this->plugin_name = $plugin_name;
            $this->version     = $version;

        }

        public function cbcurrencyconverter_init(){

            do_action('cbcurrencyconverter_public', $this);
        }

        /**
         * Register the stylesheets for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {

            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cbcurrencyconverter-public.css', array(), $this->version, 'all');

            wp_enqueue_style($this->plugin_name . '-widget-styles', plugin_dir_url(__FILE__) . 'css/cbcurrencyconverter_widget.css', array(), $this->version, 'all');

        }

        /**
         * Register the JavaScript for the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts() {

            $ajax_nonce = wp_create_nonce("cbcurrencyconverter_nonce");
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cbcurrencyconverter-public.js', array('jquery'), $this->version, false);

            wp_register_script($this->plugin_name . '-script', plugin_dir_url(__FILE__) . 'js/cbcurrencyconverter_widget.js', array('jquery'), $this->version, false);
            wp_localize_script($this->plugin_name . '-script', 'currrency_convert', array(
                'ajaxurl'    => admin_url('admin-ajax.php'),
                'nonce'      => $ajax_nonce,
                'wronginput' => __('Input in wrong format', 'cbcurrencyconverter')
            ));

            wp_enqueue_script($this->plugin_name . '-script');

        }


        /**
         * @return string
         */
        public function cbcurrencyconverter_shortcode($atts) {

            $instance         = array();

            $setting_api      = get_option('cbcurrencyconverter_global_settings');
            $setting_api_list = get_option('cbcurrencyconverter_list_settings');
            $setting_api_cal  = get_option('cbcurrencyconverter_calculator_settings');


            //general setting
            $layout              = (isset($setting_api['cbcurrencyconverter_defaultlayout'])) ? $setting_api['cbcurrencyconverter_defaultlayout'] : 'cal';
            $decimalpoint        = (isset($setting_api['cbcurrencyconverter_decimalpoint'])) ? $setting_api['cbcurrencyconverter_decimalpoint'] : 2;


            //list setting
            $list_title                = (isset($setting_api_list['cbcurrencyconverter_title_list'])) ? $setting_api_list['cbcurrencyconverter_title_list'] : __('List of Currency', 'cbcurrencyconverter'); //list title
            $list_from_currency        = (isset($setting_api_list['cbcurrencyconverter_defaultcurrency_list'])) ? $setting_api_list['cbcurrencyconverter_defaultcurrency_list'] : 'USD'; //we need to set something as default currency to make the list work
            $list_to_currency          = (isset($setting_api_list['cbcurrencyconverter_tocurrency_list'])) ? $setting_api_list['cbcurrencyconverter_tocurrency_list'] : array('GBP'); //list of currency
            $list_default_amount       = (isset($setting_api_list['cbcurrencyconverter_defaultamount_forlist'])) ? $setting_api_list['cbcurrencyconverter_defaultamount_forlist'] : 1; //default amount


            //calculator setting
            $calc_title                = (isset($setting_api_cal['cbcurrencyconverter_title_cal'])) ? $setting_api_cal['cbcurrencyconverter_title_cal'] : __('Currency Calculator', 'cbcurrencyconverter');
            $calc_from_currency        = (isset($setting_api_cal['cbcurrencyconverter_fromcurrency'])) ? $setting_api_cal['cbcurrencyconverter_fromcurrency'] : '';
            $calc_to_currency          = (isset($setting_api_cal['cbcurrencyconverter_tocurrency'])) ? $setting_api_cal['cbcurrencyconverter_tocurrency'] : '';
            $calc_default_amount       = (isset($setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'])) ? $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] : 1;
            $calc_currencies           = (isset($setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'])) ? $setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'] : array_keys(Cbcurrencyconverter::getCurrencyList());




            $instance = shortcode_atts(array(
                                                'layout'              => $layout, //cal, list, calwithlisttop, calwithlistbottom
                                                'decimalpoint'        => $decimalpoint, //this is common for cal and list both
                                                'calc_currencies'     => implode(',', $calc_currencies), //list of currency, comma separated user input, example USD,GBP
                                                'calc_title'          => $calc_title, //string any title
                                                'calc_from_currency'  => $calc_from_currency, //example USD
                                                'calc_to_currency'    => $calc_to_currency, //example GBP
                                                'calc_default_amount' => $calc_default_amount, //numeric value
                                                'hide'                => '',//show/hide up/down button for calculator empty  =  both, other possible value up, down  up = show  up button, down = show down button
                                                'list_title'          => $list_title, // string
                                                'list_from_currency'  => $list_from_currency, //USD
                                                'list_to_currency'    => implode(',',$list_to_currency), //comma separated, example  GBP,BDT
                                                'list_default_amount' => $list_default_amount, //numeric value

                                            ), $atts);

            $instance['calc_currencies'] = explode(',', $instance['calc_currencies']);
            $instance['list_to_currency'] = explode(',', $instance['list_to_currency']);



            extract($instance);

            if ($layout == 'list') {
                return cbxcclistview('shortcode', $instance);
            } elseif ($layout == 'cal') {
                return cbxcccalcview('shortcode', $instance);
            } elseif ($layout == 'calwithlistbottom') {
                return cbxcccalcview('shortcode', $instance) . cbxcclistview('shortcode', $instance);
            } elseif ($layout == 'calwithlisttop') {
                return cbxcclistview('shortcode', $instance) . cbxcccalcview('shortcode', $instance);
            }

        }//end method codeboxrcurrencyconverter_shortcode


        /**
         * Google finannce method for showing the converstion value
         *
         * @param     $convertion_value
         * @param     $price
         * @param     $convertfrom
         * @param     $convertto
         * @param int $decimalpoint
         *
         * @return  rating value
         */
        public function cbxconvertcurrency_method_google($convertion_value, $price, $convertfrom, $convertto, $decimalpoint = 2){
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/finance/converter?a=" . $price . "&from=" . $convertfrom . "&to=" . $convertto . " ");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($ch);

            curl_close($ch);

            $data = explode('<div id=currency_converter_result>', $output);

            $data2 = explode('<div id=currency_converter_result>', $data['1']);

            $data3 = explode('<span class=bld>', $data2['0']);

            if (array_key_exists('1', $data3)) {
                $data4 = explode('</span>', $data3['1']);
                $data5 = explode(' ', $data4['0']);
                $convertion_value =  number_format_i18n($data5[0], $decimalpoint);
            }

            return  $convertion_value;
        }

        /**
         * Convert Currency ajax based main method
         *
         * @param     $price
         * @param     $convertfrom
         * @param     $convertto
         * @param int $decimalpoint
         *
         * @return string
         */
        public function cbxconvertcurrency($price, $convertfrom, $convertto, $decimalpoint = 2) {

            $convertion_value = '';

            $convertion_value = apply_filters('cbxcc_convertion_method', $convertion_value, $price, $convertfrom, $convertto, $decimalpoint = 2);

            return $convertion_value;

        }

        /**
         * cbcurrencyconverter_ajax_cur_convert
         */
        public function cbcurrencyconverter_ajax_cur_convert() {

            //security check
            if (!wp_verify_nonce($_POST['cb_cur_data']['nonce'], 'cbcurrencyconverter_nonce')) {
                die('Security check');
            }

            $cbcurrencyconverter_cur_data = $_POST['cb_cur_data'];

            if ($cbcurrencyconverter_cur_data['cbcurconvert_error'] == '') {
                if ($cbcurrencyconverter_cur_data['type'] == 'up') {
                    $cbcurrencyconverter_result_cur = $this->cbxconvertcurrency($cbcurrencyconverter_cur_data['cbcurconvert_amount'], $cbcurrencyconverter_cur_data['cbcurconvert_to'], $cbcurrencyconverter_cur_data['cbcurconvert_from'], $cbcurrencyconverter_cur_data['decimal']);
                } else {
                    $cbcurrencyconverter_result_cur = $this->cbxconvertcurrency($cbcurrencyconverter_cur_data['cbcurconvert_amount'], $cbcurrencyconverter_cur_data['cbcurconvert_from'], $cbcurrencyconverter_cur_data['cbcurconvert_to'], $cbcurrencyconverter_cur_data['decimal']);
                }
            } else {
                $cbcurrencyconverter_result_cur = $cbcurrencyconverter_cur_data['cbcurconvert_error'];
            }
            echo(json_encode($cbcurrencyconverter_result_cur));
            die();
        }

        /**
         * Registering Widgets
         */
        public function register_widgets() {
            register_widget('CbCurrencyConverterWidget');
        }

    }
