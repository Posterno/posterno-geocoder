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

	$keys = PNO\Geocoder\Helper\Query::get_provider_credentials();

	if ( ! $keys ) {
		return;
	}

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
		$response = PNO\Geocoder\Helper\Query::geocode_coordinates( $updated_lat, $updated_lng );

		if ( ! empty( $response ) ) {
			update_post_meta( $post_id, 'geocoded_data', $response );
		}
	}

}
add_action( 'carbon_fields_post_meta_container_saved', 'pno_hook_geocoder_into_admin_panel', 10, 2 );

/**
 * Hook geocoding capabilities to the submission form.
 *
 * @param object $form the form object.
 * @param string $listing_id the listing id.
 * @return void
 */
function pno_hook_geocoder_to_submission( $form, $listing_id ) {

	if ( ! pno_geocoder_is_enabled() ) {
		return;
	}

	if ( ! empty( $form->getFieldValue( 'listing_location' ) ) ) {
		$location_details = json_decode( stripslashes( $form->getFieldValue( 'listing_location' ) ) );
		if ( isset( $location_details->coordinates->lat ) ) {
			$response = PNO\Geocoder\Helper\Query::geocode_coordinates( $location_details->coordinates->lat, $location_details->coordinates->lng );
			if ( ! empty( $response ) ) {
				update_post_meta( $listing_id, 'geocoded_data', $response );
			}
		}
	}

}
add_action( 'pno_after_listing_submission', 'pno_hook_geocoder_to_submission', 10, 2 );

/**
 * Hook geocoding capabilities to the editing form.
 *
 * @param object $form form instance.
 * @param string $listing_id the listing id.
 * @param string $user_id the user editing the listing.
 * @return void
 */
function pno_hook_geocoder_to_editing( $form, $listing_id, $user_id ) {

	if ( ! pno_geocoder_is_enabled() ) {
		return;
	}

	if ( ! empty( $form->getFieldValue( 'listing_location' ) ) ) {
		$location_details = json_decode( stripslashes( $form->getFieldValue( 'listing_location' ) ) );

		$submitted_lat = sanitize_text_field( $location_details->coordinates->lat );
		$submitted_lng = sanitize_text_field( $location_details->coordinates->lng );

		$stored_coordinates = pno_get_listing_coordinates( $listing_id );

		$stored_lat = isset( $stored_coordinates['lat'] ) ? $stored_coordinates['lat'] : false;
		$stored_lng = isset( $stored_coordinates['lng'] ) ? $stored_coordinates['lng'] : false;

		if ( $submitted_lat !== $stored_lat && $submitted_lng !== $stored_lng ) {
			$response = PNO\Geocoder\Helper\Query::geocode_coordinates( $submitted_lat, $submitted_lng );
			if ( ! empty( $response ) ) {
				update_post_meta( $listing_id, 'geocoded_data', $response );
			}
		}
	}

}
add_action( 'pno_after_listing_editing', 'pno_hook_geocoder_to_editing', 10, 2 );
