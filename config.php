<?php
// Database configuration (used by server-side auth)
// NOTE: credentials were provided by you; keep this file private on the server.
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Prefer environment variables (useful when deployed to LWS). Falls back to hard-coded values provided.
$DB_HOST = getenv('DB_HOST') ?: 'mysql26.lwspanel.com';
$DB_PORT = getenv('DB_PORT') ?: 3306;
$DB_NAME = getenv('DB_NAME') ?: 'mnacl2744287';
$DB_USER = getenv('DB_USER') ?: 'mnacl2744287';
$DB_PASS = getenv('DB_PASSWORD') ?: 'qK7*GzDyMAtrs_y';

$pdo = null;
try {
    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Ensure users table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        phone VARCHAR(50),
        role ENUM('client','admin') NOT NULL DEFAULT 'client',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Ensure demo admin exists (will not overwrite existing)
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute(['admin@mnaclub.fr']);
    if (!$stmt->fetch()) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $ins = $pdo->prepare('INSERT INTO users (email,password,first_name,last_name,role) VALUES (?,?,?,?,?)');
        $ins->execute(['admin@mnaclub.fr', $hash, 'Admin', 'MNA', 'admin']);
    }

    // Ensure slots table exists for server-side persistence of créneaux
    $pdo->exec("CREATE TABLE IF NOT EXISTS slots (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kind ENUM('recurring','single') NOT NULL DEFAULT 'recurring',
        day TINYINT NULL,
        date DATE NULL,
        time VARCHAR(16) DEFAULT '18:00',
        capacity INT DEFAULT 10,
        author VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Ensure reviews table exists (store member reviews)
    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) DEFAULT NULL,
        rating TINYINT NOT NULL DEFAULT 5,
        comment TEXT,
        approved TINYINT NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

} catch (PDOException $e) {
    // Leave $pdo as null on failure; pages will fallback to demo/localStorage where handled.
    $pdo = null;
}
