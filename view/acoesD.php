<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once("../config.php");
// CRIAR DISPOSITIVO
if (isset($_POST["create_dispositivo"])) {
    $nome = trim($_POST["nome"]);
    $tipo = trim($_POST["tipo"]);
    $localizacao = trim($_POST["localizacao"]);
    $status = trim($_POST["status"]);
    if (
        $nome === "" ||
        $tipo === "" ||
        $localizacao === "" ||
        $status === ""
    ) {
        $_SESSION["mensagem"] = "Dispositivo não criado. Preencha todos os campos.";
        header('location: ../view/Dispositivos.php');
        exit;
    }
    try {
        $sql = $pdo->prepare("
            INSERT INTO Dispositivo
            (nome, tipo, localizacao, status)
            VALUES
            (:nome, :tipo, :localizacao, :status)
        ");
        $sql->execute([
            ':nome' => $nome,
            ':tipo' => $tipo,
            ':localizacao' => $localizacao,
            ':status' => $status
        ]);
        $_SESSION["mensagem"] = "Dispositivo criado com sucesso.";
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Erro ao criar dispositivo: " . $e->getMessage();
    }
    header('location: ../view/Dispositivos.php');
    exit;
}
// ATUALIZAR DISPOSITIVO
if (isset($_POST["update_dispositivo"])) {
    $dispositivo_id = $_POST["dispositivo_id"];
    $nome = trim($_POST["nome"]);
    $tipo = trim($_POST["tipo"]);
    $localizacao = trim($_POST["localizacao"]);
    $status = trim($_POST["status"]);
    if (
        $nome === "" ||
        $tipo === "" ||
        $localizacao === "" ||
        $status === ""
    ) {
        $_SESSION["mensagem"] = "Dispositivo não atualizado. Preencha todos os campos.";
        header('location: ../view/Dispositivos.php');
        exit;
    }
    try {
        $sql = $pdo->prepare("
            UPDATE Dispositivo
            SET
                nome = :nome,
                tipo = :tipo,
                localizacao = :localizacao,
                status = :status
            WHERE id = :id
        ");
        $sql->execute([
            ':nome' => $nome,
            ':tipo' => $tipo,
            ':localizacao' => $localizacao,
            ':status' => $status,
            ':id' => $dispositivo_id
        ]);
        $_SESSION["mensagem"] = "Dispositivo atualizado com sucesso.";
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Erro ao atualizar dispositivo: " . $e->getMessage();
    }
    header('location: ../view/Dispositivos.php');
    exit;
}
// DELETAR DISPOSITIVO
if (isset($_POST["delete_dispositivo"])) {
    $dispositivo_id = $_POST["delete_dispositivo"];
    try {
        $sql = $pdo->prepare("
            DELETE FROM Dispositivo
            WHERE id = :id
        ");
        $sql->execute([
            ':id' => $dispositivo_id
        ]);
        $_SESSION["mensagem"] = "Dispositivo deletado com sucesso.";
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Erro ao deletar dispositivo: " . $e->getMessage();
    }
    header('location: ../view/Dispositivos.php');
    exit;
}
?>