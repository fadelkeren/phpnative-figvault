<?php
session_start();
require_once 'config/database.php';

// Fetch projects ordered by popularity
$stmt = $pdo->query("
    SELECT p.*, u.name as author_name, u.is_verified, 
           COUNT(l.id) as like_count
    FROM projects p
    JOIN users u ON p.user_id = u.id
    LEFT JOIN likes l ON p.id = l.project_id
    GROUP BY p.id
    ORDER BY like_count DESC
");
$projects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Figma Design Sharing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purple: '#8B5CF6',
                        cream: '#FDFCF7'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-cream">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-purple-600">FigmaShare</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    <?php if(isset($_SESSION['user'])): ?>
                        <a href="/dashboard" class="text-gray-600 hover:text-purple-600 px-3 py-2">Dashboard</a>
                        <img src="<?php echo $_SESSION['user']['profile_picture']; ?>" 
                             alt="Profile" 
                             class="w-8 h-8 rounded-full ml-4">
                    <?php else: ?>
                        <a href="/auth/google-login.php" 
                           class="bg-purple-600 text-white px-4 py-2 rounded-md">
                            Login with Google
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($projects as $project): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <img src="<?php echo $project['thumbnail']; ?>" 
                     alt="<?php echo $project['title']; ?>"
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold">
                            <?php echo $project['title']; ?>
                        </h2>
                        <div class="flex items-center">
                            <?php echo $project['author_name']; ?>
                            <?php if($project['is_verified']): ?>
                                <svg class="w-4 h-4 ml-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="<?php echo $project['figma_link']; ?>" 
                           target="_blank"
                           class="bg-purple-600 text-white px-4 py-2 rounded-md">
                            View Project
                        </a>
                        <button class="like-btn flex items-center text-gray-500 hover:text-red-500"
                                data-project-id="<?php echo $project['id']; ?>">
                            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                            </svg>
                            <span class="like-count"><?php echo $project['like_count']; ?></span>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        // Like functionality
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const projectId = btn.dataset.projectId;
                const response = await fetch('/api/like.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ project_id: projectId })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    btn.querySelector('.like-count').textContent = data.likes;
                }
            });
        });
    </script>
</body>
</html>