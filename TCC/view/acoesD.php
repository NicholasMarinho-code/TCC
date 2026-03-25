<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
require_once("../config.php");

// Criar dispositivo
if (isset($_POST["create_dispositivo"])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $tipo = mysqli_real_escape_string($conexao, trim($_POST["tipo"]));
    $localizacao = mysqli_real_escape_string($conexao, trim($_POST["localizacao"]));
    $status = mysqli_real_escape_string($conexao, trim($_POST["status"]));

    if ($nome === "" || $tipo === "" || $localizacao === "" || $status === "") {
        $_SESSION["mensagem"] = "Dispositivo não criado. Preencha todos os campos.";
        header('location: ../view/Dispositivos.php');
        exit;
    }

    $sql = "INSERT INTO Dispositivo (nome, tipo, localizacao, status) 
            VALUES ('$nome', '$tipo', '$localizacao', '$status')";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION["mensagem"] = "Dispositivo criado com sucesso.";
    } else {
        $_SESSION["mensagem"] = "Erro ao criar dispositivo.";
    }
    header('location: ../view/Dispositivos.php');
    exit;
}

// Atualizar dispositivo
if (isset($_POST["update_dispositivo"])) {
    $dispositivo_id = mysqli_real_escape_string($conexao, $_POST["dispositivo_id"]);
    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $tipo = mysqli_real_escape_string($conexao, trim($_POST["tipo"]));
    $localizacao = mysqli_real_escape_string($conexao, trim($_POST["localizacao"]));
    $status = mysqli_real_escape_string($conexao, trim($_POST["status"]));

    if ($nome === "" || $tipo === "" || $localizacao === "" || $status === "") {
        $_SESSION["mensagem"] = "Dispositivo não atualizado. Preencha todos os campos.";
        header('location: ../view/Dispositivos.php');
        exit;
    }

    $sql = "UPDATE Dispositivo 
            SET nome = '$nome', tipo = '$tipo', localizacao = '$localizacao', status = '$status'
            WHERE id = '$dispositivo_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION["mensagem"] = "Dispositivo atualizado com sucesso.";
    } else {
        $_SESSION["mensagem"] = "Erro ao atualizar dispositivo.";
    }
    header('location: ../view/Dispositivos.php');
    exit;
}

// Deletar dispositivo
if (isset($_POST["delete_dispositivo"])) {
    $dispositivo_id = mysqli_real_escape_string($conexao, $_POST["delete_dispositivo"]);

    $sql = "DELETE FROM Dispositivo WHERE id = '$dispositivo_id'";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION["mensagem"] = "Dispositivo deletado com sucesso.";
    } else {
        $_SESSION["mensagem"] = "Erro ao deletar dispositivo.";
    }
    header('location: ../view/Dispositivos.php');
    exit;
}
?>