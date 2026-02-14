<?php
// reviews_delete.php — admin only
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$id = isset($body['id']) ? (int)$body['id'] : 0;
if (!$id) { http_response_code(400); echo json_encode(['error'=>'invalid_id']); exit; }

if (!$pdo) { http_response_code(500); echo json_encode(['error'=>'db_unavailable']); exit; }

try {
    $del = $pdo->prepare('DELETE FROM reviews WHERE id = ?');
    $del->execute([$id]);
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db_error']);
}
