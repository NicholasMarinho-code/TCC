<?php
require_once("../config.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relação Usuário - Dispositivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <link href="../css/relacao.css" rel="stylesheet">
</head>
<body>
<?php include '../view/navbar.php'; ?>

<div class="container mt-5">
    <h3>Relação Usuário - Dispositivo</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Dispositivo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT u.nome AS usuario, d.nome AS dispositivo 
                    FROM Usuario_Dispositivo ud
                    JOIN Usuario u ON ud.usuario_id = u.id
                    JOIN Dispositivo d ON ud.dispositivo_id = d.id
                    ORDER BY u.nome";
            $query = mysqli_query($conexao, $sql);

            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr><td>{$row['usuario']}</td><td>{$row['dispositivo']}</td></tr>";
            }
            ?>
        </tbody>
    </table>
     <a href="menu.php"><button type="button" class="btn btn-danger">Voltar</button></a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>