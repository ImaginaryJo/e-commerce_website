<?php
// Start a new session or resume the existing session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: ../HTML/login.html");
exit;
?>
