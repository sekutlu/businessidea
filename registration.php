<?php
session_start();
require __DIR__ . '/business idea.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

function flash($msg, $type = 'info') {
    $_SESSION['flash'] = $msg;
    $_SESSION['flash_type'] = $type;
}

if (isset($_POST['register'])) {
    
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        flash('Invalid form submission.', 'error');
        header("Location: registration.php");
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (strlen($name) < 3) {
        flash('Name must be at least 3 characters.', 'error');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('Invalid email address.', 'error');
    } elseif (strlen($password) < 8) {
        flash('Password must be at least 8 characters.', 'error');
    } elseif ($password !== $confirm) {
        flash('Passwords do not match.', 'error');
    } else {
        
        $stmt = $pdo->prepare("SELECT id FROM users1 WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            flash('Email already exists. Please log in.', 'error');
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO users (name, phone, dob, sex, email, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
            $insert->execute([$name, $email, $password_hash]);
            flash('Account created successfully! Please log in.', 'success');
            header("Location: login.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register - IdeateHub</title>
    <link rel="stylesheet" href="theme.css">
</head>
<body>
<div class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash <?= htmlspecialchars($_SESSION['flash_type']) ?>">
            <?= htmlspecialchars($_SESSION['flash']); ?>
        </div>
        <?php unset($_SESSION['flash'], $_SESSION['flash_type']); ?>
    <?php endif; ?>

    <div class="card card-hover">
        <h1 class="gradient-text">Create Account</h1>

        <form method="POST" action="registration.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">

            <div class="field"><label>Name</label><input name="name" type="text" required></div>

            <div class="field"><label>Email</label><input type="email" name="email" required></div>
            <div class="field"><label>Password</label><input type="password" name="password" required></div>
            <div class="field"><label>Confirm Password</label><input type="password" name="confirm_password" required></div>

            <button class="btn" type="submit" name="register">Register</button>
        </form>
    </div>
</div>
</body>
</html>
