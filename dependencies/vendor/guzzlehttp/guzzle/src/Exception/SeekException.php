<?php

namespace PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Exception;

use PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\Psr\Http\Message\StreamInterface;
/**
 * Exception thrown when a seek fails on a stream.
 */
class SeekException extends \RuntimeException implements \PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Exception\GuzzleException
{
    private $stream;
    public function __construct(\PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\Psr\Http\Message\StreamInterface $stream, $pos = 0, $msg = '')
    {
        $this->stream = $stream;
        $msg = $msg ?: 'Could not seek the stream to position ' . $pos;
        parent::__construct($msg);
    }
    /**
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
