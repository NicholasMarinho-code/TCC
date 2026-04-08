<?php
$host = '127.0.0.1';
$dbname = 'Umidade';
$usuario = 'root';
$senha = '';

$conexao = mysqli_connect($host, $usuario, $senha, $dbname);
if (!$conexao) {
    die('Erro de conexão (' . mysqli_connect_errno() . '): ' . mysqli_connect_error());
}
?>