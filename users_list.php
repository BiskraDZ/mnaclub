<?php
// users_list.php — return all users (admin-only)
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

if (!$pdo) {
    // DB unavailable (dev fallback)
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->query('SELECT id, email, first_name, last_name, phone, role, created_at FROM users ORDER BY created_at DESC');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db_error']);
}
