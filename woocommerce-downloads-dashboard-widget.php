<?php
/*
Plugin Name: WooCommerce Downloads Dashboard Widget
Plugin URI: http://www.warrenholmes.co.za
Description: A WooCommerce dashboard widget to view product download statistics
Version: 0.1
Author: Warren Holmes
Author URI: http://www.warrenholmes.co.za
Copyright (c) 2012 Warren Holmes All rights reserved.
*/

//Make sure we're in the dashboard and the WooCommerce is active
if ( is_admin() && is_woocommerce_active() ) {

	add_action( 'wp_dashboard_setup', 'woocommerce_downloads_dashboard_widget' );

}

function woocommerce_downloads_dashboard_widget() {

	global $wp_meta_boxes;

	wp_add_dashboard_widget('woocommerce_downloads_dashboard_widget', 'WooCommerce Downloads', 'woocommerce_downloads_dashboard_widget_output');

}
 
function woocommerce_downloads_dashboard_widget_output() {

	$download_stats = get_download_stats();

	echo "<table>";

	foreach ($download_stats as $key => $value) {
		
		echo "<tr><td>" . $value->name . "</td><td> " . $value->total . "</td></tr>";

	}

	echo "</table>";
}

function get_download_stats(){

	global $wpdb;

	$results = $wpdb->get_results( "SELECT p.post_title AS name , SUM(d.download_count) AS total FROM ".$wpdb->prefix."woocommerce_downloadable_product_permissions AS d JOIN ".$wpdb->prefix."posts AS p ON d.product_id = p.ID GROUP BY d.product_id ORDER by total DESC" );

	return $results;

}
 
?>