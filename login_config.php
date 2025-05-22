<?php
// Database configuration
define('DB_HOST', 'localhost:3306');
define('DB_USERNAME', 'root'); // Change to your database username
define('DB_PASSWORD', 'Taha1234'); // Change to your database password
define('DB_NAME', 'nexus_gaming');

// Establish database connection
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>