<?php

    /**
     * @link              http://codeboxr.com
     * @since             1.0.0
     * @package           cbcurrencyconverter
     *
     * @wordpress-plugin
     * Plugin Name:       CBX Currency Converter
     * Plugin URI:        http://codeboxr.com/product/cbx-currency-converter-for-wordpress/
     * Description:       Currency Converter widget and rate display.
     * Version:           1.9
     * Author:            codeboxr
     * Author URI:        http://codeboxr.com
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:       cbcurrencyconverter
     * Domain Path:       /languages
     * @copyright         2015-17 codeboxr
     */

// If this file is called directly, abort.
    if (!defined('WPINC')) {
        die;
    }

defined('CBCURRENCYCONVERTER_NAME') or define('CBCURRENCYCONVERTER_NAME', 'cbcurrencyconverter');
defined('CBCURRENCYCONVERTER_VERSION') or define('CBCURRENCYCONVERTER_VERSION', '1.9');



    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-cbcurrencyconverter-activator.php
     */
    function activate_cbcurrencyconverter() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-cbcurrencyconverter-activator.php';
        Cbcurrencyconverter_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-cbcurrencyconverter-deactivator.php
     */
    function deactivate_cbcurrencyconverter() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-cbcurrencyconverter-deactivator.php';
        Cbcurrencyconverter_Deactivator::deactivate();
    }

    /**
     * The code that runs during plugin uninstallatiom.
     * This action is documented in includes/class-cbcurrencyconverter-.php
     */
    function uninstall_cbcurrencyconverter() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-cbcurrencyconverter-uninstall.php';
        Cbcurrencyconverter_Uninstall::uninstall();
    }

    register_activation_hook(__FILE__, 'activate_cbcurrencyconverter');
    register_deactivation_hook(__FILE__, 'deactivate_cbcurrencyconverter');
    register_uninstall_hook(__FILE__, 'uninstall_cbcurrencyconverter');

    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path(__FILE__) . 'includes/class-cbcurrencyconverter.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_cbcurrencyconverter() {

        $plugin = new Cbcurrencyconverter();
        $plugin->run();

    }

    run_cbcurrencyconverter();

    $arr = array(
	    'ALL' => 'Albania Lek',
	    'AFN' => 'Afghanistan Afghani',
	    'ARS' => 'Argentina Peso',
	    'AWG' => 'Aruba Guilder',
	    'AUD' => 'Australia Dollar',
	    'AZN' => 'Azerbaijan New Manat',
	    'BSD' => 'Bahamas Dollar',
	    'BBD' => 'Barbados Dollar',
	    'BDT' => 'Bangladeshi Taka',
	    'BYR' => 'Belarus Ruble',
	    'BZD' => 'Belize Dollar',
	    'BMD' => 'Bermuda Dollar',
	    'BOB' => 'Bolivia Boliviano',
	    'BAM' => 'Bosnia and Herzegovina Convertible Marka',
	    'BWP' => 'Botswana Pula',
	    'BGN' => 'Bulgaria Lev',
	    'BRL' => 'Brazil Real',
	    'BND' => 'Brunei Darussalam Dollar',
	    'KHR' => 'Cambodia Riel',
	    'CAD' => 'Canada Dollar',
	    'KYD' => 'Cayman Islands Dollar',
	    'CLP' => 'Chile Peso',
	    'CNY' => 'China Yuan Renminbi',
	    'COP' => 'Colombia Peso',
	    'CRC' => 'Costa Rica Colon',
	    'HRK' => 'Croatia Kuna',
	    'CUP' => 'Cuba Peso',
	    'CZK' => 'Czech Republic Koruna',
	    'DKK' => 'Denmark Krone',
	    'DOP' => 'Dominican Republic Peso',
	    'XCD' => 'East Caribbean Dollar',
	    'EGP' => 'Egypt Pound',
	    'SVC' => 'El Salvador Colon',
	    'EEK' => 'Estonia Kroon',
	    'EUR' => 'Euro Member Countries',
	    'FKP' => 'Falkland Islands (Malvinas) Pound',
	    'FJD' => 'Fiji Dollar',
	    'GHC' => 'Ghana Cedis',
	    'GIP' => 'Gibraltar Pound',
	    'GTQ' => 'Guatemala Quetzal',
	    'GGP' => 'Guernsey Pound',
	    'GYD' => 'Guyana Dollar',
	    'HNL' => 'Honduras Lempira',
	    'HKD' => 'Hong Kong Dollar',
	    'HUF' => 'Hungary Forint',
	    'ISK' => 'Iceland Krona',
	    'INR' => 'India Rupee',
	    'IDR' => 'Indonesia Rupiah',
	    'IRR' => 'Iran Rial',
	    'IMP' => 'Isle of Man Pound',
	    'ILS' => 'Israel Shekel',
	    'JMD' => 'Jamaica Dollar',
	    'JPY' => 'Japan Yen',
	    'JEP' => 'Jersey Pound',
	    'KZT' => 'Kazakhstan Tenge',
	    'KPW' => 'Korea (North) Won',
	    'KRW' => 'Korea (South) Won',
	    'KGS' => 'Kyrgyzstan Som',
	    'LAK' => 'Laos Kip',
	    'LVL' => 'Latvia Lat',
	    'LBP' => 'Lebanon Pound',
	    'LRD' => 'Liberia Dollar',
	    'LTL' => 'Lithuania Litas',
	    'MKD' => 'Macedonia Denar',
	    'MYR' => 'Malaysia Ringgit',
	    'MUR' => 'Mauritius Rupee',
	    'MXN' => 'Mexico Peso',
	    'MNT' => 'Mongolia Tughrik',
	    'MZN' => 'Mozambique Metical',
	    'NAD' => 'Namibia Dollar',
	    'NPR' => 'Nepal Rupee',
	    'ANG' => 'Netherlands Antilles Guilder',
	    'NZD' => 'New Zealand Dollar',
	    'NIO' => 'Nicaragua Cordoba',
	    'NGN' => 'Nigeria Naira',
	    'NOK' => 'Norway Krone',
	    'OMR' => 'Oman Rial',
	    'PKR' => 'Pakistan Rupee',
	    'PAB' => 'Panama Balboa',
	    'PYG' => 'Paraguay Guarani',
	    'PEN' => 'Peru Nuevo Sol',
	    'PGK' => 'Papua New Guinean Kina',
	    'PHP' => 'Philippines Peso',
	    'PLN' => 'Poland Zloty',
	    'QAR' => 'Qatar Riyal',
	    'RON' => 'Romania New Leu',
	    'RUB' => 'Russia Ruble',
	    'SHP' => 'Saint Helena Pound',
	    'SAR' => 'Saudi Arabia Riyal',
	    'RSD' => 'Serbia Dinar',
	    'SCR' => 'Seychelles Rupee',
	    'SGD' => 'Singapore Dollar',
	    'SBD' => 'Solomon Islands Dollar',
	    'SOS' => 'Somalia Shilling',
	    'ZAR' => 'South Africa Rand',
	    'LKR' => 'Sri Lanka Rupee',
	    'SEK' => 'Sweden Krona',
	    'CHF' => 'Switzerland Franc',
	    'SRD' => 'Suriname Dollar',
	    'SYP' => 'Syria Pound',
	    'TWD' => 'Taiwan New Dollar',
	    'THB' => 'Thailand Baht',
	    'TTD' => 'Trinidad and Tobago Dollar',
	    'TRY' => 'Turkey Lira',
	    'TRL' => 'Turkey Lira',
	    'TVD' => 'Tuvalu Dollar',
	    'UAH' => 'Ukraine Hryvna',
	    'GBP' => 'United Kingdom Pound',
	    'USD' => 'United States Dollar',
	    'UYU' => 'Uruguay Peso',
	    'UZS' => 'Uzbekistan Som',
	    'VEF' => 'Venezuela Bolivar',
	    'VND' => 'Viet Nam Dong',
	    'YER' => 'Yemen Rial',
	    'ZWD' => 'Zimbabwe Dollar'
    );

    $output = '';
    foreach($arr as $k => $v){
    	$output .= '*   '.$v.'('.$k.')<br/>';
    }

    echo $output;