<?php
/*
Plugin Name: Authorize Donation
Plugin URI: https://wordpress.org/plugins/authorize-donation
Description: Form submit to googlesheet  is a powerful plugin that allow to include directly get form submitted data to your googlesheet .
Version: 1.0.0
Author: Rohit kumar
Author URI: https://er-rohit-kumar.business.site
*/
add_action( 'plugins_loaded', 'auth_cDonation_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function auth_cDonation_load_textdomain() {
  load_plugin_textdomain( 'ACCD'); 
}
/**
 * Load all plugin functions.
 *
 * 
 */
add_action('init','plugin_auth_cDonation_loaded');
function plugin_auth_cDonation_loaded(){
	session_start();
	ob_start();
	//=============================================
	// Include Needed Files
	//=============================================
	require_once( dirname( __FILE__ ) . '/function.php' );
    require_once( dirname( __FILE__ ) . '/assets/classes/main-class.php' );
}
/**
 * Plugin activation hook.
 *
 * 
 */
register_activation_hook(__FILE__,'auth_cDonation_connect_activation');
function auth_cDonation_connect_activation(){

	/* Do my stuff here */
}
/**
 * Plugin deactivation hook.
 *
 * 
 */
register_deactivation_hook(__FILE__,'auth_cDonation_connect_deactivation');
function auth_cDonation_connect_deactivation(){

	require_once( dirname( __FILE__ ) . '/uninstall.php' );

	/* Do my stuff here */

}
