<?php
require '../config/db.php';
//session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ?route=login');
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.name, m.name AS medicine_name
    FROM patients p
    JOIN intakes i ON p.id = i.patient_id
    JOIN medicines m ON i.medicine_id = m.id
    WHERE p.gender = 'male' AND p.age_group = 'infant' AND i.intake_time = '8am' AND m.infant_safe = 1
");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../src/views/male_infant_8am.php';
