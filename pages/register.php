<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'entrepreneur';
    
    if (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = 'Email already registered';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            
            if ($stmt->execute([$name, $email, $hashed, $role])) {
                $success = 'Registration successful! Please login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>
    
    <div class="flex items-center justify-center min-h-screen py-10">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create Account</h2>
            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST">
                <label class="block mb-2 font-medium">Full Name</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded mb-4" required>
                
                <label class="block mb-2 font-medium">Email</label>
                <input type="email" name="email" class="w-full border px-3 py-2 rounded mb-4" required>
                
                <label class="block mb-2 font-medium">Password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded mb-4" required>
                
                <label class="block mb-2 font-medium">I am a</label>
                <select name="role" class="w-full border px-3 py-2 rounded mb-4">
                    <option value="entrepreneur">Entrepreneur</option>
                    <option value="mentor">Mentor</option>
                    <option value="investor">Investor</option>
                </select>
                
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</button>
            </form>
            <p class="mt-4 text-center text-gray-600">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login</a></p>
        </div>
    </div>
</body>
</html>
