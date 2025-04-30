<?php
require '../config/db.php';
//session_start();

// Restrict access to authenticated users
if (!isset($_SESSION['user_id'])) {
    header('Location: ?route=login');
    exit;
}

$action = $_GET['action'] ?? '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($action === 'add_patient') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $gender = $_POST['gender'] ?? '';
            $age_group = $_POST['age_group'] ?? '';
            if ($name && in_array($gender, ['male', 'female']) && in_array($age_group, ['infant', 'adult'])) {
                $stmt = $pdo->prepare("INSERT INTO patients (name, gender, age_group) VALUES (?, ?, ?)");
                $stmt->execute([$name, $gender, $age_group]);
                $message = "Patient added successfully.";
            } else {
                $message = "Invalid patient data.";
            }
        } elseif ($action === 'add_medicine') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $frequency = $_POST['frequency'] ?? '';
            $intake_times = $_POST['intake_times'] ?? [];
            $infant_safe = isset($_POST['infant_safe']) ? 1 : 0;
            if ($name && in_array($frequency, ['once', 'twice', 'thrice']) && !empty($intake_times)) {
                $valid_times = array_intersect($intake_times, ['8am', '2pm', '8pm']);
                if (!empty($valid_times)) {
                    $stmt = $pdo->prepare("INSERT INTO medicines (name, frequency, intake_times, infant_safe) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $frequency, json_encode($valid_times), $infant_safe]);
                    $message = "Medicine added successfully.";
                } else {
                    $message = "Invalid intake times.";
                }
            } else {
                $message = "Invalid medicine data.";
            }
        } elseif ($action === 'add_intake') {
            $patient_id = filter_input(INPUT_POST, 'patient_id', FILTER_VALIDATE_INT);
            $medicine_id = filter_input(INPUT_POST, 'medicine_id', FILTER_VALIDATE_INT);
            $intake_time = $_POST['intake_time'] ?? '';
            if ($patient_id && $medicine_id && in_array($intake_time, ['8am', '2pm', '8pm'])) {
                // Check if medicine is infant-safe for infant patients
                $patient = $pdo->query("SELECT age_group FROM patients WHERE id = $patient_id")->fetch(PDO::FETCH_ASSOC);
                $medicine = $pdo->query("SELECT infant_safe FROM medicines WHERE id = $medicine_id")->fetch(PDO::FETCH_ASSOC);
                if ($patient['age_group'] === 'infant' && !$medicine['infant_safe']) {
                    $message = "Cannot assign non-infant-safe medicine to an infant.";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO intakes (patient_id, medicine_id, intake_time) VALUES (?, ?, ?)");
                    $stmt->execute([$patient_id, $medicine_id, $intake_time]);
                    $message = "Intake added successfully.";
                }
            } else {
                $message = "Invalid intake data.";
            }
        }
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

include '../src/views/populate.php';
?>
