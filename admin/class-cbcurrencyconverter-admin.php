<?php

    /**
     * The admin-specific functionality of the plugin.
     *
     * @link       http://codeboxr.com
     * @since      1.0.0
     *
     * @package    Cbcurrencyconverter
     * @subpackage Cbcurrencyconverter/admin
     */

    /**
     * The admin-specific functionality of the plugin.
     *
     * Defines the plugin name, version, and two examples hooks for how to
     * enqueue the admin-specific stylesheet and JavaScript.
     *
     * @package    Cbcurrencyconverter
     * @subpackage Cbcurrencyconverter/admin
     * @author     codeboxr <info@codeboxr.com>
     */
    class Cbcurrencyconverter_Admin {

        /**
         * The ID of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $plugin_name The ID of this plugin.
         */
        private $plugin_name;

        protected $plugin_screen_hook_suffix = 'settings_page_cbcurrencyconverter';

        /**
         * The version of this plugin.
         *
         * @since    1.0.0
         * @access   private
         * @var      string $version The current version of this plugin.
         */
        private $version;

        //for setting
        private $settings_api;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         *
         * @param      string $plugin_name The name of this plugin.
         * @param      string $version     The version of this plugin.
         */
        public function __construct($plugin_name, $version) {

            $this->plugin_name = $plugin_name;
            $this->version     = $version;

            $this->settings_api = new CBCurrencyconverterSetting($this->plugin_name, $this->version);

        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles() {

            wp_register_style( $this->plugin_name .'-chosen', plugin_dir_url(__FILE__). 'css/chosen.min.css', array() );
            wp_register_style( $this->plugin_name.'-admin-styles', plugin_dir_url(__FILE__).'css/cbcurrencyconverter_admin.css' );

            wp_enqueue_style( $this->plugin_name .'-chosen');
            wp_enqueue_style( $this->plugin_name.'-admin-styles');

            //wp_enqueue_style( $this->plugin_name, plugin_dir_url(__FILE__) . 'css/cbcurrencyconverter-admin.css', array(), $this->version, 'all');

        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts() {

            wp_register_script( $this->plugin_name. '-choosen-script', plugin_dir_url(__FILE__). 'js/chosen.jquery.min.js', array( 'jquery' ) );
            wp_register_script( $this->plugin_name.'-admin-script', plugin_dir_url(__FILE__). 'js/cbcurrencyconverter_admin.js', array('jquery') );

            // Localize the script with new data
            $translation_array = array(
                'chosennoresults' => __( 'Oops, nothing found!', 'cbcurrencyconverter' )

            );
            wp_localize_script( $this->plugin_name.'-admin-script', 'wpcbcurrencyconverter', $translation_array );



            wp_enqueue_script( $this->plugin_name. '-choosen-script');
            wp_enqueue_script( $this->plugin_name.'-admin-script');

            //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cbcurrencyconverter-admin.js', array('jquery'), $this->version, false);

        }


        public function cbcurrencyconverter_admin_menu() {
            $this->plugin_screen_hook_suffix = add_submenu_page('options-general.php', __('Currency Converter', 'cbcurrencyconverter'), __('Currency Converter', 'cbcurrencyconverter'), 'manage_options', 'cbcurrencyconverter', array($this, 'display_plugin_admin_settings')
            );
        }


        /**
         * Render the settings page for this plugin.
         *
         * @since    1.0.0
         */
        public function display_plugin_admin_settings() {

            global $wpdb;

            $plugin_data = get_plugin_data(plugin_dir_path(__DIR__) . $this->plugin_name.'.php');

            include('partials/admin-settings-display.php');

        }


        /**
         * Settings Initilized
         */
        public function setting_init() {
            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());
            //initialize settings
            $this->settings_api->admin_init();
        }

        /**
         * Settings Sections
         */
        public function get_settings_sections() {

            $sections = array(
                array(
                    'id'    => 'cbcurrencyconverter_global_settings',
                    'title' => __('General Settings', 'cbcurrencyconverter')
                ),
                array(
                    'id'    => 'cbcurrencyconverter_calculator_settings',
                    'title' => __('Calculator Settings', 'cbcurrencyconverter'),

                ),
                array(
                    'id'    => 'cbcurrencyconverter_list_settings',
                    'title' => __('List Settings', 'cbcurrencyconverter'),

                ),
                array(
                    'id'    => 'cbcurrencyconverter_tools',
                    'title' => __('Tools', 'cbcurrencyconverter')
                )
            );

            return apply_filters('cbcurrencyconverter_section', $sections);

        }

        /**
         * Settings fields
         */
        public function get_settings_fields() {

            $cbcurrencyconverter_currency_list = Cbcurrencyconverter::getCurrencyList();
            $cal_from_to_list_currency = $cbcurrencyconverter_currency_list;

            $setting_api_cal     = get_option('cbcurrencyconverter_calculator_settings');


           if( isset($setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator']) && $setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'] != null ){
                $cbcurrencyconverter_currency_list = Cbcurrencyconverter::getCurrencyList();

                foreach($cal_from_to_list_currency as $key => $value){
                    if( !in_array($key,$setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator']) ){
                        unset($cal_from_to_list_currency[$key]);
                    }
                }
            }



            $cbcurrencyconverter_global_settings = array(

                array(
                    'name'    => 'cbcurrencyconverter_defaultlayout',
                    'label'   => __('Layout', 'cbcurrencyconverter'),
                    'desc'    => __('Select layout', 'cbcurrencyconverter'),
                    'type'    => 'select',
                    'default' => 'cal',
                    'options' => array(
                        'cal'               => __('Calculator', 'cbcurrencyconverter'),
                        'list'              => __('List', 'cbcurrencyconverter'),
                        'calwithlistbottom' => __('Calculator with List at bottom', 'cbcurrencyconverter'),
                        'calwithlisttop'    => __('Calculator with List at top', 'cbcurrencyconverter')
                    )
                ),
                array(
                    'name'    => 'cbcurrencyconverter_decimalpoint',
                    'label'   => __('Decimal Point', 'cbcurrencyconverter'),
                    'desc'    => __('decimal point position', 'cbcurrencyconverter'),
                    'type'    => 'number',
                    'default' => '2'

                )
            );

            $cbcurrencyconverter_calculator_settings = array(
                array(
                    'name'    => 'cbcurrencyconverter_enabledcurrencies_calculator',
                    'label'   => __('Enable Currencies', 'cbcurrencyconverter'),
                    'desc'    => __('Currency list to convert and show in Calculator Dropdown', 'cbcurrencyconverter'),
                    'type'    => 'multiselect',
                    'options' => $cbcurrencyconverter_currency_list
                ),
                array(
                    'name'    => 'cbcurrencyconverter_fromcurrency',
                    'label'   => __('From', 'cbcurrencyconverter'),
                    'desc'    => __('What Will Be Your Default  Currency To Convert From', 'cbcurrencyconverter'),
                    'type'    => 'select',
                    'default' => '',
                    'options' => $cal_from_to_list_currency
                ),
                array(
                    'name'    => 'cbcurrencyconverter_tocurrency',
                    'label'   => __('To', 'cbcurrencyconverter'),
                    'desc'    => __('What Will Be Your Default To  Currency', 'cbcurrencyconverter'),
                    'type'    => 'select',
                    'default' => '',
                    'options' => $cal_from_to_list_currency
                ),
                array(
                    'name'    => 'cbcurrencyconverter_defaultamount_for_calculator',
                    'label'   => __('Default Amount', 'cbcurrencyconverter'),
                    'desc'    => __('What Will Be Your Default Amount of Currency For Calculating', 'cbcurrencyconverter'),
                    'type'    => 'number',
                    'default' => '1'

                ),

                array(
                    'name'    => 'cbcurrencyconverter_title_cal',
                    'label'   => __('Currency Calculator', 'cbcurrencyconverter'),
                    'desc'    => __('Title to show in calculator', 'cbcurrencyconverter'),
                    'type'    => 'text',
                    'default' => 'Calculator Title',
                ),
            );

            $cbcurrencyconverter_tools = array(
                array(
                    'name'  => 'cbcurrencyconverter_delete_options',
                    'label' => __('Remove Data on Uninstall?', 'cbcurrencyconverter'),
                    'desc'  => __('Check this box if you would like <strong>CBX Currency Converter</strong> to completely remove all of its data when the plugin is deleted.', 'cbcurrencyconverter'),
                    'type'  => 'checkbox'

                )
            );

            $cbcurrencyconverter_list_settings = array(
                array(
                    'name'    => 'cbcurrencyconverter_defaultcurrency_list',
                    'label'   => __('From Currency', 'cbcurrencyconverter'),
                    'desc'    => __('What Will Be Your Default Currency For Listing', 'cbcurrencyconverter'),
                    'type'    => 'select',
                    'default' => 'USD',
                    'options' => $cbcurrencyconverter_currency_list
                ),
                array(
                    'name'    => 'cbcurrencyconverter_tocurrency_list',
                    'label'   => __('To Currency', 'cbcurrencyconverter'),
                    'desc'    => __('Currency list to convert and show in listing', 'cbcurrencyconverter'),
                    'type'    => 'multiselect',
                    'default' => array('GBP'),
                    'options' => $cbcurrencyconverter_currency_list
                ),
                array(
                    'name'    => 'cbcurrencyconverter_defaultamount_forlist',
                    'label'   => __('Default Amount', 'cbcurrencyconverter'),
                    'desc'    => __('Default amount for listing', 'cbcurrencyconverter'),
                    'type'    => 'number',
                    'default' => '1',
                ),
                array(
                    'name'    => 'cbcurrencyconverter_decimalpoint',
                    'label'   => __('Decimal Point', 'cbcurrencyconverter'),
                    'desc'    => __('decimal point position', 'cbcurrencyconverter'),
                    'type'    => 'number',
                    'default' => '2',

                ),
                array(
                    'name'    => 'cbcurrencyconverter_title_list',
                    'label'   => __('Title', 'cbcurrencyconverter'),
                    'desc'    => __('Title to  show in listing', 'cbcurrencyconverter'),
                    'type'    => 'text',
                    'default' => __('List of Currency', 'cbcurrencyconverter'),
                ),
            );

            $fields = array(
                'cbcurrencyconverter_global_settings'     => $cbcurrencyconverter_global_settings,
                'cbcurrencyconverter_calculator_settings' => $cbcurrencyconverter_calculator_settings,
                'cbcurrencyconverter_list_settings'       => $cbcurrencyconverter_list_settings,
                'cbcurrencyconverter_tools'               => $cbcurrencyconverter_tools,
            );

            return apply_filters('cbcurrencyconverter_fields', $fields);
        }


        /**
         * @param array $links Default settings links
         *
         * @return array
         */
        public function cbcurrencyconverter_action_links( $links ){

            $new_links['settings'] = '<a href="' . admin_url( 'options-general.php?page=cbcurrencyconverter' ) . '">' . __( 'Settings', 'cbcurrencyconverter' ) . '</a>';
            return array_merge($new_links, $links);

        }

    }
