<?php
// slots_update.php — admin-only update
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
if (!$id || !$pdo) { echo json_encode(['updated'=>false,'message'=>'invalid']); exit; }

$fields = [];
$params = [];
if (isset($body['time'])) { $fields[] = 'time = ?'; $params[] = $body['time']; }
if (isset($body['capacity'])) { $fields[] = 'capacity = ?'; $params[] = (int)$body['capacity']; }
if (isset($body['day'])) { $fields[] = 'day = ?'; $params[] = (int)$body['day']; }
if (isset($body['date'])) { $fields[] = 'date = ?'; $params[] = $body['date']; }
if (count($fields) === 0) { echo json_encode(['updated'=>false,'message'=>'no_fields']); exit; }
$params[] = $id;

try {
    $sql = 'UPDATE slots SET ' . implode(', ', $fields) . ' WHERE id = ?';
    $upd = $pdo->prepare($sql);
    $upd->execute($params);
    echo json_encode(['updated'=>true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['updated'=>false,'message'=>'db_error']);
}
