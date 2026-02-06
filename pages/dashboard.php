<?php 
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Get user stats
$stmt = $conn->prepare("SELECT COUNT(*) as total_ideas FROM ideas WHERE user_id = ?");
$stmt->execute([$user_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT COUNT(DISTINCT c.user_id) as collaborators FROM collaborators c JOIN ideas i ON c.idea_id = i.id WHERE i.user_id = ?");
$stmt->execute([$user_id]);
$collab_stats = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT credibility_points FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

// Get recent ideas
$stmt = $conn->prepare("SELECT * FROM ideas WHERE user_id = ? ORDER BY updated_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_ideas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get recent activity
$stmt = $conn->prepare("SELECT * FROM activity_log WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="flex">
        <div class="w-64 bg-white h-screen shadow-sm p-6 hidden md:block">
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800">Workspace</h2>
                <p class="text-sm text-gray-600">My Personal Space</p>
            </div>
            
            <ul class="space-y-2">
                <li><a href="dashboard.php" class="sidebar-link active flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-th-large w-5"></i><span>Dashboard</span></a></li>
                <li><a href="my_ideas.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-lightbulb w-5"></i><span>My Ideas</span></a></li>
                <li><a href="board_view.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-columns w-5"></i><span>Board View</span></a></li>
                <li><a href="idea_wizard.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-plus-circle w-5"></i><span>New Idea</span></a></li>
                <li><a href="subscription.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-crown w-5"></i><span>Subscription</span></a></li>
                <li><a href="upcoming_feature.php" class="sidebar-link flex items-center space-x-3 p-3 rounded-lg text-gray-700"><i class="fas fa-users w-5"></i><span>Teams</span></a></li>
            </ul>
        </div>

        <div class="flex-1 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-600">Welcome back! Here's an overview of your ideas and progress.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Total Ideas</h2>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-blue-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-blue-600"><?php echo $stats['total_ideas']; ?></p>
                    <p class="text-sm text-gray-500 mt-2">Your business ideas</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Collaborators</h2>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-green-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-600"><?php echo $collab_stats['collaborators']; ?></p>
                    <p class="text-sm text-gray-500 mt-2">Working with you</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Points</h2>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-star text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-purple-600"><?php echo $user_data['credibility_points']; ?></p>
                    <p class="text-sm text-gray-500 mt-2">Credibility score</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Completion Rate</h2>
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tasks text-cyan-600"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-cyan-600">68%</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Recent Ideas</h2>
                    <a href="idea_wizard.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center space-x-2">
                        <i class="fas fa-plus"></i><span>New Idea</span>
                    </a>
                </div>
                
                <div class="space-y-4">
                    <?php if (empty($recent_ideas)): ?>
                        <p class="text-gray-500 text-center py-8">No ideas yet. Create your first business idea!</p>
                    <?php else: ?>
                        <?php foreach ($recent_ideas as $idea): ?>
                            <div class="flex items-start p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-lightbulb text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($idea['title']); ?></h3>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars(substr($idea['description'], 0, 100)); ?>...</p>
                                    <div class="flex items-center mt-3 text-sm text-gray-500">
                                        <span class="flex items-center mr-4">
                                            <i class="far fa-calendar mr-1"></i>
                                            <span><?php echo date('M d, Y', strtotime($idea['updated_at'])); ?></span>
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fas fa-chart-line mr-1"></i>
                                            <span><?php echo $idea['progress_percentage']; ?>% complete</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                                    <?php echo ucfirst($idea['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="my_ideas.php" class="text-blue-600 hover:text-blue-800 font-medium">
                        View All Ideas <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
