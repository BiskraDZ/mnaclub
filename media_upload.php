<?php
// media_upload.php - admin-only endpoint to upload media files to uploads/gallery and (optionally) the DB
header('Content-Type: application/json; charset=utf-8');
if (session_status() == PHP_SESSION_NONE) { @session_start(); }
require_once __DIR__ . '/config.php';

// Simple admin check
if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}

$targetDir = __DIR__ . '/uploads/gallery';
if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

$allowedExt = ['jpg','jpeg','png','gif','webp','mp4','webm','ogg'];
$uploaded = [];

// Normalize incoming files (support 'files[]' or single 'file')
$files = [];
if (!empty($_FILES['files'])) {
    $files = [];
    foreach ($_FILES['files']['name'] as $i => $name) {
        $files[] = [
            'name' => $_FILES['files']['name'][$i],
            'tmp'  => $_FILES['files']['tmp_name'][$i],
            'error'=> $_FILES['files']['error'][$i],
            'size' => $_FILES['files']['size'][$i],
            'type' => $_FILES['files']['type'][$i]
        ];
    }
} elseif (!empty($_FILES['file'])) {
    $f = $_FILES['file'];
    $files[] = ['name'=>$f['name'],'tmp'=>$f['tmp_name'],'error'=>$f['error'],'size'=>$f['size'],'type'=>$f['type']];
}

if (empty($files)) {
    http_response_code(400);
    echo json_encode(['error' => 'no_file']);
    exit;
}

foreach ($files as $f) {
    if ($f['error'] !== UPLOAD_ERR_OK) continue;
    if ($f['size'] > 25 * 1024 * 1024) continue; // 25MB limit

    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) continue;

    $safeName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest = $targetDir . '/' . $safeName;

    if (!move_uploaded_file($f['tmp'], $dest)) continue;

    $isVideo = in_array($ext, ['mp4','webm','ogg']) ? 1 : 0;
    $type = $_POST['type'] ?? ($_POST['category'] ?? 'training');
    $title = trim($_POST['title'] ?? pathinfo($f['name'], PATHINFO_FILENAME));

    $rowId = null;
    if ($pdo) {
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS gallery (
                id INT AUTO_INCREMENT PRIMARY KEY,
                filename VARCHAR(255) NOT NULL,
                original_name VARCHAR(255),
                type VARCHAR(50) DEFAULT 'training',
                is_video TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $ins = $pdo->prepare('INSERT INTO gallery (filename, original_name, type, is_video) VALUES (?, ?, ?, ?)');
            $ins->execute([$safeName, $f['name'], $type, $isVideo]);
            $rowId = $pdo->lastInsertId();
        } catch (Exception $e) {
            // ignore DB errors, file is still uploaded
        }
    }

    $uploaded[] = [
        'id' => $rowId ?: (time() + rand(1,9999)),
        'filename' => $safeName,
        'originalName' => $f['name'],
        'path' => 'uploads/gallery/' . $safeName,
        'type' => $type,
        'is_video' => $isVideo,
    ];
}

if (empty($uploaded)) {
    http_response_code(500);
    echo json_encode(['error' => 'upload_failed']);
    exit;
}

echo json_encode(['uploaded' => $uploaded]);
