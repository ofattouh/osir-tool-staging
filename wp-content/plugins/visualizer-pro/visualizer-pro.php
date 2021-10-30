<?php
/**
 * Plugin Name: Visualizer: Tables and Charts Manager for WordPress AddOn
 * Plugin URI: http://themeisle.com/plugins/visualizer-charts-and-graphs/
 * Description: This addon enables the pro functions of WordPress Visualizer plugin.
 * Version: 1.10.3
 * Author: ThemeIsle
 * Author URI: https://themeisle.com
 * WordPress Available:  no
 * Requires License:    yes
 */
define( 'Visualizer_Pro_ABSURL', plugins_url( '/', __FILE__ ) );
define( 'Visualizer_Pro_PATH', realpath( dirname( __FILE__ ) ) );
define( 'VISUALIZER_PRO_VERSION', '1.10.3' );
define( 'VISUALIZER_PRO_BASEFILE', __FILE__ );
/**
 * Run the visualizer pro code.
 */
function run_visualizer_pro() {
	require dirname( __FILE__ ) . '/inc/addon.php';
	require dirname( __FILE__ ) . '/inc/wrappers.php';
	$vendor_file = Visualizer_Pro_PATH . '/vendor/autoload.php';
	if ( is_readable( $vendor_file ) ) {
		include_once( $vendor_file );
	}

	add_filter( 'themeisle_sdk_products', 'visualizer_pro_register_sdk', 10, 1 );
}

/**
 * Registers with the Themeisle SDK
 *
 * @since    1.0.0
 */
function visualizer_pro_register_sdk( $products ) {
	$products[] = VISUALIZER_PRO_BASEFILE;
	return $products;
}

run_visualizer_pro();

