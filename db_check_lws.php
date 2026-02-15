<?php
// db_check_lws.php — quick diagnostics for LWS MySQL (uses config.php credentials)
require_once __DIR__ . '/config.php';
header('Content-Type: application/json; charset=utf-8');

$checkTables = [
    'admin_sessions','media','messages','reservations','reviews','sessions','settings','slots','users','user_sessions'
];
$result = [
    'connected' => $pdo ? true : false,
    'host' => isset($DB_HOST) ? $DB_HOST : null,
    'database' => isset($DB_NAME) ? $DB_NAME : null,
    'tables' => new stdClass()
];

if (!$pdo) {
    $result['error'] = 'No PDO connection (DB unreachable from this host or credentials invalid).';
    echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit(0);
}

foreach ($checkTables as $t) {
    $info = [ 'exists' => false, 'count' => null, 'columns' => [], 'sample' => null, 'error' => null ];
    try {
        $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
        $stmt->execute([$t]);
        $found = $stmt->fetch();
        if ($found) {
            $info['exists'] = true;
            // count
            $cstmt = $pdo->query("SELECT COUNT(*) AS cnt FROM `" . str_replace('`','', $t) . "`");
            $cnt = $cstmt->fetchColumn();
            $info['count'] = (int)$cnt;
            // columns
            $cols = $pdo->query("DESCRIBE `" . str_replace('`','', $t) . "`")->fetchAll(PDO::FETCH_ASSOC);
            $info['columns'] = array_map(function($r){ return $r['Field']; }, $cols);
            // sample row
            $sample = $pdo->query("SELECT * FROM `" . str_replace('`','', $t) . "` LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            if ($sample) $info['sample'] = $sample;
        }
    } catch (Exception $e) {
        $info['error'] = $e->getMessage();
    }
    $result['tables'][$t] = $info;
}

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
