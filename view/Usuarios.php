<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  session_start();
  require_once("../config.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/navbar.css" rel="stylesheet">
    <link href="../css/usuarios.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'navbar.php' ?>
  <div class="container mt-4">
    <?php include('mensagem.php'); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Lista de Usuários
              <a href="../controller/usuario-create.php" class="btn btn-primary float-end">Adicionar usuário</a> 
            </h4>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nome</th>
                  <th>Email Corporativo</th>
                  <th>Função</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
            <?php 
            try {
                $sql = 'SELECT * FROM "Usuario" ORDER BY id ASC';
                $usuarios = $pdo->query($sql);

                if($usuarios->rowCount() > 0){
                    while($row = $usuarios->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['nome'] ?></td>
              <td><?= $row['emailcorp'] ?></td>
              <td><?= $row['funcao'] ?></td>
              <td>
                <a href="../controller/usuario-read.php?id=<?=$row['id']?>" class="btn btn-secondary btn-sm">Visualizar</a>
                <a href="../controller/usuario-update.php?id=<?=$row['id']?>" class="btn btn-success btn-sm">Editar</a>

                <form action="acoes.php" method="POST" class="d-inline">
                    <button onclick="return confirm('Tem certeza que deseja excluir esse usuário?')" type="submit" name="delete_usuario" value="<?= $row['id'] ?>" class="btn btn-danger btn-sm">Excluir</button>
                </form>
              </td>
            </tr>
          <?php 
                    }
                } else {
                    echo '<tr><td colspan="6"><h5>Nenhum usuário encontrado</h5></td></tr>';
                }
            } catch (PDOException $e) {
                echo '<tr><td colspan="6"><h5 class="text-danger">Erro ao conectar ao banco: ' . $e->getMessage() . '</h5></td></tr>';
            }
          ?>
      </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>