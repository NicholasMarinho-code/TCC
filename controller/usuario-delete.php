<?php
require_once("../config.php");
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Deletar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>
<?php include '../view/navbarU.php' ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Deletar Usuário
                        <a href="../view/Usuarios.php"
                           class="btn btn-danger float-end">
                            Voltar
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $usuario_id = $_GET['id'];
                        try {
                            $sql = $pdo->prepare("
                                SELECT *
                                FROM usuario
                                WHERE id = :id
                            ");
                            $sql->execute([
                                ':id' => $usuario_id
                            ]);
                            $row = $sql->fetch(PDO::FETCH_ASSOC);
                            if ($row) {
                    ?>
                    <form action="../view/acoes.php"
                          method="POST">
                        <input type="hidden"
                               name="delete_usuario"
                               value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">
                                Nome
                            </label>
                            <p class="form-control">
                                <?= htmlspecialchars($row['nome']) ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Email Corporativo
                            </label>
                            <p class="form-control">
                                <?= htmlspecialchars($row['emailcorp']) ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Função
                            </label>
                            <p class="form-control">
                                <?= htmlspecialchars($row['funcao']) ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                    class="btn btn-danger">
                                Deletar Usuário
                            </button>
                        </div>
                    </form>
                    <?php
                            } else {
                                echo "
                                <h5>
                                    Usuário não encontrado.
                                </h5>";
                            }
                        } catch (PDOException $e) {
                            echo "
                            <h5>
                                Erro: {$e->getMessage()}
                            </h5>";
                        }
                    } else {
                        echo "
                        <h5>
                            ID do usuário não informado.
                        </h5>";
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