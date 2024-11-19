<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    
    // Verify project belongs to user
    $stmt = $pdo->prepare("
        SELECT * FROM projects 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$project_id, $_SESSION['user']['id']]);
    $project = $stmt->fetch();
    
    if ($project) {
        $thumbnail = $project['thumbnail'];
        
        // Handle new thumbnail upload
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['size'] > 0) {
            // Delete old thumbnail
            if (file_exists($project['thumbnail'])) {
                unlink($project['thumbnail']);
            }
            
            // Upload new thumbnail
            $target_dir = "../uploads/";
            $file_extension = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
            $thumbnail = $target_dir . uniqid() . '.' . $file_extension;
            move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail);
        }
        
        // Update project
        $stmt = $pdo->prepare("
            UPDATE projects 
            SET title = ?, description = ?, thumbnail = ?, figma_link = ?
            WHERE id = ?
        ");
        
        $stmt->execute([
            $_POST['title'],
            $_POST['description'],
            $thumbnail,
            $_POST['figma_link'],
            $project_id
        ]);
        
        header('Location: /dashboard');
    } else {
        echo "Unauthorized";
    }
}
?>