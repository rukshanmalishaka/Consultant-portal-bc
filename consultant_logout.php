<!-- consultant_logout.php -->
<?php
session_start();

// Destroy the consultant's session
session_destroy();

// Redirect to the consultant login page after logout
header("Location: consultant_login.php");
exit;
?>
