<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Update with your MySQL password
$dbname = 'tib_task';

try {
    // Connect without database to create tib_task
    $tempPdo = new PDO("mysql:host=$host", $username, $password);
    $tempPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tempPdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $tempPdo = null;

    // Connect to tib_task
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
