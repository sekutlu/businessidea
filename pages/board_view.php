<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];

// Get ideas grouped by status
$statuses = ['concept', 'validation', 'planning', 'execution', 'completed'];
$ideas_by_status = [];

foreach ($statuses as $status) {
    $stmt = $conn->prepare("SELECT * FROM ideas WHERE user_id = ? AND status = ? ORDER BY updated_at DESC");
    $stmt->execute([$user_id, $status]);
    $ideas_by_status[$status] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Board View - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .board-column { min-height: 500px; }
        .idea-card { cursor: pointer; transition: all 0.2s; }
        .idea-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .board-scroll { overflow-x: auto; white-space: nowrap; }
    </style>
</head>
<body class="bg-gray-100">
    <?php include '../includes/header.php'; ?>

    <div class="py-6 px-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Ideas Board</h1>
                <p class="text-gray-600">Trello-style view of your business ideas</p>
            </div>
            <div class="space-x-3">
                <a href="my_ideas.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-th mr-2"></i>Grid View
                </a>
                <a href="idea_wizard.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>New Idea
                </a>
            </div>
        </div>

        <div class="board-scroll pb-6">
            <div class="flex space-x-4" style="min-width: max-content;">
                
                <!-- Concept Column -->
                <div class="board-column bg-gray-50 rounded-lg p-4" style="width: 300px;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-700 flex items-center">
                            <span class="w-3 h-3 bg-gray-400 rounded-full mr-2"></span>
                            Concept
                        </h3>
                        <span class="bg-gray-200 text-gray-700 text-xs font-bold px-2 py-1 rounded-full">
                            <?php echo count($ideas_by_status['concept']); ?>
                        </span>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($ideas_by_status['concept'] as $idea): ?>
                            <div class="idea-card bg-white rounded-lg p-4 shadow-sm" onclick="window.location='idea_view.php?id=<?php echo $idea['id']; ?>'">
                                <h4 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h4>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars(substr($idea['description'], 0, 80)); ?>...</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                                    <span><?php echo $idea['progress_percentage']; ?>%</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Validation Column -->
                <div class="board-column bg-blue-50 rounded-lg p-4" style="width: 300px;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-blue-700 flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                            Validation
                        </h3>
                        <span class="bg-blue-200 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">
                            <?php echo count($ideas_by_status['validation']); ?>
                        </span>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($ideas_by_status['validation'] as $idea): ?>
                            <div class="idea-card bg-white rounded-lg p-4 shadow-sm" onclick="window.location='idea_view.php?id=<?php echo $idea['id']; ?>'">
                                <h4 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h4>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars(substr($idea['description'], 0, 80)); ?>...</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                                    <span><?php echo $idea['progress_percentage']; ?>%</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Planning Column -->
                <div class="board-column bg-yellow-50 rounded-lg p-4" style="width: 300px;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-yellow-700 flex items-center">
                            <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                            Planning
                        </h3>
                        <span class="bg-yellow-200 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">
                            <?php echo count($ideas_by_status['planning']); ?>
                        </span>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($ideas_by_status['planning'] as $idea): ?>
                            <div class="idea-card bg-white rounded-lg p-4 shadow-sm" onclick="window.location='idea_view.php?id=<?php echo $idea['id']; ?>'">
                                <h4 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h4>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars(substr($idea['description'], 0, 80)); ?>...</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                                    <span><?php echo $idea['progress_percentage']; ?>%</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Execution Column -->
                <div class="board-column bg-purple-50 rounded-lg p-4" style="width: 300px;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-purple-700 flex items-center">
                            <span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
                            Execution
                        </h3>
                        <span class="bg-purple-200 text-purple-700 text-xs font-bold px-2 py-1 rounded-full">
                            <?php echo count($ideas_by_status['execution']); ?>
                        </span>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($ideas_by_status['execution'] as $idea): ?>
                            <div class="idea-card bg-white rounded-lg p-4 shadow-sm" onclick="window.location='idea_view.php?id=<?php echo $idea['id']; ?>'">
                                <h4 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h4>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars(substr($idea['description'], 0, 80)); ?>...</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                                    <span><?php echo $idea['progress_percentage']; ?>%</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Completed Column -->
                <div class="board-column bg-green-50 rounded-lg p-4" style="width: 300px;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-green-700 flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                            Completed
                        </h3>
                        <span class="bg-green-200 text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                            <?php echo count($ideas_by_status['completed']); ?>
                        </span>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($ideas_by_status['completed'] as $idea): ?>
                            <div class="idea-card bg-white rounded-lg p-4 shadow-sm" onclick="window.location='idea_view.php?id=<?php echo $idea['id']; ?>'">
                                <h4 class="font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h4>
                                <p class="text-sm text-gray-600 mb-3"><?php echo htmlspecialchars(substr($idea['description'], 0, 80)); ?>...</p>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span><i class="fas fa-industry mr-1"></i><?php echo ucfirst($idea['industry']); ?></span>
                                    <span class="text-green-600 font-bold"><i class="fas fa-check mr-1"></i>Done</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
