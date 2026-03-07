<?php
session_start();
require_once("../config.php");
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Dispositivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../view/navbarD.php' ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar Dispositivo
                            <a href="../view/Dispositivos.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $dispositivo_id = mysqli_real_escape_string($conexao, $_GET['id']);
                            $sql = "SELECT * FROM Dispositivo WHERE id = '$dispositivo_id'";
                            $query = mysqli_query($conexao, $sql);

                            if (mysqli_num_rows($query) > 0) {
                                $row = mysqli_fetch_assoc($query);
                        ?>
                                <form action="../view/acoesD.php" method="POST">
                                    <input type="hidden" name="dispositivo_id" value="<?= $row['id'] ?>">

                                    <div class="mb-3">
                                        <label>Nome do Dispositivo</label>
                                        <input type="text" name="nome" value="<?= htmlspecialchars($row['nome']) ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Tipo</label>
                                        <input type="text" name="tipo" value="<?= htmlspecialchars($row['tipo']) ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Localização</label>
                                        <input type="text" name="localizacao" value="<?= htmlspecialchars($row['localizacao']) ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="Ativo" <?= $row['status'] === 'Ativo' ? 'selected' : '' ?>>Ativo</option>
                                            <option value="Inativo" <?= $row['status'] === 'Inativo' ? 'selected' : '' ?>>Inativo</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" name="update_dispositivo" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                        <?php
                            } else {
                                echo "<h5>Dispositivo não encontrado.</h5>";
                            }
                        } else {
                            echo "<h5>ID do dispositivo não informado.</h5>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>