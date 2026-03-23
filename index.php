<?php
require 'db.php';
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>IT profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="?page=home">Domů</a>
        <a href="?page=interests">Zájmy</a>
        <a href="?page=skills">Dovednosti</a>
    </nav>
    <main>
        <?php
        switch ($page) {
            case 'home':
                require 'pages/home.php';
                break;
            case 'interests':
                require 'pages/interests.php';
                break;
            case 'skills':
                require 'pages/skills.php';
                break;
            default:
                require 'pages/not_found.php';
                break;
        }
        ?>
    </main>
</body>
</html>