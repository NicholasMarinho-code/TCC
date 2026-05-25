<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_POST['usuario_id'];
    $dispositivo_id = $_POST['dispositivo_id'];
    try {
        // Verifica se já existe vínculo
        $check = $pdo->prepare("
            SELECT *
            FROM Usuario_Dispositivo
            WHERE usuario_id = :usuario_id
            AND dispositivo_id = :dispositivo_id
        ");
        $check->execute([
            ':usuario_id' => $usuario_id,
            ':dispositivo_id' => $dispositivo_id
        ]);
        if ($check->rowCount() > 0) {
            $_SESSION['mensagem'] = "Este vínculo já existe!";
        } else {
            // Insere vínculo
            $sql = $pdo->prepare("
                INSERT INTO Usuario_Dispositivo
                (usuario_id, dispositivo_id)
                VALUES
                (:usuario_id, :dispositivo_id)
            ");
            $sql->execute([
                ':usuario_id' => $usuario_id,
                ':dispositivo_id' => $dispositivo_id
            ]);
            $_SESSION['mensagem'] = "Vínculo criado com sucesso!";
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro: " . $e->getMessage();
    }
    header("Location: vincular.php");
    exit;
}
?>