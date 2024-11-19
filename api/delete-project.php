<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $project_id = $data['project_id'];
    
    // Verify project belongs to user
    $stmt = $pdo->prepare("
        SELECT * FROM projects 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$project_id, $_SESSION['user']['id']]);
    $project = $stmt->fetch();
    
    if ($project) {
        // Delete thumbnail file
        if (file_exists($project['thumbnail'])) {
            unlink($project['thumbnail']);
        }
        
        // Delete project from database
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$project_id]);
        
        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
    }
}
?>