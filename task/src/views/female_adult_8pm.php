<!DOCTYPE html>
<html>
<head>
    <title>Female Adult Patients (8 PM)</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Female Adult Patients (8 PM Medications)</h1>
    <ul>
        <?php if (empty($results)): ?>
            <li>No data available.</li>
        <?php else: ?>
            <?php foreach ($results as $row): ?>
                <li><?php echo htmlspecialchars($row['name']); ?>: <?php echo htmlspecialchars($row['medicine_name']); ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <p><a href="?route=home">Back to Home</a> | <a href="?route=logout">Logout</a></p>
</body>
</html>
