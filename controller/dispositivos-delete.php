<?php
require_once("../config.php");
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Deletar Dispositivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>
<?php include '../view/navbarD.php' ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Deletar Dispositivo
                        <a href="../view/Dispositivos.php"
                           class="btn btn-danger float-end">
                            Voltar
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $dispositivo_id = $_GET['id'];
                        try {
                            $sql = $pdo->prepare("
                                SELECT *
                                FROM Dispositivo
                                WHERE id = :id
                            ");
                            $sql->execute([
                                ':id' => $dispositivo_id
                            ]);
                            $row = $sql->fetch(PDO::FETCH_ASSOC);
                            if ($row) {
                    ?>
                    <form action="../view/acoesD.php"
                          method="POST">
                        <input type="hidden"
                               name="delete_dispositivo"
                               value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">
                                Nome
                            </label>
                            <p class="form-control">
                                <?= $row['nome']; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Tipo
                            </label>
                            <p class="form-control">
                                <?= $row['tipo']; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Localização
                            </label>
                            <p class="form-control">
                                <?= $row['localizacao']; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Status
                            </label>
                            <p class="form-control">
                                <?= $row['status']; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                    class="btn btn-danger">
                                Deletar Dispositivo
                            </button>
                        </div>
                    </form>
                    <?php
                            } else {
                                echo '
                                <h5>
                                    Nenhum dispositivo encontrado
                                </h5>';
                            }
                        } catch (PDOException $e) {
                            echo '
                            <h5>
                                Erro: ' . $e->getMessage() . '
                            </h5>';
                        }
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