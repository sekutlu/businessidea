<?php
session_start();
require_once "db1.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

        $error = "All fields are required.";

    } else {

        $stmt = $conn->prepare("SELECT id, name, password_hash FROM users1 WHERE email = ?");
        $stmt->bind_param("s", $email);
        
        if ($stmt->execute()) {

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user) {

                if (password_verify($password, $user['password_hash'])) {

                    $_SESSION["user_id"] = $user['id'];
                    $_SESSION["user_name"] = $user['name'];

                    header("Location: dashboard.php");
                    exit;

                } else {
                    $error = "Incorrect password.";
                }

            } else {
                $error = "No account found with this email.";
            }

        } else {
            $error = "Database error. Please try again.";
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
    <title>Login | Secure Auth</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style1.css">
</head>

<body class="gradient-bg">

    <div class="container full-height-center">
        <div class="col-md-5">
            <div class="card card-hover p-4 shadow">
                <div class="card-body">

                    <div class="feature-icon gradient-bg mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3h-1V3H7v10h4v-3h1v3a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V3z"/>
                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-2-2a.5.5 0 1 0-.708.708L10.293 8l-1.147 1.146a.5.5 0 0 0 .708.708l2-2z"/>
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </div>

                    <h2 class="text-center mb-4 gradient-text">Login</h2>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Email Address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn btn-custom mt-3 w-100">Login</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small">
                            Don't have an account?
                            <a href="registration.php" class="text-primary fw-bold text-decoration-none">
                                Register here
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
