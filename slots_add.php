<?php
// slots_add.php — admin-only endpoint to add a slot
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$kind = ($body['kind'] ?? $body['type'] ?? 'recurring');
$day = isset($body['day']) ? (int)$body['day'] : null;
$date = $body['date'] ?? null;
$time = $body['time'] ?? ($body['start'] ?? '18:00');
$capacity = isset($body['capacity']) ? (int)$body['capacity'] : (int)($body['max'] ?? 10);
$author = $_SESSION['user']['email'] ?? 'admin';

if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'db_unavailable']);
    exit;
}

try {
    $ins = $pdo->prepare('INSERT INTO slots (kind, day, date, time, capacity, author) VALUES (?, ?, ?, ?, ?, ?)');
    $ins->execute([$kind, $day ?: null, $date ?: null, $time, $capacity, $author]);
    $id = (int)$pdo->lastInsertId();
    echo json_encode(['id' => $id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db_error']);
}