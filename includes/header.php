<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Figma Design Sharing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cream">
    <nav class="bg-white shadow-sm mb-6">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="<?php echo base_url(); ?>" class="text-2xl font-bold text-purple-600">
                    Figma Share
                </a>
                <div>
                    <?php if(isset($_SESSION['user'])): ?>
                        <a href="<?php echo base_url('/dashboard'); ?>" 
                           class="text-gray-600 hover:text-purple-600 mr-4">Dashboard</a>
                        <a href="<?php echo base_url('/logout'); ?>" 
                           class="text-gray-600 hover:text-purple-600">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo base_url('/login'); ?>" 
                           class="bg-purple-600 text-white px-4 py-2 rounded-md">
                            Login with Google
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4">