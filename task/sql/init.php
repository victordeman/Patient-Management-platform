<?php
require_once '../config/db.php';

// Check if a table exists
function tableExists($pdo, $table) {
    try {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        return $result->rowCount() > 0;
    } catch (PDOException $e) {
        die("Error checking table: " . $e->getMessage());
    }
}

// Check if patients table has data
function hasPatientData($pdo) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM patients");
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

// Create tables
if (!tableExists($pdo, 'patients')) {
    $pdo->exec("
        CREATE TABLE patients (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            gender ENUM('male', 'female') NOT NULL,
            age_group ENUM('infant', 'adult') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
}

if (!tableExists($pdo, 'medicines')) {
    $pdo->exec("
        CREATE TABLE medicines (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            frequency ENUM('once', 'twice', 'thrice') NOT NULL,
            intake_times JSON NOT NULL,
            infant_safe TINYINT(1) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
}

if (!tableExists($pdo, 'intakes')) {
    $pdo->exec("
        CREATE TABLE intakes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            patient_id INT NOT NULL,
            medicine_id INT NOT NULL,
            intake_time ENUM('8am', '2pm', '8pm') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
            FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE CASCADE
        )
    ");
}

if (!tableExists($pdo, 'users')) {
    $pdo->exec("
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
}

// Populate sample data if needed
if (!hasPatientData($pdo)) {
    $pdo->exec("
        INSERT INTO patients (name, gender, age_group) VALUES
            ('Jada Smith', 'female', 'adult'),
            ('Will Smith', 'male', 'infant'),
            ('Willow Smith, 'female', 'adult'),
            ('Jaden Smith', 'male', 'infant')
    ");

    $pdo->exec("
        INSERT INTO medicines (name, frequency, intake_times, infant_safe) VALUES
            ('Paracetamol', 'twice', '[\"8am\", \"8pm\"]', 1),
            ('Ibuprofen', 'thrice', '[\"8am\", \"2pm\", \"8pm\"]', 0)
    ");

    $pdo->exec("
        INSERT INTO intakes (patient_id, medicine_id, intake_time) VALUES
            (1, 1, '8pm'),
            (1, 2, '8pm'),
            (2, 1, '8am'),
            (3, 2, '8pm'),
            (4, 1, '8am')
    ");
}

// Populate users for authentication
if ($pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() == 0) {
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO users (username, password) VALUES ('admin', '$hashedPassword')");
}
?>
