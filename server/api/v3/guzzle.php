<?php

require __DIR__ . "/../../vendor/autoload.php";
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

$client = new GuzzleHttp\Client();
$client->request("GET", $_GET["url"], [
    "allow_redirects" => false,
    "curl" => array(
        CURLOPT_DNS_CACHE_TIMEOUT => 0,
        CURLOPT_CERTINFO => 1,
        CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36 (Report abuse at: https://hawk.knsh.red/abuse)",
    ),
    "decode_content" => false,
    "on_stats" => function (TransferStats $stats) {
        $data = $stats->getHandlerStats();
        echo json_encode(array($data));
    },
    "verify" => true,
]);

// dns = namelookup_time
// tcp = pretransfer_time - namelookup_time
// tls
// firstByte
// wait
// starttransfer_time - connect_time = firstByte
