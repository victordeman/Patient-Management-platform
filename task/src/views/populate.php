<!DOCTYPE html>
<html>
<head>
    <title>Add Data</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Add Patients, Medicines, and Intakes</h1>
    <?php if (isset($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <h2>Add Patient</h2>
    <form method="POST" action="?route=populate&action=add_patient">
        <label>Name: <input type="text" name="name" required></label>
        <label>Gender: 
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </label>
        <label>Age Group: 
            <select name="age_group" required>
                <option value="infant">Infant</option>
                <option value="adult">Adult</option>
            </select>
        </label>
        <button type="submit">Add Patient</button>
    </form>

    <h2>Add Medicine</h2>
    <form method="POST" action="?route=populate&action=add_medicine">
        <label>Name: <input type="text" name="name" required></label>
        <label>Frequency: 
            <select name="frequency" required>
                <option value="once">Once</option>
                <option value="twice">Twice</option>
                <option value="thrice">Thrice</option>
            </select>
        </label>
        <label>Intake Times: 
            <input type="checkbox" name="intake_times[]" value="8am"> 8 AM
            <input type="checkbox" name="intake_times[]" value="2pm"> 2 PM
            <input type="checkbox" name="intake_times[]" value="8pm"> 8 PM
        </label>
        <label>Infant Safe: 
            <input type="checkbox" name="infant_safe" value="1">
        </label>
        <button type="submit">Add Medicine</button>
    </form>

    <h2>Add Intake</h2>
    <form method="POST" action="?route=populate&action=add_intake">
        <label>Patient: 
            <select name="patient_id" required>
                <?php
                $patients = $pdo->query("SELECT id, name FROM patients")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($patients as $patient) {
                    echo "<option value='{$patient['id']}'>" . htmlspecialchars($patient['name']) . "</option>";
                }
                ?>
            </select>
        </label>
        <label>Medicine: 
            <select name="medicine_id" required>
                <?php
                $medicines = $pdo->query("SELECT id, name FROM medicines")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($medicines as $medicine) {
                    echo "<option value='{$medicine['id']}'>" . htmlspecialchars($medicine['name']) . "</option>";
                }
                ?>
            </select>
        </label>
        <label>Intake Time: 
            <select name="intake_time" required>
                <option value="8am">8 AM</option>
                <option value="2pm">2 PM</option>
                <option value="8pm">8 PM</option>
            </select>
        </label>
        <button type="submit">Add Intake</button>
    </form>
    
    <p><a href="?route=home">Back to Home</a></p>
</body>
</html>
