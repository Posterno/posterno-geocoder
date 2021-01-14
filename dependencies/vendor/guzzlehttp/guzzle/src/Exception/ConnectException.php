<?php

namespace PNO\Geocoder\Vendor\GuzzleHttp\Exception;

use PNO\Geocoder\Vendor\Psr\Http\Message\RequestInterface;
/**
 * Exception thrown when a connection cannot be established.
 *
 * Note that no response is present for a ConnectException
 */
class ConnectException extends \PNO\Geocoder\Vendor\GuzzleHttp\Exception\RequestException
{
    public function __construct($message, \PNO\Geocoder\Vendor\Psr\Http\Message\RequestInterface $request, \Exception $previous = null, array $handlerContext = [])
    {
        parent::__construct($message, $request, null, $previous, $handlerContext);
    }
    /**
     * @return null
     */
    public function getResponse()
    {
        return null;
    }
    /**
     * @return bool
     */
    public function hasResponse()
    {
        return \false;
    }
}
