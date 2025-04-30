<!DOCTYPE html>
<html>
<head>
    <title>Filter Patients</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Filter Patients</h1>
    <form method="POST" action="?route=filter">
        <label>Gender: 
            <select name="gender">
                <option value="">All</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </label>
        <label>Age Group: 
            <select name="age_group">
                <option value="">All</option>
                <option value="infant">Infant</option>
                <option value="adult">Adult</option>
            </select>
        </label>
        <label>Intake Time: 
            <select name="intake_time">
                <option value="8am">8 AM</option>
                <option value="2pm">2 PM</option>
                <option value="8pm">8 PM</option>
            </select>
        </label>
        <button type="submit">Filter</button>
    </form>
    <?php
    require '../config/db.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ?route=login');
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $gender = $_POST['gender'] ?? '';
        $age_group = $_POST['age_group'] ?? '';
        $intake_time = $_POST['intake_time'] ?? '8pm';
        $query = "
            SELECT p.name, m.name AS medicine_name
            FROM patients p
            JOIN intakes i ON p.id = i.patient_id
            JOIN medicines m ON i.medicine_id = m.id
            WHERE 1=1
        ";
        $params = [];
        if ($gender) {
            $query .= " AND p.gender = ?";
            $params[] = $gender;
        }
        if ($age_group) {
            $query .= " AND p.age_group = ?";
            $params[] = $age_group;
        }
        $query .= " AND i.intake_time = ?";
        $params[] = $intake_time;
        if ($age_group === 'infant') {
            $query .= " AND m.infant_safe = 1";
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h2>Results</h2>
    <ul>
        <?php if (empty($results)): ?>
            <li>No data available.</li>
        <?php else: ?>
            <?php foreach ($results as $row): ?>
                <li><?php echo htmlspecialchars($row['name']); ?>: <?php echo htmlspecialchars($row['medicine_name']); ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <?php } ?>
    <p><a href="?route=home">Back to Home</a> | <a href="?route=logout">Logout</a></p>
</body>
</html>
