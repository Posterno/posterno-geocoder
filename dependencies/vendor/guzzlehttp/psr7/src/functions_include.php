<?php

namespace PNO\Geocoder\Vendor;

// Don't redefine the functions if included multiple times.
if (!\function_exists('PNO\\Geocoder\\Vendor\\GuzzleHttp\\Psr7\\str')) {
    require __DIR__ . '/functions.php';
}
