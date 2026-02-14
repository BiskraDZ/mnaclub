<?php
// logout.php — destroy session and redirect to login
session_start();
session_unset();
session_destroy();
// Simple redirect back to login page
header('Location: connexion.php');
exit;
?>