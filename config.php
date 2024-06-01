<?php
//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';
//Make object of Google API Client for call Google API
$google_client = new Google_Client();
//Set the OAuth 2.0 Client ID
$google_client->setClientId('889922707584-vra1hc9mdn321p2m1ieouc6rijqfnr9i.apps.googleusercontent.com');
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('arJ9VPCiR4Vrm5ysbmhbyGCS');
//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('https://www.tuweb7.top/nosotros');
$google_client->addScope('email');
$google_client->addScope('profile');
//start session on web page
// session_start();
?>