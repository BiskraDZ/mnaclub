<?php
// users_delete.php — admin-only delete user
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$id = $input['id'] ?? null;
if (!$id || !$pdo) {
    echo json_encode(['deleted' => false, 'message' => 'invalid_request_or_db_unavailable']);
    exit;
}

try {
    // protect demo admin account
    $stmt = $pdo->prepare('SELECT email FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && $row['email'] === 'admin@mnaclub.fr') {
        echo json_encode(['deleted' => false, 'message' => 'cannot_delete_admin']);
        exit;
    }

    $del = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $del->execute([$id]);
    echo json_encode(['deleted' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['deleted' => false, 'message' => 'db_error']);
}
