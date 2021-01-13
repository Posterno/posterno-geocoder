<?php

namespace PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise;

final class Is
{
    /**
     * Returns true if a promise is pending.
     *
     * @return bool
     */
    public static function pending(\PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface::PENDING;
    }
    /**
     * Returns true if a promise is fulfilled or rejected.
     *
     * @return bool
     */
    public static function settled(\PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() !== \PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface::PENDING;
    }
    /**
     * Returns true if a promise is fulfilled.
     *
     * @return bool
     */
    public static function fulfilled(\PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface::FULFILLED;
    }
    /**
     * Returns true if a promise is rejected.
     *
     * @return bool
     */
    public static function rejected(\PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface $promise)
    {
        return $promise->getState() === \PNO\Geocoder\Vendor\PNO\Geocoder\Vendor\GuzzleHttp\Promise\PromiseInterface::REJECTED;
    }
}
