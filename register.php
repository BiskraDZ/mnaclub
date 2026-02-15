<?php
session_start();
require_once __DIR__ . '/config.php';
header('Content-Type: application/json; charset=utf-8');

$input = $_POST; // form-encoded submission from inscription page

$firstName = trim($input['firstName'] ?? '');
$lastName  = trim($input['lastName'] ?? '');
$email     = strtolower(trim($input['email'] ?? ''));
$password  = $input['password'] ?? '';
$phone     = trim($input['phone'] ?? '');
$birthdate = trim($input['birthdate'] ?? '');
$goals     = trim($input['goals'] ?? '');
$newsletter = !empty($input['newsletter']) ? 1 : 0;

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email et mot de passe requis']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email invalide']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe doit avoir au moins 8 caracteres']);
    exit;
}

if (!$pdo) {
    // Fallback for local/dev: return success to allow client-side localStorage usage
    $user = [
        'id' => time(),
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'role' => 'client',
        'createdAt' => date(DATE_ISO8601)
    ];
    echo json_encode(['success' => true, 'user' => $user, 'warning' => 'BDD indisponible — fallback local']);
    exit;
}

try {
    // Check duplicate
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Cet email est deja utilise']);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins = $pdo->prepare('INSERT INTO users (email,password,first_name,last_name,phone,role) VALUES (?,?,?,?,?,?)');
    $ins->execute([$email, $hash, $firstName, $lastName, $phone, 'client']);

    $id = (int)$pdo->lastInsertId();
    $_SESSION['user'] = [
        'id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'role' => 'client',
        'createdAt' => date(DATE_ISO8601)
    ];

    // return user (without password)
    echo json_encode(['success' => true, 'user' => $_SESSION['user']]);
    exit;
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur, reessayez plus tard']);
    exit;
}
