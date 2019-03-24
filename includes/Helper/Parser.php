<?php
/**
 * Parses a response from a geocoding api and returns a nicely formatted array.
 *
 * @package     posterno-geocoder
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl_2.0.php GNU Public License
 */

namespace PNO\Geocoder\Helper;

class Parser {

	public static function parse( $provider, $data ) {

		$formatted_data = false;

		if ( $provider === 'googlemaps' ) {
			$formatted_data = self::parse_googlemaps( $data );
		}

		return $formatted_data;

	}

	private static function parse_googlemaps( $data ) {

		$formatted_data = [];

		if ( is_array( $data ) && ! empty( $data ) && isset( $data[0]['address_components'] ) ) {

			$address_data = $data[0]['address_components'];

			$formatted_data['street_number'] = false;
			$formatted_data['street']        = false;
			$formatted_data['city']          = false;
			$formatted_data['state_short']   = false;
			$formatted_data['state_long']    = false;
			$formatted_data['postcode']      = false;
			$formatted_data['country_short'] = false;
			$formatted_data['country_long']  = false;

			foreach ( $address_data as $found_data ) {
				switch ( $found_data['types'][0] ) {
					case 'street_number':
						$formatted_data['street_number'] = sanitize_text_field( $found_data['long_name'] );
						break;
					case 'route':
						$formatted_data['street'] = sanitize_text_field( $found_data['long_name'] );
						break;
					case 'sublocality_level_1':
					case 'locality':
					case 'postal_town':
						$formatted_data['city'] = sanitize_text_field( $found_data['long_name'] );
						break;
					case 'administrative_area_level_1':
					case 'administrative_area_level_2':
						$formatted_data['state_short'] = sanitize_text_field( $found_data['short_name'] );
						$formatted_data['state_long']  = sanitize_text_field( $found_data['long_name'] );
						break;
					case 'postal_code':
						$formatted_data['postcode'] = sanitize_text_field( $found_data['long_name'] );
						break;
					case 'country':
						$formatted_data['country_short'] = sanitize_text_field( $found_data['short_name'] );
						$formatted_data['country_long']  = sanitize_text_field( $found_data['long_name'] );
						break;
				}
			}
		}

		return $formatted_data;

	}

}
