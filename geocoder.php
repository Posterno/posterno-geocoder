<?php
/**
 * Hooks the Geocoder to Posterno.
 *
 * @package     posterno-geocoder
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       0.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Determine if the geocoder is enabled.
 *
 * @return boolean
 */
function pno_geocoder_is_enabled() {

	/**
	 * Filter: determine if the geocoder is enabled or disabled.
	 *
	 * @param boolean $enabled enabled or disabled ( true or false ).
	 * @return boolean
	 */
	return apply_filters( 'pno_geocoder_is_enabled', true );
}

/**
 * Hook into the carbon fields metabox saving process and trigger geocoding when needed.
 *
 * @param string $post_id the id of the listing being saved.
 * @param object $container definition of the container being processed.
 * @return void
 */
function pno_hook_geocoder_into_admin_panel( $post_id, $container ) {

	if ( 'listings' !== get_post_type( $post_id ) || ! pno_geocoder_is_enabled() || ! is_admin() || ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	$coordinates = pno_get_listing_coordinates( $post_id );
	$current_lat = isset( $coordinates['lat'] ) ? esc_attr( $coordinates['lat'] ) : false;
	$current_lng = isset( $coordinates['lng'] ) ? esc_attr( $coordinates['lng'] ) : false;
	$updated_lat = isset( $_POST['_listing_location']['lat'] ) ? sanitize_text_field( $_POST['_listing_location']['lat'] ) : false;
	$updated_lng = isset( $_POST['_listing_location']['lng'] ) ? sanitize_text_field( $_POST['_listing_location']['lng'] ) : false;

	// Trigger geocoding only when coordinates change.
	if ( $current_lat !== $updated_lat && $current_lng !== $updated_lng ) {
		print_r( PNO\Geocoder\Helper\Query::geocode_coordinates( $updated_lat, $updated_lng ) );
	}
	exit;

}
add_action( 'carbon_fields_post_meta_container_saved', 'pno_hook_geocoder_into_admin_panel', 10, 2 );
