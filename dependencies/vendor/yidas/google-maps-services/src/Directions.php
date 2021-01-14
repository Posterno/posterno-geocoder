<?php

namespace PNO\Geocoder\Vendor\yidas\googleMaps;

use PNO\Geocoder\Vendor\yidas\googleMaps\Service;
use PNO\Geocoder\Vendor\yidas\googleMaps\Client;
/**
 * Directions Service
 * 
 * @author  Nick Tsai <myintaer@gmail.com>
 * @since   1.0.0
 * @see     https://developers.google.com/maps/documentation/directions/
 */
class Directions extends \PNO\Geocoder\Vendor\yidas\googleMaps\Service
{
    const API_PATH = '/maps/api/directions/json';
    /**
     * Directions
     *
     * @param Client $client
     * @param string $origin 
     * @param string $destination 
     * @param array Query parameters
     * @return array Result
     */
    public static function directions(\PNO\Geocoder\Vendor\yidas\googleMaps\Client $client, $origin, $destination, $params = [])
    {
        $params['origin'] = (string) $origin;
        $params['destination'] = (string) $destination;
        return self::requestHandler($client, self::API_PATH, $params);
    }
}
