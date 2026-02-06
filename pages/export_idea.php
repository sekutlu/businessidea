<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$idea_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$idea_id) {
    header("Location: my_ideas.php");
    exit;
}

// Get idea details
$stmt = $conn->prepare("SELECT i.*, u.name as owner_name FROM ideas i JOIN users u ON i.user_id = u.id WHERE i.id = ?");
$stmt->execute([$idea_id]);
$idea = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$idea) {
    die("Idea not found");
}

// Check access
$stmt = $conn->prepare("SELECT * FROM collaborators WHERE idea_id = ? AND user_id = ?");
$stmt->execute([$idea_id, $user_id]);
$has_access = $idea['user_id'] == $user_id || $stmt->fetch();

if (!$has_access) {
    die("Access denied");
}

// Set headers for PDF download
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($idea['title']); ?> - Export</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        h1 { color: #2563eb; border-bottom: 3px solid #2563eb; padding-bottom: 10px; }
        h2 { color: #1e40af; margin-top: 30px; border-left: 4px solid #2563eb; padding-left: 10px; }
        .meta { background: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .meta-item { display: inline-block; margin-right: 20px; }
        .content { margin: 20px 0; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 1px solid #ccc; font-size: 12px; color: #666; }
        @media print {
            body { margin: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Print / Save as PDF
        </button>
        <a href="idea_view.php?id=<?php echo $idea_id; ?>" style="margin-left: 10px; padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 5px;">
            Back to Idea
        </a>
    </div>

    <h1><?php echo htmlspecialchars($idea['title']); ?></h1>
    
    <div class="meta">
        <div class="meta-item"><strong>Owner:</strong> <?php echo htmlspecialchars($idea['owner_name']); ?></div>
        <div class="meta-item"><strong>Industry:</strong> <?php echo ucfirst($idea['industry']); ?></div>
        <div class="meta-item"><strong>Status:</strong> <?php echo ucfirst($idea['status']); ?></div>
        <div class="meta-item"><strong>Progress:</strong> <?php echo $idea['progress_percentage']; ?>%</div>
        <div class="meta-item"><strong>Verification Score:</strong> <?php echo $idea['verification_score']; ?>/100</div>
        <div class="meta-item"><strong>Mode:</strong> <?php echo $idea['is_reverse_mode'] ? 'Reverse' : 'Forward'; ?></div>
        <div class="meta-item"><strong>Created:</strong> <?php echo date('F d, Y', strtotime($idea['created_at'])); ?></div>
    </div>

    <?php if ($idea['description']): ?>
        <h2>Description</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['description'])); ?></div>
    <?php endif; ?>

    <?php if ($idea['problem_statement']): ?>
        <h2>Problem Statement</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['problem_statement'])); ?></div>
    <?php endif; ?>

    <?php if ($idea['solution']): ?>
        <h2>Solution</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['solution'])); ?></div>
    <?php endif; ?>

    <?php if ($idea['target_market']): ?>
        <h2>Target Market</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['target_market'])); ?></div>
    <?php endif; ?>

    <?php if ($idea['revenue_model']): ?>
        <h2>Revenue Model</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['revenue_model'])); ?></div>
    <?php endif; ?>

    <?php if ($idea['competitive_advantage']): ?>
        <h2>Competitive Advantage</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['competitive_advantage'])); ?></div>
    <?php endif; ?>

    <?php if ($idea['execution_plan']): ?>
        <h2>Execution Plan</h2>
        <div class="content"><?php echo nl2br(htmlspecialchars($idea['execution_plan'])); ?></div>
    <?php endif; ?>

    <div class="footer">
        <p><strong>IdeateHub Business Idea Platform</strong></p>
        <p>Generated on <?php echo date('F d, Y H:i'); ?> | Confidential Business Document</p>
    </div>

    <script>
        // Auto-print on load if requested
        if (window.location.search.includes('auto=1')) {
            window.onload = function() { window.print(); }
        }
    </script>
</body>
</html>
