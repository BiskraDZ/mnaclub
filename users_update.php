<?php
// users_update.php — admin-only endpoint to update a user's profile
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['updated' => false, 'message' => 'forbidden']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$id = $body['id'] ?? null;
$first = trim($body['first_name'] ?? ($body['firstName'] ?? ''));
$last = trim($body['last_name'] ?? ($body['lastName'] ?? ''));
$email = trim($body['email'] ?? '');
$phone = trim($body['phone'] ?? '');
$role = in_array(($body['role'] ?? ''), ['admin','client']) ? $body['role'] : 'client';

if (!$id || !$pdo) {
    echo json_encode(['updated' => false, 'message' => 'invalid_request_or_db_unavailable']);
    exit;
}

try {
    // Check email uniqueness if changed
    if ($email) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id <> ?');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) {
            echo json_encode(['updated' => false, 'message' => 'email_taken']);
            exit;
        }
    }

    $upd = $pdo->prepare('UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, role = ? WHERE id = ?');
    $upd->execute([$first, $last, $email, $phone, $role, $id]);

    $stmt = $pdo->prepare('SELECT id, email, first_name, last_name, phone, role, created_at FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['updated' => true, 'user' => $user]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['updated' => false, 'message' => 'db_error']);
}
