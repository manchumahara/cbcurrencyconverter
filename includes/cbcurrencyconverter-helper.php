<?php

    if (!function_exists('cbxcccalcview')):

        /**
         * Shows the calculator form
         *
         * @param string $cbcur_reference shortcode or widget
         * @param array $instance
         *
         * @return string
         *
         */
        function cbxcccalcview($cbcur_reference, $instance = array()) {

            extract($instance);
            $decimalpoint              = (isset($decimalpoint)) ? intval($decimalpoint) : 2;
            $cbcurrencyconverter_currency_list = Cbcurrencyconverter::getCurrencyList();

            //currency list for calculator
            if (isset($calc_currencies) && is_array($calc_currencies) && sizeof($calc_currencies) > 0) {

                foreach ($cbcurrencyconverter_currency_list as $key => $value) {
                    if (!in_array($key, $calc_currencies)) {
                        unset($cbcurrencyconverter_currency_list[$key]);
                    }
                }

            }

            //only for calculator

            $calc_title                = (isset($calc_title)) ? esc_attr($calc_title) : __('Currency Calculator', 'cbcurrencyconverter');
            $calc_from_currency        = (isset($calc_from_currency)) ? esc_attr($calc_from_currency) : '';
            $calc_to_currency          = (isset($calc_to_currency)) ? esc_attr($calc_to_currency) : '';
            $calc_default_amount       = (isset($calc_default_amount)) ? intval($calc_default_amount) : 1;
            $hide                      = (isset($hide)) ? esc_attr($hide) : ''; //  '', up , down


            if ($cbcur_reference == 'shortcode') {
                //do any special processing for shortcode
            }

            if ($cbcur_reference == 'widget') {
                //do any special processing for widget
            }

            $cbcurrency_output = '';
            $cbcurrency_output .= '<div  class="cbcurrencyconverter_cal_wrapper cbcurrencyconverter_cal_wrapper' . $cbcur_reference . '">';

            $cbcurrency_output .= '<h3 class = "cbcurrencyconverter_heading">' . $calc_title . '</h3>';
            $cbcurrency_output .= '<div  class = "cbcurrencyconverter_result cbcurrencyconverter_result_' . $cbcur_reference . '"></div>';
            $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">
                                            <span  class="cbcurrencyconverter_label">' . __('Amount', 'cbcurrencyconverter') . '</span>';
            $cbcurrency_output .= '<input type="number" step="any" class = "cbcurrencyconverter_cal_amount cbcurrencyconverter_cal_amount_' . $cbcur_reference . '" value ="' . $calc_default_amount . '"/>
                                       </div>';
            $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">
                                            <span  class="cbcurrencyconverter_label">' . __('From :', 'cbcurrencyconverter') . '</span>';
            $cbcurrency_output .= '<select class = "cbcurrencyconverter_cal_from cbcurrencyconverter_cal_from_' . $cbcur_reference . '">';
            $cbcurrency_output .= '<option value="' . $calc_from_currency . '">' . __('Select a currency', 'cbcurrencyconverter') . '</option>';

            foreach ($cbcurrencyconverter_currency_list as $index => $currency) {

                $cbcurrency_output .= '<option ' . selected($calc_from_currency, $index, false) . ' value="' . $index . '">' . $currency . '(' . $index . ')' . '</option>';
            }

            $cbcurrency_output .= '</select>
                                    </div>';


            $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">
                                            <span class="cbcurrencyconverter_label">' . __('To :', 'cbcurrencyconverter') . '</span>';

            $cbcurrency_output .= '<select class = "cbcurrencyconverter_cal_to cbcurrencyconverter_cal_to_' . $cbcur_reference . '">';

            $cbcurrency_output .= '<option value="' . $calc_to_currency . '">' . __('Select a currency', 'cbcurrencyconverter') . '</option>';

            foreach ($cbcurrencyconverter_currency_list as $index => $currency) {

                $cbcurrency_output .= '<option ' . selected($calc_to_currency, $index, false) . '  value="' . $index . '">' . $currency . '(' . $index . ')' . '</option>';
            }

            $cbcurrency_output .= '</select></div>';
            $hide_up   = true;
            $hide_down = true;

            if ($hide == 'up') {
                $hide_up = false;
            }

            if ($hide == 'down') {
                $hide_down = false;
            }

            $currency_nonce = wp_create_nonce("cbcurrencyconverter");

            $cbcurrency_output .= '<div class = "cbconverter_result_wrapper_' . $cbcur_reference . '">';

            $cbcurrency_output .= ($hide_up) ? '<button style = "" class="button button-primary cbcurrencyconverter_calculate cbcurrencyconverter_calculate_' . $cbcur_reference . '" data-busy = "0" data-decimalpoint="' . $decimalpoint . '" data-ref = "' . $cbcur_reference . '" data-id = "up" data-nonce="' . $currency_nonce . '">' . __('Up', 'cbcurrencyconverter') . '</button>' : '';
            $cbcurrency_output .= ($hide_down) ? '<button style = "" class="button button-primary cbcurrencyconverter_calculate cbcurrencyconverter_calculate_' . $cbcur_reference . '" data-busy = "0" data-decimalpoint="' . $decimalpoint . '" data-ref = "' . $cbcur_reference . '" data-id = "down" data-nonce="' . $currency_nonce . '">' . __('Down', 'cbcurrencyconverter') . '</button>' : '';

            $cbcurrency_output .= '</div>';

            $cbcurrency_output .= '</div>';// end of wrapper div

            return $cbcurrency_output;
        }
    endif;


    if (!function_exists('cbxcclistview')):

        /**
         * currencly list layout
         *
         * @param string $cbcur_reference  shortcode or widget
         * @param array $instance
         *
         * @return string
         */
        function cbxcclistview($cbcur_reference, $instance = array()) {

            $CbCurrencyConverter = new Cbcurrencyconverter_Public('cbcurrencyconverter', CBCURRENCYCONVERTER_VERSION);

            extract($instance);

            //$list_to_currency need to convert to array if not provided as array


            $decimalpoint           = (isset($decimalpoint)) ? intval($decimalpoint) : 2;

            $list_title             = (isset($list_title)) ? esc_attr($list_title) : __('List of Currency', 'cbcurrencyconverter');
            $list_from_currency     = (isset($list_from_currency)) ? esc_attr($list_from_currency) : 'USD';
            $list_to_currency       = (isset($list_to_currency)) ? $list_to_currency : array('GBP');

           /* if (is_string($list_to_currency)) {
                $list_to_currency = explode(',', $list_to_currency);
            }*/
            $list_default_amount  = (isset($list_default_amount)) ? intval($list_default_amount) : 1;

            $cbcur_list_view = '<div  class="cbcurrencyconverter_list_wrapper cbcurrencyconverter_list_wrapper_' . $cbcur_reference . '">';
            $cbcur_list_view .= '<h3 class = "cbcurrencyconverter_heading">' . $list_title . '</h3>';

            if (!empty($list_to_currency)) {
                $cbcur_list_view .= '<ul class="cbcurrencyconverter_list_to cbcurrencyconverter_list_to_' . $cbcur_reference . '">';
                $cbcur_list_view .= '<li style = "margin-bottom:5px;list-style-type:none;" class="cbcurrencyconverter_list_from cbcurrencyconverter_list_from_' . $cbcur_reference . '">' . $list_default_amount . ' ' . $list_from_currency . '<span class ="cbcur_list_custom_text">' . __('equals', 'cbcurrencyconverter') . '</span></li>';
                foreach ($list_to_currency as $list_of_currency) {
                    if (ctype_upper($list_of_currency)) {
                        $cb_cur_converted = $CbCurrencyConverter->cbxconvertcurrency($list_default_amount, $list_from_currency, $list_of_currency, $decimalpoint);
                        if ($cb_cur_converted != '') {
                            $cbcur_list_view .= '<li style = "list-style-type:none;"><span class ="cbcur_list_to_cur">' . $cb_cur_converted;
                            $cbcur_list_view .= '</span><span class ="cbcur_list_to_country">' . $list_of_currency . '<span></li>';
                        }// end of not null
                    }
                }// end of foreach
                $cbcur_list_view .= '</ul>';
            }
            $cbcur_list_view .= '</div>';

            return $cbcur_list_view;
        }
    endif;

    /**
     * Shows the calculator in woocommerce
     *
     * @param       $cbcur_reference
     * @param array $instance
     *
     * @return string
     */
    if (!function_exists('cbxcccalcinline')):
        function cbxcccalcinline($cbcur_reference, $instance = array()) {

            //global $CbCurrencyConverter;
            $CbCurrencyConverter = new Cbcurrencyconverter();

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
            $calc_currencies           = (isset($setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'])) ? $setting_api_cal['cbcurrencyconverter_enabledcurrencies_calculator'] : array_keys(Cbcurrencyconverter::$cbcurrencyconverter_currency_list);


            // result


            $calc_from_currency         = isset($instance['calc_from_currency'])? $instance['calc_from_currency'] : $calc_from_currency;
            $calc_to_currency           = isset($instance['calc_to_currency'])? $instance['calc_to_currency']: $calc_to_currency;
            $calc_default_amount        = isset($instance['calc_default_amount'])? $instance['calc_default_amount']: $calc_default_amount;
            $calc_title                 = isset($instance['calc_title'])? $instance['calc_title']: $calc_title;


            $cbcurrencyconverter_currency_list = $CbCurrencyConverter::getCurrencyList();

                if (!in_array($calc_to_currency,$cbcurrencyconverter_currency_list)) {
                    unset($cbcurrencyconverter_currency_list[$calc_to_currency]);
                }




            $cbcurrency_output = '';

            $cbcurrency_output .= '<div class="cbcurrencyconverter_cal_wrapper cbcurrencyconverter_cal_wrapper' . $cbcur_reference . '">';
            $cbcurrency_output .= '<h4 class = "cbcurrencyconverter_heading">' . $calc_title . '</h4>';
            $cbcurrency_output .= '<div class = "cbcurrencyconverter_result cbcurrencyconverter_result_' . $cbcur_reference . '"></div>';
            $cbcurrency_output .= '';
            $cbcurrency_output .= '<input  type = "hidden" class = "cbcurrencyconverter_cal_amount cbcurrencyconverter_cal_amount_' . $cbcur_reference . '" value ="' . $calc_default_amount . '"/> ';

            $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields" style="display: none;">';
            $cbcurrency_output .= '<select  class = "cbcurrencyconverter_cal_from cbcurrencyconverter_cal_from_' . $cbcur_reference . '">';
            $cbcurrency_output .= '<option value="' . $calc_from_currency . '">' . __('Select a currency', 'cbcurrencyconverter') . '</option>';

            /*foreach ($cbcurrencyconverter_currency_list as $index => $currency) {
                $cbcurrency_output .= '<option ' . selected($calc_from_currency, $index, false) . ' value="' . $index . '">' . $currency . '(' . $index . ')' . '</option>';
            }*/

            $cbcurrency_output .= '</select>';
            $cbcurrency_output .= '</div>';
            $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">';
            $cbcurrency_output .= '<select  class = "cbcurrencyconverter_cal_to cbcurrencyconverter_cal_to_' . $cbcur_reference . '">';

            $cbcurrency_output .= '<option value="' . $calc_to_currency . '">' . __('Select a currency', 'cbcurrencyconverter') . '</option>';

            foreach ($cbcurrencyconverter_currency_list as $index => $currency) {
                $cbcurrency_output .= '<option ' . selected($calc_to_currency, $index, false) . '  value="' . $index . '">' . $currency . '(' . $index . ')' . '</option>';
            }

            $cbcurrency_output .= '</select>';
            $cbcurrency_output .= '</div>';
            $cbcurrency_output .= '<button  class="button button-primary cbcurrencyconverter_calculate cbcurrencyconverter_calculate_' . $cbcur_reference . '" data-busy = "0" data-ref = "' . $cbcur_reference . '" data-id = "down">' . __('Convert', 'cbcurrencyconverter') . '</button> ';
            $cbcurrency_output .= '</div>';// end of wrapper div
            return $cbcurrency_output;
        }
    endif;