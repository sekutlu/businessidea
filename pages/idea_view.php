<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];
$idea_id = $_GET['id'] ?? null;

if (!$idea_id) {
    header("Location: my_ideas.php");
    exit;
}

// Get idea details
$stmt = $conn->prepare("SELECT i.*, u.name as owner_name FROM ideas i JOIN users u ON i.user_id = u.id WHERE i.id = ?");
$stmt->execute([$idea_id]);
$idea = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$idea) {
    header("Location: my_ideas.php");
    exit;
}

// Check if user has access
$stmt = $conn->prepare("SELECT * FROM collaborators WHERE idea_id = ? AND user_id = ?");
$stmt->execute([$idea_id, $user_id]);
$collaboration = $stmt->fetch(PDO::FETCH_ASSOC);

$is_owner = $idea['user_id'] == $user_id;
$has_access = $is_owner || $collaboration;

if (!$has_access) {
    die("Access denied");
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $stmt = $conn->prepare("INSERT INTO comments (idea_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$idea_id, $user_id, $_POST['comment']]);
    logActivity($conn, $user_id, 'comment_added', 'Added comment to idea', $idea_id);
    header("Location: idea_view.php?id=$idea_id");
    exit;
}

// Get collaborators
$stmt = $conn->prepare("SELECT c.*, u.name, u.email, u.role as user_role FROM collaborators c JOIN users u ON c.user_id = u.id WHERE c.idea_id = ?");
$stmt->execute([$idea_id]);
$collaborators = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get comments
$stmt = $conn->prepare("SELECT c.*, u.name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.idea_id = ? ORDER BY c.created_at DESC");
$stmt->execute([$idea_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get media
$stmt = $conn->prepare("SELECT * FROM media WHERE idea_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$idea_id]);
$media_files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($idea['title']); ?> - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="mb-6">
            <a href="my_ideas.php" class="text-blue-600 hover:underline"><i class="fas fa-arrow-left mr-2"></i>Back to My Ideas</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Idea Card -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($idea['title']); ?></h1>
                            <p class="text-gray-600">by <?php echo htmlspecialchars($idea['owner_name']); ?> • <?php echo ucfirst($idea['industry']); ?></p>
                        </div>
                        <div class="flex space-x-2">
                            <?php if ($is_owner): ?>
                                <a href="idea_wizard.php?id=<?php echo $idea_id; ?>&step=2" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Progress</span>
                            <span><?php echo $idea['progress_percentage']; ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: <?php echo $idea['progress_percentage']; ?>%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-lg font-bold text-blue-600"><?php echo ucfirst($idea['status']); ?></p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600">Verification</p>
                            <p class="text-lg font-bold text-purple-600"><?php echo $idea['verification_score']; ?>/100</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600">Mode</p>
                            <p class="text-lg font-bold text-green-600"><?php echo $idea['is_reverse_mode'] ? 'Reverse' : 'Forward'; ?></p>
                        </div>
                    </div>

                    <?php if ($idea['description']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Description</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['description'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($idea['problem_statement']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Problem Statement</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['problem_statement'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($idea['solution']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Solution</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['solution'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($idea['target_market']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Target Market</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['target_market'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($idea['revenue_model']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Revenue Model</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['revenue_model'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($idea['competitive_advantage']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Competitive Advantage</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['competitive_advantage'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($idea['execution_plan']): ?>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">Execution Plan</h3>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($idea['execution_plan'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Comments Section -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Comments & Feedback</h3>
                    
                    <form method="POST" class="mb-6">
                        <textarea name="comment" rows="3" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="Add your feedback..." required></textarea>
                        <button type="submit" class="mt-2 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-comment mr-2"></i>Post Comment
                        </button>
                    </form>

                    <div class="space-y-4">
                        <?php if (empty($comments)): ?>
                            <p class="text-gray-500 text-center py-4">No comments yet. Be the first to provide feedback!</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user text-blue-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($comment['name']); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo date('M d, Y H:i', strtotime($comment['created_at'])); ?></p>
                                        </div>
                                    </div>
                                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Collaborators -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Collaborators</h3>
                    <div class="space-y-3">
                        <?php foreach ($collaborators as $collab): ?>
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($collab['name']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo ucfirst($collab['role']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($is_owner): ?>
                        <a href="invite_collaborator.php?id=<?php echo $idea_id; ?>" class="mt-4 block text-center bg-blue-50 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-100">
                            <i class="fas fa-user-plus mr-2"></i>Invite Collaborator
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <?php if ($is_owner): ?>
                            <a href="invite_collaborator.php?id=<?php echo $idea_id; ?>" class="block bg-blue-50 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-100">
                                <i class="fas fa-user-plus mr-2"></i>Invite Collaborator
                            </a>
                        <?php endif; ?>
                        <a href="export_idea.php?id=<?php echo $idea_id; ?>" target="_blank" class="block bg-green-50 text-green-700 px-4 py-2 rounded-lg hover:bg-green-100">
                            <i class="fas fa-download mr-2"></i>Export as PDF
                        </a>
                        <a href="upcoming_feature.php" class="block bg-purple-50 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-100">
                            <i class="fas fa-share mr-2"></i>Share Idea
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
