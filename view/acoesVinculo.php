<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);
    $dispositivo_id = mysqli_real_escape_string($conexao, $_POST['dispositivo_id']);

    $check = mysqli_query($conexao, "SELECT * FROM Usuario_Dispositivo WHERE usuario_id='$usuario_id' AND dispositivo_id='$dispositivo_id'");
    
    if (mysqli_num_rows($check) > 0) {
        $_SESSION['mensagem'] = "Este vínculo já existe!";
    } else {
        $sql = "INSERT INTO Usuario_Dispositivo (usuario_id, dispositivo_id) 
                VALUES ('$usuario_id', '$dispositivo_id')";
        mysqli_query($conexao, $sql);
        $_SESSION['mensagem'] = "Vínculo criado com sucesso!";
    }

    header("Location: vincular.php");
    exit;
}
?>