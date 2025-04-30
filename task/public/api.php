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
header('Content-Type: application/json');

$route = $_GET['route'] ?? '';

if ($route === 'female-adult-8pm') {
    $stmt = $pdo->prepare("
        SELECT p.name, m.name AS medicine_name
        FROM patients p
        JOIN intakes i ON p.id = i.patient_id
        JOIN medicines m ON i.medicine_id = m.id
        WHERE p.gender = 'female' AND p.age_group = 'adult' AND i.intake_time = '8pm'
    ");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} elseif ($route === 'male-infant-8am') {
    $stmt = $pdo->prepare("
        SELECT p.name, m.name AS medicine_name
        FROM patients p
        JOIN intakes i ON p.id = i.patient_id
        JOIN medicines m ON i.medicine_id = m.id
        WHERE p.gender = 'male' AND p.age_group = 'infant' AND i.intake_time = '8am' AND m.infant_safe = 1
    ");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Invalid route']);
}
?>
