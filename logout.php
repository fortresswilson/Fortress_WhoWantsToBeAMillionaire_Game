<?php
// ============================================================
// logout.php
// Destroys the session cleanly and redirects to landing page.
// Called by the "Logout" link in header.php (teammate's nav).
// ============================================================
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

header('Location: index.php');
exit;
