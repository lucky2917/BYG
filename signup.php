<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_connect.php'; // Connect to the database

// Check if the connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // Generate OTP

    $sql = "INSERT INTO users (full_name, email, password, otp, is_verified) VALUES ('$full_name', '$email', '$password', '$otp', 0)";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $email;
        $_SESSION['otp'] = $otp;
        
        // Redirect to verify OTP page
        header("Location: /219_220/verify_otp.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>