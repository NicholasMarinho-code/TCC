<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("../config.php");
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Dispositivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <link href="../css/dispositivos.css" rel="stylesheet">
</head>
<body>
<?php include 'navbarFuncionario.php' ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>
                Lista de Dispositivos
            </h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Localização</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $sql = "SELECT * FROM Dispositivo";
                        $query = $pdo->query($sql);
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nome'] ?></td>
                            <td><?= $row['tipo'] ?></td>
                            <td><?= $row['localizacao'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <a href="../controller/DispositivoFuncionario-read.php?id=<?= $row['id'] ?>"
                                   class="btn btn-info btn-sm">
                                    Visualizar
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    } catch (PDOException $e) {
                        echo "
                        <tr>
                            <td colspan='6'>
                                Erro: {$e->getMessage()}
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>