<?php

require_once("../config.php");

header('Content-Type: application/json');

$email = $_GET['email'] ?? '';

$stmt = $pdo->prepare("
SELECT *
FROM usuario
WHERE LOWER(emailcorp) = LOWER(:email)
");

$stmt->execute([
    ':email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'funcao' => $user['funcao'] ?? null
]);