<?php
// db.php
try {
    $pdo = new PDO('sqlite:interests.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS interests (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL
    )");
} catch (PDOException $e) {
    die("Chyba databáze: " . $e->getMessage());
}
?>