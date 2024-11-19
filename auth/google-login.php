<?php
require_once 'google-config.php';

$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
?>