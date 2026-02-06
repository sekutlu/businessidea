<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$query = $_GET['q'] ?? '';
$results = [];

if ($query) {
    // Search in user's own ideas
    $stmt = $conn->prepare("SELECT * FROM ideas WHERE user_id = ? AND (title LIKE ? OR description LIKE ? OR problem_statement LIKE ?) ORDER BY updated_at DESC LIMIT 10");
    $search_term = "%$query%";
    $stmt->execute([$_SESSION['user_id'], $search_term, $search_term, $search_term]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="max-w-4xl mx-auto py-10 px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Search Ideas</h1>
            
            <form method="GET" class="mb-8">
                <div class="flex">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($query); ?>" 
                           class="flex-1 border-2 border-gray-300 px-4 py-3 rounded-l-lg focus:border-blue-500" 
                           placeholder="Search your ideas..." required>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-r-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>

            <?php if ($query): ?>
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Your Ideas (<?php echo count($results); ?> results)</h2>
                    
                    <?php if (empty($results)): ?>
                        <p class="text-gray-500 text-center py-8">No ideas found matching "<?php echo htmlspecialchars($query); ?>"</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($results as $idea): ?>
                                <a href="idea_view.php?id=<?php echo $idea['id']; ?>" class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                    <h3 class="font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h3>
                                    <p class="text-gray-600 text-sm mb-2"><?php echo htmlspecialchars(substr($idea['description'], 0, 150)); ?>...</p>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <span class="mr-4"><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                                        <span><i class="fas fa-chart-line mr-1"></i><?php echo $idea['progress_percentage']; ?>% complete</span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="border-t pt-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Search the Web</h2>
                    <p class="text-gray-600 mb-4">Find external resources and inspiration for your business idea:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="https://www.google.com/search?q=<?php echo urlencode($query . ' business idea'); ?>" 
                           target="_blank" 
                           class="flex items-center justify-center bg-blue-50 text-blue-700 px-6 py-4 rounded-lg hover:bg-blue-100 transition">
                            <i class="fab fa-google text-2xl mr-3"></i>
                            <span class="font-semibold">Search on Google</span>
                        </a>
                        <a href="https://www.youtube.com/results?search_query=<?php echo urlencode($query . ' business idea'); ?>" 
                           target="_blank" 
                           class="flex items-center justify-center bg-red-50 text-red-700 px-6 py-4 rounded-lg hover:bg-red-100 transition">
                            <i class="fab fa-youtube text-2xl mr-3"></i>
                            <span class="font-semibold">Search on YouTube</span>
                        </a>
                        <a href="https://www.linkedin.com/search/results/all/?keywords=<?php echo urlencode($query); ?>" 
                           target="_blank" 
                           class="flex items-center justify-center bg-blue-50 text-blue-700 px-6 py-4 rounded-lg hover:bg-blue-100 transition">
                            <i class="fab fa-linkedin text-2xl mr-3"></i>
                            <span class="font-semibold">Search on LinkedIn</span>
                        </a>
                        <a href="https://scholar.google.com/scholar?q=<?php echo urlencode($query); ?>" 
                           target="_blank" 
                           class="flex items-center justify-center bg-green-50 text-green-700 px-6 py-4 rounded-lg hover:bg-green-100 transition">
                            <i class="fas fa-graduation-cap text-2xl mr-3"></i>
                            <span class="font-semibold">Search Academic Papers</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
