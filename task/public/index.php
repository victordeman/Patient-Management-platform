<?php
session_start();
require_once '../sql/init.php';

$route = $_GET['route'] ?? 'home';

if (!isset($_SESSION['user_id']) && !in_array($route, ['login', 'api'])) {
    $route = 'login';
}

switch ($route) {
    case 'home':
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>TIB Task Application</title>
            <link rel="stylesheet" href="/css/style.css">
        </head>
        <body>
        <header>
            <h1>TIB Task Application</h1>
            <nav>
                <ul>
                    <li><a href="?route=home">Home</a></li>
                    <li><a href="?route=female-adult-8pm">Female Adult (8 PM)</a></li>
                    <li><a href="?route=male-infant-8am">Male Infant (8 AM)</a></li>
                    <li><a href="?route=populate">Add Data</a></li>
                    <li><a href="?route=filter">Filter Patients</a></li>
                    <li><a href="?route=logout">Logout</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section>
                <h2>Welcome</h2>
                <p>This application manages patients and their medication schedules for the TIB Open Source Software Developer position (Nr. 16/2025).</p>
                <p>Use the navigation above to view patient lists, add new data, or filter records dynamically.</p>
            </section>
        </main>
        <footer>
            <p>© 2025 TIB Task Application</p>
        </footer>
        </body>
        </html>
        <?php
        break;
    case 'female-adult-8pm':
        require '../src/controllers/female_adult_8pm.php';
        break;
    case 'male-infant-8am':
        require '../src/controllers/male_infant_8am.php';
        break;
    case 'login':
        require '../src/controllers/login.php';
        break;
    case 'logout':
        require '../src/controllers/logout.php';
        break;
    case 'populate':
        require '../src/controllers/populate.php';
        break;
    case 'filter':
        require '../src/views/filter.php';
        break;
    default:
        http_response_code(404);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>404 Not Found</title>
            <link rel="stylesheet" href="/css/style.css">
        </head>
        <body>
        <header>
            <h1>TIB Task Application</h1>
        </header>
        <main>
            <section>
                <h2>404 Not Found</h2>
                <p>The requested page does not exist.</p>
                <p><a href="?route=home">Return to Home</a></p>
            </section>
        </main>
        <footer>
            <p>© 2025 TIB Task Application</p>
        </footer>
        </body>
        </html>
    <?php
}
?>
