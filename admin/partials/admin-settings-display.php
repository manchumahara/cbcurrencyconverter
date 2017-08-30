<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://codeboxr.com
 * @since      1.0.0
 *
 * @package    Cbcurrencyconverter
 * @subpackage Cbcurrencyconverter/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <?php
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $pro_note = '';
        //plugin is not activated
        if ( !is_plugin_active( 'cbcurrencyconverteraddon/cbcurrencyconverteraddon.php' ) ) {
            $pro_note = sprintf('<a class="button" href="%s" target="_blank">'.__('Grab the Pro Version','cbcurrencyconverter').'</a>', 'http://codeboxr.com/product/cbx-currency-converter-for-wordpress/');
        }

    ?>
    <h2><?php _e( 'CBX Currency Converter', 'cbcurrencyconverter' ); echo ' '.$pro_note; ?> </h2>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <div class="inside">
                            <?php
                                $this->settings_api->show_navigation();
                                $this->settings_api->show_forms();
                            ?>
                        </div> <!-- .inside -->
                    </div> <!-- .postbox -->
                </div> <!-- .meta-box-sortables .ui-sortable -->
            </div> <!-- post-body-content -->
            <?php
                include('sidebar.php');
            ?>

        </div> <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div> <!-- #poststuff -->

</div> <!-- .wrap -->



