<?php
session_start();
require_once 'reset_config.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    
    // Validate email
    if (empty($email)) {
        $_SESSION['reset_error'] = 'Please enter your email address.';
        header('Location: forgot.html');
        exit;
    }

    // Check if user exists
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            // Generate unique token
            $token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime(RESET_TOKEN_EXPIRE));
            
            // Delete any existing tokens for this email
            $pdo->prepare("DELETE FROM password_resets WHERE email = :email")
                ->execute([':email' => $email]);
            
            // Store new token
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (:email, :token, :expires_at)");
            $stmt->execute([
                ':email' => $email,
                ':token' => $token,
                ':expires_at' => $expires_at
            ]);
            
            // Create reset link
            $reset_link = "https://yourdomain.com/reset_password.php?token=" . urlencode($token);
            
            // Email content
            $subject = "Password Reset Request";
            $body = "
                <h2>Password Reset</h2>
                <p>We received a request to reset your password. If you didn't make this request, you can ignore this email.</p>
                <p>To reset your password, click the following link:</p>
                <p><a href='$reset_link'>$reset_link</a></p>
                <p>This link will expire in 1 hour.</p>
            ";
            
            // Send email
            if (sendEmail($email, $subject, $body)) {
                $_SESSION['reset_success'] = 'Password reset link has been sent to your email.';
            } else {
                $_SESSION['reset_error'] = 'Failed to send reset email. Please try again.';
            }
        } else {
            $_SESSION['reset_success'] = 'If an account exists with that email, a reset link has been sent.';
            // We show the same message whether the email exists or not for security
        }
        
        header('Location: forgot.html');
        exit;
        
    } catch(PDOException $e) {
        $_SESSION['reset_error'] = 'Database error. Please try again.';
        header('Location: forgot.html');
        exit;
    }
} else {
    header('Location: forgot.html');
    exit;
}
?>