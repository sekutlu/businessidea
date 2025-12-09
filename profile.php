<?php
session_start();
require_once 'business idea.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$error = '';
$success = '';

$stmt = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($name === '' || $email === '') {
        $error = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $check->bind_param("si", $email, $user_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email is already used by another account.";
            $check->close();
        } else {
            $check->close();

            if (!empty($password)) {
                if (strlen($password) < 8) {
                    $error = "Password must be at least 8 characters.";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $upd = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
                    $upd->bind_param("sssi", $name, $email, $hash, $user_id);
                    if ($upd->execute()) {
                        $success = "Profile and password updated successfully.";
                        $_SESSION['user_name'] = $name;
                    } else {
                        $error = "Failed to update profile. Try again.";
                    }
                    $upd->close();
                }
            } else {
                
                $upd = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $upd->bind_param("ssi", $name, $email, $user_id);
                if ($upd->execute()) {
                    $success = "Profile updated successfully.";
                    $_SESSION['user_name'] = $name;
                } else {
                    $error = "Failed to update profile. Try again.";
                }
                $upd->close();
            }

            if ($success) {
                $stmt2 = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
                $stmt2->bind_param("i", $user_id);
                $stmt2->execute();
                $user = $stmt2->get_result()->fetch_assoc();
                $stmt2->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Profile - Edit Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="theme.css"> 
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="container mx-auto px-6 py-8 max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Edit Profile</h2>
            <p class="text-sm text-gray-600 mb-4">Update your personal details below.</p>

            <?php if ($error): ?>
                <div class="mb-4 p-3 bg-red-50 text-red-700 rounded"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="mb-4 p-3 bg-green-50 text-green-700 rounded"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="post" action="profile.php">
                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Full name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Email address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                           class="w-full border rounded px-3 py-2" required>
                </div>

                <hr class="my-4">

                <p class="text-sm text-gray-600 mb-3">Change password (optional)</p>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">New password</label>
                    <input type="password" name="password" placeholder="Leave empty to keep current password"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Confirm new password</label>
                    <input type="password" name="confirm_password" placeholder="Repeat new password"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save changes
                    </button>
                    <a href="dashboard.php" class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">Cancel</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
