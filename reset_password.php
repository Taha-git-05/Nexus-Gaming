<?php
session_start();
require_once 'reset_config.php';

$token = $_GET['token'] ?? '';
$valid_token = false;
$email = '';

// Validate token
if (!empty($token)) {
    try {
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = :token AND expires_at > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $email = $row['email'];
            $valid_token = true;
        }
    } catch(PDOException $e) {
        // Log error but don't show to user
        error_log("Token validation error: " . $e->getMessage());
    }
}

// Process password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $valid_token) {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords
    if (empty($new_password) || empty($confirm_password)) {
        $_SESSION['reset_error'] = 'Please enter and confirm your new password.';
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['reset_error'] = 'Passwords do not match.';
    } else {
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        try {
            $pdo->beginTransaction();
            
            // Update user password
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
            $stmt->execute([
                ':password' => $hashed_password,
                ':email' => $email
            ]);
            
            // Delete the used token
            $pdo->prepare("DELETE FROM password_resets WHERE token = :token")
                ->execute([':token' => $token]);
            
            $pdo->commit();
            
            $_SESSION['reset_success'] = 'Your password has been reset successfully. You can now login with your new password.';
            header('Location: login.html');
            exit;
            
        } catch(PDOException $e) {
            $pdo->rollBack();
            $_SESSION['reset_error'] = 'Failed to reset password. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password | Nexus Gaming</title>
    <!-- Include your CSS styles here -->
</head>
<body>
    <header class="header">
        <!-- Your header content -->
    </header>

    <fieldset class="fieldset">
        <legend class="legend">SET NEW PASSWORD</legend>

        <?php if (!$valid_token): ?>
            <div class="error-message">
                Invalid or expired password reset link. Please request a new reset link.
            </div>
            <div class="instructions">
                <a href="forgot.html">Request new reset link</a>
            </div>
        <?php else: ?>
            <?php if (isset($_SESSION['reset_error'])): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($_SESSION['reset_error']); unset($_SESSION['reset_error']); ?>
                </div>
            <?php endif; ?>

            <form class="form" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                
                <span class="input-span">
                    <label for="password" class="label">New Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter new password" required />
                </span>
                
                <span class="input-span">
                    <label for="confirm_password" class="label">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required />
                </span>

                <input class="submit" type="submit" value="Reset Password" />
            </form>
        <?php endif; ?>
    </fieldset>
</body>
</html>