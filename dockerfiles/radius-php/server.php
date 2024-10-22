<?php
error_reporting(E_ERROR | E_PARSE);
require('RadiusCore.php');
require('SystemCore.php');
require('Helpers.php');

$radius = new RadiusCore();
$radius->load_dictionary('dictionary.mikrotik');
$radius->load_dictionary('dictionary.wispr');

$accessCodes = [
    401 => 3,
    500 => 3,
    200 => 2
];

$accountingCodes = [
    401 => 3,
    500 => 3,
    200 => 5,
    201 => 5
];

$radius->on("access-request", function($attributes) {

    $secret = null;

    global $accessCodes;

    

    $result = httpRequest('POST','http://app/api/radius/auth', $attributes);

    // foreach($result['response'] as $key => $val) {
    //     echo "{$key}: {$val} \r\n";
    // }

    return [$accessCodes[$result['code']],$result['response'], $result['response']['Mendyfi-Secret'] ?? null];
});

$radius->on("accounting-start", function($attributes) {

    global $accountingCodes;

    $result = httpRequest('POST','http://app/api/radius/accounting', $attributes);

    foreach($result['response'] as $key => $val) {
        echo "{$key}: {$val} \r\n";
    }

    return [$accountingCodes[$result['code']],$result['response'], $result['response']['Mendyfi-Secret'] ?? null];
});

$radius->on("accounting-interim", function($attributes) {

    echo "Interim Update\r\n";

    global $accountingCodes;

    $result = httpRequest('POST','http://app/api/radius/accounting', $attributes);

    return [$accountingCodes[$result['code']],$result['response'], $result['response']['Mendyfi-Secret'] ?? null];
});

$radius->on("accounting-stop", function($attributes) {

    global $accountingCodes;

    $result = httpRequest('POST','http://app/api/radius/accounting', $attributes);

    return [$accountingCodes[$result['code']],$result['response'], $result['response']['Mendyfi-Secret'] ?? null];
});

$radius->run();