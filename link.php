<?php
// link.php
session_start();

/**
 * If user clicks "Get Started" from index.php, use this file as a small router.
 * - If logged in -> dashboard.php
 * - If not logged in -> registration.php
 *
 * Also provides require_login() helper for protecting pages.
 */

if (isset($_GET['start'])) {
    if (!empty($_SESSION['user_id'])) {
        header("Location: dashboard.php");
        exit;
    }
    header("Location: registration.php");
    exit;
}

// Protect pages: call require_login() at top of protected pages
function require_login() {
    if (empty($_SESSION['user_id'])) {
        // Provide optional redirect param so login can send user back
        header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}
