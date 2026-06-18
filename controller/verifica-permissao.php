<?php

require_once("../config.php");

header('Content-Type: application/json');

if(!isset($_GET['email'])){
    echo json_encode([
        'erro' => 'Email não informado'
    ]);
    exit;
}

$email = $_GET['email'];

$stmt = $pdo->prepare("
SELECT funcao
FROM usuario
WHERE emailcorp = :email
");

$stmt->execute([
    ':email' => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){

    echo json_encode([
        'funcao' => $user['funcao']
    ]);

}else{

    echo json_encode([
        'erro' => 'Usuário não encontrado'
    ]);

}