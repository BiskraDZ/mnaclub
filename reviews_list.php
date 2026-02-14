<?php
// reviews_list.php — return reviews (public: only approved; admin: all)
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

// If DB unavailable -> return empty array (client has localStorage fallback)
if (!$pdo) {
    echo json_encode([]);
    exit;
}

try {
    if (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin') {
        $stmt = $pdo->query('SELECT id, name, rating, comment, approved, DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") AS created_at FROM reviews ORDER BY created_at DESC');
    } else {
        $stmt = $pdo->prepare('SELECT id, name, rating, comment, approved, DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") AS created_at FROM reviews WHERE approved = 1 ORDER BY created_at DESC');
        $stmt->execute();
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db_error']);
}
