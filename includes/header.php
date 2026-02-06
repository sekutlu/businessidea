<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="bg-white shadow-sm py-4 sticky top-0 z-10">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-lightbulb text-white text-xl"></i>
            </div>
            <span class="text-xl font-bold text-gray-800">IdeateHub</span>
        </div>
        
        <div class="hidden md:flex space-x-8">
            <a href="/index.php" class="text-gray-600 hover:text-blue-600 font-medium">Home</a>
            <a href="/pages/dashboard.php" class="text-gray-600 hover:text-blue-600 font-medium">Dashboard</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/pages/search.php" class="text-gray-600 hover:text-blue-600 font-medium"><i class="fas fa-search mr-1"></i>Search</a>
            <?php endif; ?>
            <a href="/pages/upcoming_feature.php" class="text-gray-600 hover:text-blue-600 font-medium">Features</a>
        </div>
        
        <div class="flex items-center space-x-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/pages/dashboard.php" class="text-gray-600 hover:text-blue-600 font-medium hidden md:block">Dashboard</a>
                <div class="relative">
                    <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <span class="hidden md:inline"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                    </button>
                </div>
                <a href="/pages/logout.php" class="text-gray-600 hover:text-red-600 font-medium">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            <?php else: ?>
                <a href="/pages/login.php" class="text-gray-600 hover:text-blue-600 font-medium hidden md:block">Log in</a>
                <a href="/pages/register.php" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 font-medium transition duration-300">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
