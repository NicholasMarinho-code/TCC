<?php
session_start();
require_once("../config.php");
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Editar Usuário</title>
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
                        Editar Usuário
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
                               name="usuario_id"
                               value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">
                                Nome
                            </label>
                            <input type="text"
                                   name="nome"
                                   value="<?= htmlspecialchars($row['nome']) ?>"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Email Corporativo
                            </label>
                            <input type="email"
                                   name="emailCorp"
                                   value="<?= htmlspecialchars($row['emailcorp']) ?>"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Senha (deixe vazio para manter a atual)
                            </label>
                            <input type="password"
                                   name="senha"
                                   class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Função
                            </label>
                            <select name="funcao"
                                    class="form-control"
                                    required>
                                <option value="Funcionario"
                                    <?= $row['funcao'] === "Funcionario" ? "selected" : "" ?>>
                                    Funcionário
                                </option>
                                <option value="Gerente"
                                    <?= $row['funcao'] === "Gerente" ? "selected" : "" ?>>
                                    Gerente
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                    name="update_usuario"
                                    class="btn btn-primary">
                                Salvar
                            </button>
                        </div>
                    </form>
                    <?php
                            } else {
                                echo '
                                <h5>
                                    Nenhum usuário encontrado
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