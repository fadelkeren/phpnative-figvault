<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle file upload
    $target_dir = "../uploads/";
    $file_extension = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
    $target_file = $target_dir . uniqid() . '.' . $file_extension;
    
    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        // Insert project into database
        $stmt = $pdo->prepare("
            INSERT INTO projects (user_id, title, description, thumbnail, figma_link)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $_SESSION['user']['id'],
            $_POST['title'],
            $_POST['description'],
            $target_file,
            $_POST['figma_link']
        ]);
        
        header('Location: /dashboard');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>