<?php

declare(strict_types=1);


// Initialize the session
session_start();
// Include the Facebook SDK
require_once '/Libraries/google-api-php-client/vendor/autoload.php';
// Update the following variables
$google_oauth_client_id = '70063451314-bbv5qjs7sfjfb9civ197m7agokre1j9f.apps.googleusercontent.com';
$google_oauth_client_secret = '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';
$google_oauth_redirect_uri = 'http://localhost:8080/usuariosSistema/google-oauth.php';
$google_oauth_version = 'v3';
// Create the Google Client object
$client = new Google_Client();
$client->setClientId($google_oauth_client_id);
$client->setClientSecret($google_oauth_client_secret);
$client->setRedirectUri($google_oauth_redirect_uri);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Exchange the one-time authorization code for an access token
    $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($accessToken);
    // Make sure access token is valid
    if (isset($accessToken['access_token']) && !empty($accessToken['access_token'])) {
        // Now that we have an access token, we can fetch the user's profile data
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        // Make sure the profile data exists
        if (isset($google_account_info->email)) {
            // Authenticate the user
            session_regenerate_id();
            $_SESSION['google_loggedin'] = true;
            $_SESSION['google_email'] = $google_account_info->email;
            $_SESSION['google_name'] = $google_account_info->name;
            $_SESSION['google_picture'] = $google_account_info->picture;
            // Redirect to profile page
            header('Location: profile.php');
            exit;
        } else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // Redirect to Google Authentication page
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
}
