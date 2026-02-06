<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$idea_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];
$message = '';
$error = '';

if (!$idea_id) {
    header("Location: my_ideas.php");
    exit;
}

// Check if user is owner
$stmt = $conn->prepare("SELECT * FROM ideas WHERE id = ? AND user_id = ?");
$stmt->execute([$idea_id, $user_id]);
$idea = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$idea) {
    die("Access denied. Only idea owner can invite collaborators.");
}

// Handle invitation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'collaborator';
    $permissions = $_POST['permissions'] ?? 'view';
    
    // Find user by email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $invitee = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$invitee) {
        $error = "User with email $email not found. They need to register first.";
    } else {
        // Check if already collaborator
        $stmt = $conn->prepare("SELECT id FROM collaborators WHERE idea_id = ? AND user_id = ?");
        $stmt->execute([$idea_id, $invitee['id']]);
        
        if ($stmt->fetch()) {
            $error = "This user is already a collaborator on this idea.";
        } else {
            // Add collaborator
            $stmt = $conn->prepare("INSERT INTO collaborators (idea_id, user_id, role, permissions) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$idea_id, $invitee['id'], $role, $permissions])) {
                logActivity($conn, $user_id, 'collaborator_invited', "Invited $email as $role", $idea_id);
                $message = "Successfully invited $email as $role!";
            } else {
                $error = "Failed to add collaborator. Please try again.";
            }
        }
    }
}

// Get current collaborators
$stmt = $conn->prepare("SELECT c.*, u.name, u.email FROM collaborators c JOIN users u ON c.user_id = u.id WHERE c.idea_id = ?");
$stmt->execute([$idea_id]);
$collaborators = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invite Collaborators - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="max-w-4xl mx-auto py-10 px-6">
        <div class="mb-6">
            <a href="idea_view.php?id=<?php echo $idea_id; ?>" class="text-blue-600 hover:underline">
                <i class="fas fa-arrow-left mr-2"></i>Back to Idea
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Invite Collaborators</h1>
            <p class="text-gray-600 mb-6">Add team members to work on: <strong><?php echo htmlspecialchars($idea['title']); ?></strong></p>

            <?php if ($message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-check-circle mr-2"></i><?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-circle mr-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Email Address</label>
                        <input type="email" name="email" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="collaborator@example.com" required>
                        <p class="text-xs text-gray-500 mt-1">User must be registered on the platform</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Role</label>
                        <select name="role" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500">
                            <option value="collaborator">Collaborator</option>
                            <option value="mentor">Mentor</option>
                            <option value="investor">Investor</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-2">Permissions</label>
                    <select name="permissions" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500">
                        <option value="view">View Only - Can view and comment</option>
                        <option value="edit">Edit - Can view, comment, and edit</option>
                        <option value="admin">Admin - Full access including inviting others</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-user-plus mr-2"></i>Send Invitation
                </button>
            </form>

            <hr class="my-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-4">Current Collaborators (<?php echo count($collaborators); ?>)</h2>
            
            <div class="space-y-3">
                <?php foreach ($collaborators as $collab): ?>
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-user text-blue-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800"><?php echo htmlspecialchars($collab['name']); ?></p>
                                <p class="text-sm text-gray-600"><?php echo htmlspecialchars($collab['email']); ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <?php echo ucfirst($collab['role']); ?>
                            </span>
                            <p class="text-xs text-gray-500 mt-1"><?php echo ucfirst($collab['permissions']); ?> access</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
