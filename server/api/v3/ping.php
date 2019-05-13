<?php

$ch = curl_init($_GET["url"]);
$options = array(
    // new cookie session every time
    CURLOPT_COOKIESESSION => true,
    // outputs ssl info; requires CURLOPT_VERBOSE
    CURLOPT_CERTINFO => true,
    CURLOPT_VERBOSE => true,
    // disable dns global cache
    CURLOPT_DNS_USE_GLOBAL_CACHE => false,
    // do not follow redirects
    CURLOPT_FOLLOWLOCATION => false,
    // force connection to close when it has finished processing
    CURLOPT_FORBID_REUSE => true,
    // use new connection instead of a cached one
    CURLOPT_FRESH_CONNECT => true,
    // do not include header in the output
    CURLOPT_HEADER => false,
    // remove header and exclude body from output
    CURLOPT_RETURNTRANSFER => true,
    // allow cURL to verify the certificate
    CURLOPT_SSL_VERIFYPEER => true,
    // seconds to wait while trying to connect
    CURLOPT_CONNECTTIMEOUT => 30,
    // seconds to keep DNS entries in memory
    CURLOPT_DNS_CACHE_TIMEOUT => 0,
    // check the existence of a common name and also verify that it matches the hostname provided
    CURLOPT_SSL_VERIFYHOST => 2,
);
curl_setopt_array($ch, $options);
curl_exec($ch);
echo json_encode(curl_getinfo($ch));
curl_close($ch);
