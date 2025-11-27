<?php
$host = '127.0.0.1';
$dbname = 'Umidade';
$usuario = 'root'; 
$senha = '1234';       


$conexao = mysqli_connect($host, $usuario, $senha, $dbname) or die ("Não foi possível conectar");
?>