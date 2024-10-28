<?php
/*
 Plugin Name: WP E-Commerce Weight & Destination Shipping Modules
 Plugin URI: https://www.ademti-software.co.uk/
 Description: Shipping Modules For WP E-Commerce bases prices on region (Continent, or country / region) and weight bands
 Version: 5.0
 Author: Ademti Software
 Author URI: https://www.ademti-software.co.uk/
*/

/**
 * Copyright (c) 2010-2015 Lee Willis. All rights reserved.
 * Copyright (c) 2015-2024 Ademti Software. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

/**
 * wp-e-commerce-weight-region-shipping.php
 *
 * @package wp-e-commerce-weightregion-shipping
 */


/* Base class */

require_once 'wp-e-commerce-weight-region-module.php';



/* This first module is confusingly named. It's actually weight / continent shipping */

require_once 'wp-e-commerce-weight-continent-shipping.php';


/**
 *
 *
 * @param unknown $wpsc_shipping_modules
 * @return unknown
 */
function ses_weightregion_shipping_add( $wpsc_shipping_modules ) {

    global $ses_weightregion_shipping;
    $ses_weightregion_shipping = new ses_weightregion_shipping();

    $wpsc_shipping_modules[$ses_weightregion_shipping->getInternalName()] = $ses_weightregion_shipping;

    return $wpsc_shipping_modules;
}




/* Weight / Country & Region Shipping */

require_once 'wp-e-commerce-weight-countryregion-shipping.php';


/**
 *
 *
 * @param unknown $wpsc_shipping_modules
 * @return unknown
 */
function ses_weightcountryregion_shipping_add( $wpsc_shipping_modules ) {

    global $ses_weightcountryregion_shipping;
    $ses_weightcountryregion_shipping = new ses_weightcountryregion_shipping();

    $wpsc_shipping_modules[$ses_weightcountryregion_shipping->getInternalName()] = $ses_weightcountryregion_shipping;

    return $wpsc_shipping_modules;
}




add_filter( 'wpsc_shipping_modules', 'ses_weightcountryregion_shipping_add' );
add_filter( 'wpsc_shipping_modules', 'ses_weightregion_shipping_add' );
add_action( 'wp_ajax_ses-weightregion-layers', array( &$ses_weightregion_shipping, "show_layers_form" ) );
add_action( 'wp_ajax_ses-weightcountryregion-layers', array( &$ses_weightcountryregion_shipping, "show_layers_form" ) );
add_action( 'wp_ajax_ses-weightregion-quote-method', array( &$ses_weightregion_shipping, "save_quote_method" ) );
add_action( 'wp_ajax_ses-weightcountryregion-quote-method', array( &$ses_weightcountryregion_shipping, "save_quote_method" ) );

if ( is_admin() ) {
    require_once 'wp-e-commerce-weight-region-region-manager.php';
}
