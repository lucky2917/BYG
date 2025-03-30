<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_connect.php';

// Load PHPMailer
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    // Insert user details into the database
    $sql = "INSERT INTO users (full_name, email, password, otp, is_verified) VALUES ('$full_name', '$email', '$password', '$otp', 0)";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $email;

        // Send OTP via Email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'arjun.gandreddi2005@gmail.com'; 
            $mail->Password = 'pbdo pvis hjqs nlen'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587;

            $mail->setFrom('arjun.gandreddi2005@gmail.com', 'BYG Sports Booking');
            $mail->addAddress($email);
            $mail->Subject = 'Your OTP for BYG Registration';
            //text which is going to our email is here
            $mail->Body = "Hello $full_name,\n\nYour OTP for account verification is: $otp\n\nThank you for using BYG!";

            if ($mail->send()) {
                header("Location: verify_otp.php");
                exit();
            } else {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>