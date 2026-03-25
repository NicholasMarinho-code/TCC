<?php
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

    <div class="container mt-5">

        <div class="card">

            <div class="card-header">

                <h4>Lista de Dispositivos

                    <a href="../controller/dispositivos-create.php" class="btn btn-primary float-end">
                        Adicionar Dispositivo
                    </a>

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

                        $sql = "SELECT * FROM Dispositivo";
                        $query = mysqli_query($conexao, $sql);

                        while ($row = mysqli_fetch_assoc($query)) {

                            ?>

                            <tr>

                                <td><?= $row['id'] ?></td>
                                <td><?= $row['nome'] ?></td>
                                <td><?= $row['tipo'] ?></td>
                                <td><?= $row['localizacao'] ?></td>
                                <td><?= $row['status'] ?></td>

                                <td>

                                    <a href="dispositivo-read.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                                        Visualizar
                                    </a>

                                    <a href="dispositivo-update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <a href="../controller/dispositivo-delete.php?id=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja deletar?')">

                                        Deletar

                                    </a>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>