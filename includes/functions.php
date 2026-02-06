<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /pages/login.php");
        exit;
    }
}

function hasActiveSubscription() {
    if (!isset($_SESSION['subscription_type']) || $_SESSION['subscription_type'] === 'free') {
        return false;
    }
    
    if (isset($_SESSION['subscription_expires'])) {
        return strtotime($_SESSION['subscription_expires']) > time();
    }
    
    return false;
}

function checkSubscriptionAccess($feature = 'premium') {
    if (!hasActiveSubscription()) {
        header("Location: /pages/subscription.php");
        exit;
    }
}

function logActivity($conn, $user_id, $action, $description = '', $idea_id = null) {
    $stmt = $conn->prepare("INSERT INTO activity_log (user_id, idea_id, action, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $idea_id, $action, $description]);
}

function updateCredibilityPoints($conn, $user_id, $points) {
    $stmt = $conn->prepare("UPDATE users SET credibility_points = credibility_points + ? WHERE id = ?");
    $stmt->execute([$points, $user_id]);
}

function calculateProgress($idea) {
    $fields = ['description', 'problem_statement', 'solution', 'target_market', 'revenue_model', 'competitive_advantage', 'execution_plan'];
    $completed = 0;
    foreach ($fields as $field) {
        if (!empty($idea[$field])) $completed++;
    }
    return round(($completed / count($fields)) * 100);
}
?>
