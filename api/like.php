<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Please login to like projects']);
        exit;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    $project_id = $data['project_id'];
    
    // Check if user already liked the project
    $stmt = $pdo->prepare("
        SELECT * FROM likes 
        WHERE user_id = ? AND project_id = ?
    ");
    $stmt->execute([$_SESSION['user']['id'], $project_id]);
    $existing_like = $stmt->fetch();
    
    if ($existing_like) {
        // Unlike
        $stmt = $pdo->prepare("
            DELETE FROM likes 
            WHERE user_id = ? AND project_id = ?
        ");
        $stmt->execute([$_SESSION['user']['id'], $project_id]);
    } else {
        // Like
        $stmt = $pdo->prepare("
            INSERT INTO likes (user_id, project_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$_SESSION['user']['id'], $project_id]);
    }
    
    // Get updated like count
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as likes 
        FROM likes 
        WHERE project_id = ?
    ");
    $stmt->execute([$project_id]);
    $likes = $stmt->fetch();
    
    echo json_encode(['likes' => $likes['likes']]);
}
?>