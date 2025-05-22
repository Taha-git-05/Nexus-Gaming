<?php
$host = 'localhost:3306';
$dbname = 'nexus_gaming';
$username = 'root'; // Change this to your MySQL username
$password = 'Taha1234'; // Change this to your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>