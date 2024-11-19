<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Project - Figma Design Sharing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cream">
    <!-- Navbar same as index.php -->
    
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Upload New Project</h1>
        
        <form action="/api/upload-project.php" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white rounded-lg shadow-sm p-6">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" 
                       for="title">
                    Project Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                       id="title" 
                       type="text" 
                       name="title" 
                       required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" 
                       for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                          id="description" 
                          name="description" 
                          rows="4" 
                          required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" 
                       for="thumbnail">
                    Thumbnail Image
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                       id="thumbnail" 
                       type="file" 
                       name="thumbnail" 
                       accept="image/*" 
                       required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" 
                       for="figma_link">
                    Figma Project Link
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"
                       id="figma_link" 
                       type="url" 
                       name="figma_link" 
                       required>
            </div>
            
            <div class="flex items-center justify-end">
                <button class="bg-purple-600 text-white px-4 py-2 rounded-md"
                        type="submit">
                    Upload Project
                </button>
            </div>
        </form>
    </main>
</body>
</html>