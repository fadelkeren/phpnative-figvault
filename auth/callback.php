<?php
session_start();
require_once 'google-config.php';
require_once '../config/database.php';


if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        
        // Get user profile
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        // Check if user exists
        $stmt = $pdo->prepare("
            SELECT * FROM users 
            WHERE google_id = ?
        ");
        $stmt->execute([$google_account_info->id]);
        $user = $stmt->fetch();
        
        if (!$user) {
            // Create new user
            $stmt = $pdo->prepare("
                INSERT INTO users (google_id, name, email, profile_picture)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([
                $google_account_info->id,
                $google_account_info->name,
                $google_account_info->email,
                $google_account_info->picture
            ]);
            
            $user_id = $pdo->lastInsertId();
            $user = [
                'id' => $user_id,
                'name' => $google_account_info->name,
                'email' => $google_account_info->email,
                'profile_picture' => $google_account_info->picture,
                'is_verified' => false
            ];
        }
        
        $_SESSION['user'] = $user;
        header('Location: /');
    }
}
?>