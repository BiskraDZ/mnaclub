<?php
// reviews_update.php — admin only (e.g. approve)
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
$approved = isset($body['approved']) ? (int)$body['approved'] : null;
if (!$id || $approved === null) { http_response_code(400); echo json_encode(['error'=>'invalid_payload']); exit; }

if (!$pdo) { http_response_code(500); echo json_encode(['error'=>'db_unavailable']); exit; }

try {
    $upd = $pdo->prepare('UPDATE reviews SET approved = ? WHERE id = ?');
    $upd->execute([$approved ? 1 : 0, $id]);
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'db_error']);
}
