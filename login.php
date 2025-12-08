<?php
session_start();
require __DIR__ . '/business idea.php';

$error = '';

if (!empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } else {
        $stmt = $pdo->prepare("SELECT id, name, password_hash FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && !empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
            
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            if (!empty($_GET['redirect'])) {
                
                $redirect = $_GET['redirect'];
                $allowed_prefix = '/';
                
                if (strpos($redirect, 'http') === 0) {
                    header("Location: dashboard.php");
                    exit;
                } else {
                    header("Location: " . $redirect);
                    exit;
                }
            }

            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Incorrect email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - IdeateHub</title>
    <link rel="stylesheet" href="theme.css">
</head>
<body>
<div class="container">
    <div class="card card-hover">
        <h1 class="gradient-text">Log In</h1>

        <?php if (!empty($error)): ?>
            <div class="flash error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php<?= !empty($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>">
            <div class="field"><label>Email</label><input type="email" name="email" required></div>
            <div class="field"><label>Password</label><input type="password" name="password" required></div>
            <button class="btn" type="submit" name="login">Log In</button>
        </form>

        <p style="margin-top: .75rem;">
            <a href="forgot_password.php">Forgot password?</a>
        </p>
    </div>
</div>
</body>
</html>
