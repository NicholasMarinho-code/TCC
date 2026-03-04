<?php
  session_start();
  require_once("../config.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <?php include'navbar.php'?>
  <div class="container mt-4">
    <?php
      include('mensagem.php');
    ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4>Lista de Usuários
              <a href="../controller/usuario-create.php" class="btn btn-primary float-end">Adcionar usuário</a> 
            </h4>
          </div>
          <div class="card-body">
            <table class = "table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Nome</th>
                  <th>Email Corporativo</th>
                  <th>Senha</th>
                  <th>Função</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
            <?php 
            $sql = "SELECT * FROM Usuario";
            $Usuario = mysqli_query($conexao, $sql);

            if(mysqli_num_rows($Usuario) > 0){
            while($row = mysqli_fetch_assoc($Usuario)){
            ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['nome'] ?></td>
              <td><?= $row['emailCorp'] ?></td>
              <td><?= $row['senha'] ?></td>
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
            echo '<tr><td colspan="6"><h5>Nenhum usuario encontrado</h5></td></tr>';
        }
          ?>
      </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>