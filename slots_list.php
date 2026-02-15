<?php
// slots_list.php — returns list of slots (public)
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

// If DB available, return DB rows; otherwise return empty array (frontend will fallback to localStorage)
if ($pdo) {
    try {
        $stmt = $pdo->query('SELECT id, kind, day, DATE_FORMAT(date, "%Y-%m-%d") as date, time, capacity, author, created_at FROM slots ORDER BY created_at DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([]);
        exit;
    }
}

// no DB -> empty (frontend uses localStorage fallback)
echo json_encode([]);
