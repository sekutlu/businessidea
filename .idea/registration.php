<?php
session_start();

require_once 'db1.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        
        $stmt = $conn->prepare("SELECT id FROM users1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "This email is already registered.";
        } else {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users1 (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration successful! You can now login.";
                header("refresh:2;url=login.php");
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Secure Auth</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="style1.css">
</head>
<body class="gradient-bg">

    <div class="container full-height-center">
        <div class="col-md-5">
            <div class="card card-hover p-4 shadow">
                <div class="card-body">
                    
                    <div class="feature-icon gradient-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    </div>

                    <h2 class="text-center mb-4 gradient-text">Create Account</h2>

                    <?php if($error): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if($success): ?>
                        <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label text-muted small fw-bold">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-muted small fw-bold">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-muted small fw-bold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Create a secure password" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label text-muted small fw-bold">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-custom mt-3">Sign Up</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small">Already have an account? 
                            <a href="login.php" class="text-primary fw-bold text-decoration-none">Login here</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>
</html>
