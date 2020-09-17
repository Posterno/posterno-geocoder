<?php

namespace PNO\Geocoder\Vendor\GuzzleHttp\Handler;

use PNO\Geocoder\Vendor\GuzzleHttp\Psr7;
use PNO\Geocoder\Vendor\Psr\Http\Message\RequestInterface;
/**
 * HTTP handler that uses cURL easy handles as a transport layer.
 *
 * When using the CurlHandler, custom curl options can be specified as an
 * associative array of curl option constants mapping to values in the
 * **curl** key of the "client" key of the request.
 */
class CurlHandler
{
    /** @var CurlFactoryInterface */
    private $factory;
    /**
     * Accepts an associative array of options:
     *
     * - factory: Optional curl factory used to create cURL handles.
     *
     * @param array $options Array of options to use with the handler
     */
    public function __construct(array $options = [])
    {
        $this->factory = isset($options['handle_factory']) ? $options['handle_factory'] : new \PNO\Geocoder\Vendor\GuzzleHttp\Handler\CurlFactory(3);
    }
    public function __invoke(\PNO\Geocoder\Vendor\Psr\Http\Message\RequestInterface $request, array $options)
    {
        if (isset($options['delay'])) {
            \usleep($options['delay'] * 1000);
        }
        $easy = $this->factory->create($request, $options);
        \curl_exec($easy->handle);
        $easy->errno = \curl_errno($easy->handle);
        return \PNO\Geocoder\Vendor\GuzzleHttp\Handler\CurlFactory::finish($this, $easy, $this->factory);
    }
}
