<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Adicionar Usuário</title>
    <link href="../css/navbar.css" rel="stylesheet">
    <link href="../css/dispositivos.css" rel="stylesheet">
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
                        Adicionar Usuário
                        <a href="../view/Usuarios.php"
                           class="btn btn-danger float-end">
                            Voltar
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="../view/acoes.php"
                          method="POST">
                        <div class="mb-3">
                            <label class="form-label">
                                Nome
                            </label>
                            <input type="text"
                                   name="nome"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Email Corporativo
                            </label>
                            <input type="email"
                                   name="emailCorp"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Senha
                            </label>
                            <input type="password"
                                   name="senha"
                                   class="form-control"
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Função
                            </label>
                            <select name="funcao"
                                    class="form-control"
                                    required>
                                <option value=""
                                        disabled
                                        selected>
                                    Selecione uma das opções
                                </option>
                                <option value="Funcionario">
                                    Funcionário
                                </option>
                                <option value="Gerente">
                                    Gerente
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit"
                                    name="create_usuario"
                                    class="btn btn-primary">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>