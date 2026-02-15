<?php
// slots_delete.php — admin-only delete
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$id = $body['id'] ?? null;
if (!$id || !$pdo) { echo json_encode(['deleted'=>false,'message'=>'invalid']); exit; }

try {
    $del = $pdo->prepare('DELETE FROM slots WHERE id = ?');
    $del->execute([$id]);
    echo json_encode(['deleted'=>true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['deleted'=>false,'message'=>'db_error']);
}
