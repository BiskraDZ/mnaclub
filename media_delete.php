<?php
// media_delete.php - admin-only endpoint to delete a media file (by id or filename)
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

$targetDir = __DIR__ . '/uploads/gallery';
$ok = false;

// Accept JSON body or form POST
$input = $_POST;
if (empty($input)) {
    $body = file_get_contents('php://input');
    $json = json_decode($body, true);
    if (is_array($json)) $input = $json;
}

$filename = $input['filename'] ?? null;
$id = $input['id'] ?? null;

if ($id && $pdo) {
    try {
        $stmt = $pdo->prepare('SELECT filename FROM gallery WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) $filename = $row['filename'];
    } catch (Exception $e) {
        // ignore
    }
}

if ($filename) {
    $filePath = $targetDir . '/' . basename($filename);
    if (file_exists($filePath)) {
        @unlink($filePath);
        $ok = true;
    }
    if ($pdo) {
        try {
            $del = $pdo->prepare('DELETE FROM gallery WHERE filename = ? OR id = ?');
            $del->execute([$filename, $id ?: 0]);
        } catch (Exception $e) {
            // ignore
        }
    }
}

if ($ok) echo json_encode(['deleted' => true]);
else echo json_encode(['deleted' => false, 'message' => 'file not found']);
