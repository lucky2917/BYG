<?php
session_start();
session_destroy(); // Destroy session
header("Location: main.php"); // Redirect to login page
exit();
?>