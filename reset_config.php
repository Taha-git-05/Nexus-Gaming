<?php
// Database configuration
define('DB_HOST', 'localhost:3306');
define('DB_USERNAME', 'root'); // Change to your database username
define('DB_PASSWORD', 'Taha1234'); // Change to your database password
define('DB_NAME', 'nexus_gaming');

// Email configuration (for sending reset links)
define('SMTP_HOST', 'smtp.example.com'); // Your SMTP server
define('SMTP_USER', 'your_email@example.com'); // SMTP username
define('SMTP_PASS', 'your_email_password'); // SMTP password
define('SMTP_PORT', 587); // Typically 587 for TLS
define('SMTP_FROM', 'noreply@nexusgaming.com');
define('SMTP_FROM_NAME', 'Nexus Gaming');

// Password reset settings
define('RESET_TOKEN_EXPIRE', '+1 hour'); // How long the reset link is valid

// Establish database connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Function to send emails
function sendEmail($to, $subject, $body) {
    require 'path/to/PHPMailer/src/Exception.php';
    require 'path/to/PHPMailer/src/PHPMailer.php';
    require 'path/to/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>