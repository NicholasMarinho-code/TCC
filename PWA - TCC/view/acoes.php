<?php 
session_start();
require_once "../config.php";

if (isset($_POST["create_usuario"])) {

    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $emailCorp = mysqli_real_escape_string($conexao, trim($_POST["emailCorp"]));
    $senha = isset($_POST["senha"]) ? mysqli_real_escape_string($conexao, trim($_POST["senha"])) : "";
    $funcao = mysqli_real_escape_string($conexao, trim($_POST["funcao"]));

    if ($nome === "" || $emailCorp === "" || $senha === "" || $funcao === "") {
        $_SESSION["mensagem"] = "Usuário não criado";
        header('location: Usuarios.php');
        exit;
    }

    $sql = "INSERT INTO Usuario (nome, emailCorp, senha, funcao) 
            VALUES ('$nome', '$emailCorp', '$senha', '$funcao')";

    mysqli_query($conexao, $sql);

    if(mysqli_affected_rows($conexao) > 0) {
        $_SESSION["mensagem"] = "Usuário criado com sucesso";
        header('location: Usuarios.php');
        exit;
    } else {
        $_SESSION["mensagem"] = "Usuário não foi criado";
        header('location: Usuarios.php');
        exit;
    }
}

if (isset($_POST["update_usuario"])) {

    $usuario_id = mysqli_real_escape_string($conexao, $_POST["usuario_id"]);

    $nome = mysqli_real_escape_string($conexao, trim($_POST["nome"]));
    $emailCorp = mysqli_real_escape_string($conexao, trim($_POST["emailCorp"]));
    $senha = mysqli_real_escape_string($conexao, trim($_POST["senha"]));
    $funcao = mysqli_real_escape_string($conexao, trim($_POST["funcao"]));

    if ($nome == "" || $emailCorp == "" || $funcao == "") {
        $_SESSION["mensagem"] = "Usuário não foi atualizado";
        header('location: Usuarios.php');
        exit;
    }

    if ($senha === "") {
        $sql = "UPDATE Usuario 
                SET nome = '$nome', emailCorp = '$emailCorp', funcao = '$funcao'
                WHERE id = '$usuario_id'";
    } else {
        $sql = "UPDATE Usuario 
                SET nome = '$nome', emailCorp = '$emailCorp', senha = '$senha', funcao = '$funcao'
                WHERE id = '$usuario_id'";
    }

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION["mensagem"] = "Usuário atualizado com sucesso";
        header('location: Usuarios.php');
        exit;
    } else {
        $_SESSION["mensagem"] = "Usuário não foi atualizado";
        header('location: Usuarios.php');
        exit;
    }
}

if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string( $conexao, $_POST['delete_usuario']);
    
    $sql = "DELETE FROM Usuario WHERE id = '$usuario_id' ";

    mysqli_query( $conexao, $sql);

    if (mysqli_affected_rows($conexao)  > 0) {  
     $_SESSION["mensagem"] = "Usuario deletado com sucesso";
     header("location: Usuarios.php");
    } else {
        $_SESSION["mensagem"] = "Usuario não foi deletado";
     header("location: Usuarios.php");
    }
}

?>