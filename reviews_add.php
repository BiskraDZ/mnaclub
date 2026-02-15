<?php
// reviews_add.php — add a new review (public submission)
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

$body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$name = trim($body['name'] ?? '');
$rating = isset($body['rating']) ? (int)$body['rating'] : 5;
$comment = trim($body['comment'] ?? '');

if ($rating < 1 || $rating > 5 || $comment === '') {
    http_response_code(400);
    echo json_encode(['error' => 'invalid_payload']);
    exit;
}

// default: unapproved for public submissions; admins can auto-approve
$approved = (!empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin') ? 1 : 0;

if (!$pdo) {
    http_response_code(500);
    echo json_encode(['error' => 'db_unavailable']);
    exit;
}

try {
    $ins = $pdo->prepare('INSERT INTO reviews (name, rating, comment, approved) VALUES (?, ?, ?, ?)');
    $ins->execute([$name ?: null, $rating, $comment, $approved]);
    $id = (int)$pdo->lastInsertId();

    $stmt = $pdo->prepare('SELECT id, name, rating, comment, approved, DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") AS created_at FROM reviews WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($row ?: ['id' => $id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db_error']);
}
