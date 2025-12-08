<?php
session_start();
if (isset($_GET['start'])) {
    if (!empty($_SESSION['user_id'])) {
        header("Location: dashboard.php");
        exit;
    }
    header("Location: registration.php");
    exit;
}

function require_login() {
    if (empty($_SESSION['user_id'])) {
        
        header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}
