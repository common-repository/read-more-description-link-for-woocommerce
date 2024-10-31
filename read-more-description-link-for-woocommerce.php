<?php
/**
 *
 * @package   Read more Description link for WooCommerce
 * @author    TGM Ingeniería Informática<info@tgminformatica.es>
 * @license   GPL-3.0+
 * @link      http://www.tgminformatica.es
 * @copyright 2016 TGM Ingeniería Informática
 *
 * Plugin Name: Read more Description link for WooCommerce
 * Plugin URI: http://www.tgminformatica.es
 * Description: Add additional product description and category description in order to show it when clicking on Read more link
 * Version: 1.0.0
 * Author: TGM Ingeniería Informática<info@tgminformatica.es>
 * Author URI: http://www.tgminformatica.es
 * Requires at least: 4.0
 * Tested up to: 4.6
 *
 * Text Domain: read-more-description-link-for-woocommerce
 * Domain Path: /languages/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    if ( is_admin() ) {
		require_once( plugin_dir_path( __FILE__ ) . 'admin/read-more-description-link-for-woocommerce-admin.php' );
		add_action( 'plugins_loaded', array( 'ReadMoreDescriptionLink_Admin', 'get_instance' ) );
	}
	else {
		require_once( plugin_dir_path( __FILE__ ) . 'public/read-more-description-link-for-woocommerce.php' );
		add_action( 'plugins_loaded', array( 'ReadMoreDescriptionLink', 'get_instance' ) );
	}
}
else{
	add_action( 'admin_notices', 'plugin_admin_notice_error' );
}

//Set error admin notice when woocommerce is disabled
function plugin_admin_notice_error() {
	$class = 'notice notice-error';
	$message = __( 'Description Read More Link plugin is enabled but not effective. It requires WooCommerce in order to work.', 'read-more-description-link-for-woocommerce' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
}

//Set languages
function read_more_description_link_for_woocommerce_i18n() {
	load_plugin_textdomain( 'read-more-description-link-for-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'read_more_description_link_for_woocommerce_i18n' );

//Show Setting link in Plugin page
function read_more_description_link_for_woocommerce_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=wc-settings&tab=products&section=display') ) .'">'.esc_html( __( 'Settings', 'read-more-description-link-for-woocommerce' )).'</a>';
   return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'read_more_description_link_for_woocommerce_action_links' );
?>