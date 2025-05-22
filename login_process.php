<?php
session_start();
require_once 'login_config.php';

// Initialize variables
$email_username = $password = '';
$errors = [];

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate email/username
    if (empty(trim($_POST['email']))) {
        $errors[] = 'Please enter email or username.';
    } else {
        $email_username = trim($_POST['email']);
    }
    
    // Validate password
    if (empty(trim($_POST['password']))) {
        $errors[] = 'Please enter your password.';
    } else {
        $password = trim($_POST['password']);
    }
    
    // If no errors, try to login
    if (empty($errors)) {
        // Prepare SQL to check for user
        $sql = "SELECT id, username, email, password FROM users WHERE email = :email OR username = :username";
        
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':email', $param_email_username, PDO::PARAM_STR);
            $stmt->bindParam(':username', $param_email_username, PDO::PARAM_STR);
            
            $param_email_username = $email_username;
            
            if ($stmt->execute()) {
                // Check if user exists
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch();
                    $id = $row['id'];
                    $username = $row['username'];
                    $email = $row['email'];
                    $hashed_password = $row['password'];
                    
                    // Verify password
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, start new session
                        session_regenerate_id();
                        
                        // Store data in session variables
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $id;
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        
                        // Remember me functionality
                        if (!empty($_POST['remember'])) {
                            // Set cookies to expire in 30 days
                            setcookie('remember_user', $email, time() + (30 * 24 * 60 * 60), '/');
                            setcookie('remember_pass', $password, time() + (30 * 24 * 60 * 60), '/');
                        } else {
                            // Delete cookies if they exist
                            if (isset($_COOKIE['remember_user'])) {
                                setcookie('remember_user', '', time() - 3600, '/');
                            }
                            if (isset($_COOKIE['remember_pass'])) {
                                setcookie('remember_pass', '', time() - 3600, '/');
                            }
                        }
                        
                        // Redirect to dashboard or home page
                        header('Location: dashboard.php');
                        exit;
                    } else {
                        $errors[] = 'The password you entered is not valid.';
                    }
                } else {
                    $errors[] = 'No account found with that email/username.';
                }
            } else {
                $errors[] = 'Oops! Something went wrong. Please try again later.';
            }
            
            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}

// If we got here, there were errors or the form wasn't submitted
// Redirect back to login page with errors
$_SESSION['login_errors'] = $errors;
header('Location: login.html');
exit;
?>