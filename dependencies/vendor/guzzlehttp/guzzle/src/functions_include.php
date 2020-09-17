<?php

namespace PNO\Geocoder\Vendor;

// Don't redefine the functions if included multiple times.
if (!\function_exists('PNO\\Geocoder\\Vendor\\GuzzleHttp\\uri_template')) {
    require __DIR__ . '/functions.php';
}
