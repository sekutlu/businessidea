<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM ideas WHERE user_id = ? ORDER BY updated_at DESC");
$stmt->execute([$user_id]);
$ideas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Ideas - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">My Business Ideas</h1>
                <p class="text-gray-600">Manage and track all your business ideas</p>
            </div>
            <div class="space-x-4">
                <a href="board_view.php" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 inline-flex items-center">
                    <i class="fas fa-columns mr-2"></i>Board View
                </a>
                <a href="idea_wizard.php?mode=forward" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>Forward Mode
                </a>
                <a href="idea_wizard.php?mode=reverse" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 inline-flex items-center">
                    <i class="fas fa-undo mr-2"></i>Reverse Mode
                </a>
            </div>
        </div>

        <?php if (empty($ideas)): ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-lightbulb text-gray-300 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">No Ideas Yet</h2>
                <p class="text-gray-600 mb-6">Start creating your first business idea using our guided wizard</p>
                <a href="idea_wizard.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-block">Create Your First Idea</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($ideas as $idea): ?>
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
                            </div>
                            <span class="bg-<?php echo $idea['status'] === 'completed' ? 'green' : 'blue'; ?>-100 text-<?php echo $idea['status'] === 'completed' ? 'green' : 'blue'; ?>-800 text-xs font-medium px-2 py-1 rounded-full">
                                <?php echo ucfirst($idea['status']); ?>
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars(substr($idea['description'], 0, 100)); ?>...</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progress</span>
                                <span><?php echo $idea['progress_percentage']; ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo $idea['progress_percentage']; ?>%"></div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                            <span><i class="fas fa-star mr-1"></i><?php echo $idea['verification_score']; ?> score</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="idea_view.php?id=<?php echo $idea['id']; ?>" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                View
                            </a>
                            <a href="idea_wizard.php?id=<?php echo $idea['id']; ?>&step=2" class="flex-1 bg-gray-200 text-gray-700 text-center px-4 py-2 rounded-lg hover:bg-gray-300 text-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
