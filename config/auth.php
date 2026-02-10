<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Check if user has specific role
function has_role($required_role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $required_role;
}

// Check if user has at least one of the required roles
function has_any_role($required_roles) {
    if (!isset($_SESSION['user_role'])) return false;
    return in_array($_SESSION['user_role'], $required_roles);
}

// Redirect to login if not authenticated
function require_login() {
    if (!is_logged_in()) {
        // Store the requested URL for redirecting back after login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: /attendance-system/index.php");
        exit();
    }
}

// Redirect if user doesn't have required role
function require_role($required_role) {
    require_login();
    if (!has_role($required_role)) {
        header("Location: /attendance-system/unauthorized.php");
        exit();
    }
}

// Get current user info
function current_user() {
    if (!is_logged_in()) return null;
    
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'username' => $_SESSION['username'] ?? null,
        'full_name' => $_SESSION['full_name'] ?? null,
        'role' => $_SESSION['user_role'] ?? null,
        'class' => $_SESSION['class'] ?? null,
        'subject' => $_SESSION['subject'] ?? null
    ];
}

// CSRF protection
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Logout function
function logout() {
    $_SESSION = array();
    session_destroy();
    header("Location: /attendance-system/index.php");
    exit();
}
?>