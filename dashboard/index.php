<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}

require_once '../config/database.php';

// Fetch user's projects
$stmt = $pdo->prepare("
    SELECT * FROM projects 
    WHERE user_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$_SESSION['user']['id']]);
$projects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Figma Design Sharing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cream">
    <!-- Navbar same as index.php -->
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Projects</h1>
            <a href="/dashboard/upload.php" 
               class="bg-purple-600 text-white px-4 py-2 rounded-md">
                Upload New Project
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($projects as $project): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="<?php echo $project['thumbnail']; ?>" 
                     alt="<?php echo $project['title']; ?>"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-lg font-semibold"><?php echo $project['title']; ?></h2>
                    <div class="mt-4 flex justify-between">
                        <a href="/dashboard/edit.php?id=<?php echo $project['id']; ?>" 
                           class="text-purple-600 hover:text-purple-700">Edit</a>
                        <button onclick="deleteProject(<?php echo $project['id']; ?>)"
                                class="text-red-600 hover:text-red-700">Delete</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        async function deleteProject(projectId) {
            if (confirm('Are you sure you want to delete this project?')) {
                const response = await fetch('/api/delete-project.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ project_id: projectId })
                });
                
                if (response.ok) {
                    window.location.reload();
                }
            }
        }
    </script>
</body>
</html>