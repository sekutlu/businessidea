<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'];
    $duration = ['monthly' => '+1 month', 'quarterly' => '+3 months', 'annual' => '+1 year'];
    $expires = date('Y-m-d', strtotime($duration[$plan]));
    
    $stmt = $conn->prepare("UPDATE users SET subscription_type = ?, subscription_expires = ? WHERE id = ?");
    $stmt->execute([$plan, $expires, $user_id]);
    
    $_SESSION['subscription_type'] = $plan;
    $_SESSION['subscription_expires'] = $expires;
    
    logActivity($conn, $user_id, 'subscription', "Subscribed to $plan plan");
    header("Location: dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT subscription_type, subscription_expires FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Choose Your Plan</h1>
            <p class="text-gray-600">Unlock premium features to accelerate your business ideas</p>
        </div>

        <?php if ($user['subscription_type'] !== 'free'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                Your <?php echo ucfirst($user['subscription_type']); ?> subscription is active until <?php echo date('M d, Y', strtotime($user['subscription_expires'])); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-8 border-2 border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Free</h3>
                <p class="text-4xl font-bold text-gray-800 mb-6">L0<span class="text-lg text-gray-600">/month</span></p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> 3 Business Ideas</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Basic Templates</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Progress Tracking</li>
                    <li class="flex items-center text-gray-400"><i class="fas fa-times text-red-500 mr-2"></i> Collaboration</li>
                    <li class="flex items-center text-gray-400"><i class="fas fa-times text-red-500 mr-2"></i> Analytics</li>
                </ul>
                <button disabled class="w-full bg-gray-300 text-gray-600 px-6 py-3 rounded-lg cursor-not-allowed">Current Plan</button>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 border-4 border-blue-600 relative">
                <div class="absolute top-0 right-0 bg-blue-600 text-white px-4 py-1 rounded-bl-lg rounded-tr-lg text-sm font-bold">POPULAR</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Monthly</h3>
                <p class="text-4xl font-bold text-blue-600 mb-6">L290<span class="text-lg text-gray-600">/month</span></p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Unlimited Ideas</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> All Templates</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Team Collaboration</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Advanced Analytics</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Priority Support</li>
                </ul>
                <form method="POST">
                    <input type="hidden" name="plan" value="monthly">
                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">Subscribe Now</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8 border-2 border-gray-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Annual</h3>
                <p class="text-4xl font-bold text-purple-600 mb-6">L2,490<span class="text-lg text-gray-600">/year</span></p>
                <p class="text-sm text-green-600 font-semibold mb-4">Save L990/year</p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Everything in Monthly</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Investor Matching</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Mentor Access</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Export Reports</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> API Access</li>
                </ul>
                <form method="POST">
                    <input type="hidden" name="plan" value="annual">
                    <button type="submit" class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700">Subscribe Now</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
