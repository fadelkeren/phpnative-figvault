<?php
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('481790586746-gsr1dlfe67g5h4s72dol22ejua4n1rdr.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://localhost/callback.php');
$client->addScope("email");
$client->addScope("profile");
?>