<?php

namespace PNO\Geocoder\Vendor\yidas\googleMaps;

use PNO\Geocoder\Vendor\yidas\googleMaps\Service;
use PNO\Geocoder\Vendor\yidas\googleMaps\Client;
/**
 * Directions Service
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @since   1.0.0
 * @see https://developers.google.com/maps/documentation/geolocation/
 */
class Geolocation extends \PNO\Geocoder\Vendor\yidas\googleMaps\Service
{
    /**
     * Replace all
     */
    const API_PATH = 'https://www.googleapis.com/geolocation/v1/geolocate';
    /**
     * Geolocate
     *
     * @param Client $client
     * @param array Body parameters
     * @return array Result
     */
    public static function geolocate(\PNO\Geocoder\Vendor\yidas\googleMaps\Client $client, $bodyParams = [])
    {
        // Google API request body format
        $body = \json_encode($bodyParams);
        return self::requestHandler($client, self::API_PATH, [], 'POST', $body);
    }
}
