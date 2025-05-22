<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete cookies
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}
if (isset($_COOKIE['remember_pass'])) {
    setcookie('remember_pass', '', time() - 3600, '/');
}

// Redirect to login page
header('Location: login.html');
exit;
?>