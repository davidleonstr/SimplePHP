<?php
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../helpers/JWT.php';
require_once __DIR__  . '/../helpers/Request.php';
require_once __DIR__ . '/../core/Paths.php';

global $__cypher__;

if (isset($_GET['code'])) {
    $authCode = $_GET['code'];
    $token = fetchTokenWithCurl($authCode, CONFIG::$GOOGLEAUTH::$CREDENTIALSJSON, PATHS::$PUBLIC::$DYNAMICGOOGLECALLBACKURI);
    $userinfo = fetchUserInfoWithCurl($token['access_token']);
        
    $_SESSION['google-user-data'] = [
        'id' => $__cypher__.encrypt($userinfo['id']),
        'email' => $__cypher__.encrypt($userinfo['email']),
        'name' => $__cypher__.encrypt($userinfo['name']),
        'picture' => $__cypher__.encrypt($userinfo['picture'])
    ];
}

function fetchTokenWithCurl($authCode, $credentialsPath, $redirectUri) {
    $credentials = json_decode(file_get_contents($credentialsPath), true);
    
    $postData = [
        'code' => $authCode,
        'client_id' => $credentials['web']['client_id'],
        'client_secret' => $credentials['web']['client_secret'],
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    $tokenData = json_decode($response, true);

    return $tokenData;
}

function fetchUserInfoWithCurl($accessToken) {
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v2/userinfo');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    $userData = json_decode($response, true);
    
    return $userData;
}