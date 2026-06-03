<?php
session_start();
require_once "../config.php";
// CRIAR USUÁRIO
if (isset($_POST["create_usuario"])) {
    $nome = trim($_POST["nome"]);
    $emailCorp = trim($_POST["emailCorp"]);
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";
    $funcao = trim($_POST["funcao"]);
    if (
        $nome === "" ||
        $emailCorp === "" ||
        $senha === "" ||
        $funcao === ""
    ) {
        $_SESSION["mensagem"] = "Usuário não criado";
        header('location: Usuarios.php');
        exit;
    }
    try {
        $sql = $pdo->prepare("
            INSERT INTO Usuario
            (nome, emailCorp, senha, funcao)
            VALUES
            (:nome, :emailCorp, :senha, :funcao)
        ");
        $sql->execute([
            ':nome' => $nome,
            ':emailCorp' => $emailCorp,
            ':senha' => $senha,
            ':funcao' => $funcao
        ]);
        $_SESSION["mensagem"] = "Usuário criado com sucesso";
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Usuário não foi criado: " . $e->getMessage();
    }
    header('location: Usuarios.php');
    exit;
}
// ATUALIZAR USUÁRIO
if (isset($_POST["update_usuario"])) {
    $usuario_id = $_POST["usuario_id"];
    $nome = trim($_POST["nome"]);
    $emailCorp = trim($_POST["emailCorp"]);
    $senha = trim($_POST["senha"]);
    $funcao = trim($_POST["funcao"]);
    if (
        $nome === "" ||
        $emailCorp === "" ||
        $funcao === ""
    ) {
        $_SESSION["mensagem"] = "Usuário não foi atualizado";
        header('location: Usuarios.php');
        exit;
    }
    try {
        // Atualiza SEM senha
        if ($senha === "") {
            $sql = $pdo->prepare("
                UPDATE Usuario
                SET
                    nome = :nome,
                    emailCorp = :emailCorp,
                    funcao = :funcao
                WHERE id = :id
            ");
            $sql->execute([
                ':nome' => $nome,
                ':emailCorp' => $emailCorp,
                ':funcao' => $funcao,
                ':id' => $usuario_id
            ]);
        }
        // Atualiza COM senha
        else {
            $sql = $pdo->prepare("
                UPDATE Usuario
                SET
                    nome = :nome,
                    emailCorp = :emailCorp,
                    senha = :senha,
                    funcao = :funcao
                WHERE id = :id
            ");
            $sql->execute([
                ':nome' => $nome,
                ':emailCorp' => $emailCorp,
                ':senha' => $senha,
                ':funcao' => $funcao,
                ':id' => $usuario_id
            ]);
        }
        $_SESSION["mensagem"] = "Usuário atualizado com sucesso";
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Usuário não foi atualizado: " . $e->getMessage();
    }
    header('location: Usuarios.php');
    exit;
}
// DELETAR USUÁRIO
if (isset($_POST['delete_usuario'])) {
    $usuario_id = $_POST['delete_usuario'];
    try {
        $sql = $pdo->prepare("
            DELETE FROM Usuario
            WHERE id = :id
        ");
        $sql->execute([
            ':id' => $usuario_id
        ]);
        $_SESSION["mensagem"] = "Usuário deletado com sucesso";
    } catch (PDOException $e) {
        $_SESSION["mensagem"] = "Usuário não foi deletado: " . $e->getMessage();
    }
    header("location: Usuarios.php");
    exit;
}
?>