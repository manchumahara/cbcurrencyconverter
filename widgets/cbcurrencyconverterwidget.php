<?php

    /**
     * Class CbCurrencyConverterwidget
     */
    class CbCurrencyConverterWidget extends WP_Widget {

        /**
         *
         *
         * Unique identifier for  widget.
         *
         *
         * The variable name is used as the text domain when internationalizing strings
         * of text. Its value should match the Text Domain file header in the main
         * widget file.
         *
         * @since    1.0.0
         *
         * @var      string
         */
        protected $widget_slug = 'cbcurrencyconverterwidget';

        /*--------------------------------------------------*/
        /* Constructor
        /*--------------------------------------------------*/

        /**
         * Specifies the classname and description, instantiates the widget,
         * loads localization files, and includes necessary stylesheets and JavaScript.
         */
        public function __construct() {
            parent::__construct(
                $this->widget_slug,
                __('Currency Converter', 'cbcurrencyconverter'),
                array(
                    'classname'   => $this->widget_slug . '-class',
                    'description' => __('Currency Converter', 'cbcurrencyconverter')
                )
            );


        } // end constructor


        /**
         * Outputs the content of the widget.
         *
         * @param array args  The array of form elements
         * @param array instance The current instance of the widget
         */
        public function widget($args, $instance) {



            extract($args, EXTR_SKIP);

            //pre process

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
            $calc_title                 = (isset($setting_api_cal['cbcurrencyconverter_title_cal'])) ? $setting_api_cal['cbcurrencyconverter_title_cal'] : __('Currency Calculator', 'cbcurrencyconverter');
            $cbcur_from_currency        = (isset($setting_api_cal['cbcurrencyconverter_fromcurrency'])) ? $setting_api_cal['cbcurrencyconverter_fromcurrency'] : '';
            $cbcur_to_currency          = (isset($setting_api_cal['cbcurrencyconverter_tocurrency'])) ? $setting_api_cal['cbcurrencyconverter_tocurrency'] : '';
            $calc_default_amount        = (isset($setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'])) ? $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] : 1;
            $calc_currencies            = (isset($setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'])) ? $setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'] : array_keys(Cbcurrencyconverter::getCurrencyList());



            //core
            $instance['layout'] = isset($instance['layout']) ? $instance['layout']: $layout;
            $instance['hide'] = isset($instance['hide']) ? $instance['layout']: '';
            $instance['decimalpoint'] = isset($instance['decimalpoint']) ? $instance['decimalpoint']: $decimalpoint;


            $instance = apply_filters('cbcurrencyconverter_widget_output', $instance);


            $instance['list_title '] = !isset($instance['list_title ']) ? $list_title: $instance['list_title '] ;
            $instance['list_from_currency'] = !isset($instance['list_from_currency']) ? $list_from_currency : $instance['list_from_currency'];
            $instance['list_to_currency'] = !isset($instance['list_to_currency']) ?  $list_to_currency : $instance['list_to_currency'];
            $instance['list_default_amount'] = !isset($instance['list_default_amount']) ? $list_default_amount : $instance['list_default_amount'];


            $instance['calc_title '] = !isset($instance['calc_title ']) ? $calc_title : $instance['calc_title '];
            $instance['cbcur_from_currency'] = !isset($instance['cbcur_from_currency']) ? $cbcur_from_currency : $instance['cbcur_from_currency'];
            $instance['cbcur_to_currency'] = !isset($instance['cbcur_to_currency']) ? $cbcur_to_currency : $instance['cbcur_to_currency'] ;
            $instance['calc_default_amount'] = !isset($instance['calc_default_amount']) ? $calc_default_amount : $instance['calc_default_amount'];
            $instance['calc_currencies'] = !isset($instance['calc_currencies']) ? $calc_currencies: $instance['calc_currencies'];




            extract($instance);

            echo $before_widget;

            $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
            if (!empty($title)) {
                echo $before_title . $title . $after_title;
            };



            if ($layout == 'list') {
                echo cbxcclistview('widget', $instance);
            } elseif ($layout == 'cal') {
                echo cbxcccalcview('widget', $instance);
            } elseif ($layout == 'calwithlistbottom') {
                echo cbxcccalcview('widget', $instance) . cbxcclistview('widget', $instance);
            } elseif ($layout == 'calwithlisttop') {
                echo cbxcclistview('widget', $instance) . cbxcccalcview('widget', $instance);
            }

            echo $after_widget;

        } // end widget


        /**
         * Processes the widget's options to be saved.
         *
         * @param array new_instance The new instance of values to be generated via the update.
         * @param array old_instance The previous instance of values before the update.
         */
        public function update($new_instance, $old_instance) {


            if (!isset($new_instance['submit']))
                return false;
            $instance = $old_instance;

            $instance['title']              = sanitize_text_field($new_instance['title']);
            $instance['hide']               = $new_instance['hide'];
            $instance['decimalpoint']       = intval($new_instance['decimalpoint']);
            $instance['layout']             = sanitize_text_field($new_instance['layout']);

            $instance = apply_filters('cbcurrencyconverter_widget_update', $instance, $new_instance);
            return $instance;

        } // end widget

        /**
         * Generates the administration form for the widget.
         *
         * @param array instance The array of keys and values for the widget.
         */
        public function form($instance) {

            global $wpdb;


            $instance = wp_parse_args((array)$instance, array(
                'title'        => __('Currency Calculator', 'cbcurrencyconverter'),
                'hide'         => '',
                'decimalpoint' => 2,
                'layout'       => 'cal'
            ));

            $title        = esc_attr($instance['title']);
            $decimalpoint = intval($instance['decimalpoint']);

            ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">
                    <?php _e('Title:', 'cbcurrencyconverter'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                           name="<?php echo $this->get_field_name('title'); ?>" type="text"
                           value="<?php echo $title; ?>"/>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Select Layout:', 'cbcurrencyconverter'); ?>
                    <select name="<?php echo $this->get_field_name('layout'); ?>"
                            id="<?php echo $this->get_field_id('layout'); ?>" class="chosen-select widefat">
                        <option
                            value="cal" <?php selected($instance['layout'], 'cal'); ?>><?php _e('Calculator', 'cbcurrencyconverter'); ?></option>
                        <option
                            value="list" <?php selected($instance['layout'], 'list'); ?>><?php _e('List', 'cbcurrencyconverter'); ?></option>
                        <option
                            value="calwithlistbottom" <?php selected($instance['layout'], 'calwithlistbottom'); ?>><?php _e('Calc with List Bottom', 'cbcurrencyconverter'); ?></option>
                        <option
                            value="calwithlisttop" <?php selected($instance['layout'], 'calwithlisttop'); ?>><?php _e('Calc with List Top', 'cbcurrencyconverter'); ?></option>
                    </select>
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('hide'); ?>">
                    <?php _e('Hide:', 'cbcurrencyconverter'); ?>
                    <select name="<?php echo $this->get_field_name('hide'); ?>"
                            id="<?php echo $this->get_field_id('hide'); ?>" class="chosen-select widefat">
                        <option
                            value=""<?php selected($instance['hide'], ''); ?>><?php _e('Show Both Up & Down Button', 'cbcurrencyconverter'); ?></option>
                        <option
                            value="up"<?php selected($instance['hide'], 'up'); ?>><?php _e('Up  Button', 'cbcurrencyconverter'); ?></option>
                        <option
                            value="down"<?php selected($instance['hide'], 'down'); ?>><?php _e('Down Button', 'cbcurrencyconverter'); ?></option>
                    </select>
                </label>
            </p>

            <p>
                <label for="<?php echo $this->get_field_id('decimalpoint '); ?>">
                    <?php _e('Decimal Point:', 'cbcurrencyconverter'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('decimalpoint'); ?>"
                           name="<?php echo $this->get_field_name('decimalpoint'); ?>" type="number"
                           value="<?php echo $decimalpoint; ?>"/>
                </label>
            </p>
            <?php
            do_action('cbcurrencyconverter_widget_form', $instance, $this);
            ?>
            <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>"
                   name="<?php echo $this->get_field_name('submit'); ?>" value="1"/>
            <?php


        } // end form


    } // end class