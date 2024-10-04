<?php
function httpRequest($method, $url, $params) {
    $options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false,
    ];

    if (strtoupper($method) === 'GET') {
        $url .= '?' . http_build_query($params);
    } elseif (strtoupper($method) === 'POST') {
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = http_build_query($params);
    } else {
        throw new InvalidArgumentException("Only 'GET' and 'POST' methods are supported.");
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new RuntimeException(curl_error($ch));
    }

    curl_close($ch);

    // Decode JSON response
    $json_response = json_decode($response, true);

    return [
        'response' => $json_response,
        'code' => $http_code,
    ];
}