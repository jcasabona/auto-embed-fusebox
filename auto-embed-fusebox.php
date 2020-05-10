<?php
/**
 * Plugin Name: Auto Embed Fusebox
 * Plugin URI: http://howibuilt.it/
 * Description: This plugin automatically embeds the Fusebox player on content pages. 
 * Author: Joe Casabona
 * Version: 0.5
 * Author URI: http://casabona.org/

 * @package auto-embed-fusebox
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* Tell user if Fusebox is not installed, then kill it. */
function aef_check_for_fusebox() {
	if ( ! class_exists( 'SPP_Core' ) ) {
		add_action( 'admin_notices', function() {
			?>
					<div class="notice notice-warning is-dismissible">
						<p>
							<?php esc_html_e( 'It looks like Fusebox is not installed. That\'s required for this plugin to work.', 'auto-embed-fusebox' ); ?>
						</p>
					</div>
			<?php
		} );
	}
}

add_action( 'plugins_loaded', 'aef_check_for_fusebox' );

define( 'AEF_VERSION', '1.0' );
define( 'AEF_URL', plugin_dir_url( __FILE__ ) );
define( 'AEF_ASSETS', AEF_URL . '/assets/' );

function aef_asset_loader() {
    //Check to see if PowerPress is installed
    if ( function_exists( 'powerpress_get_enclosure_data' ) ) {
        include_once( AEF_ASSETS . 'powerpress_functions.php' );
    } else if ( /**CHECK FOR CASTOS */ ) {
        include_once( AEF_ASSETS . 'castos_functions.php' );
    }
}

// If this were really clever, it would be a class. 
// If actually should be...
add_action( 'plugins_loaded', 'aef_asset_loader' );

function aef_fusebox_insert( $content ) {
    // No player in the Feed!
    if (is_feed() ) {
        return $content;
    }

    $url = aef_get_media_URL();

    if ( $url ) {
        $format = '[fusebox_track_player url="%s" title="%s"]';
        return  do_shortcode( sprintf( $format, $url, get_the_title() ) ). $content;
    }

    return $content;
}

add_filter( 'the_content', 'aef_fusebox_insert', 100 );
