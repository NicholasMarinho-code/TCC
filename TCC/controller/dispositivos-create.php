<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adicionar Dispositivo</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <?php include '../view/navbarD.php' ?>

  <div class="container mt-5">

    <div class="row">
      <div class="col-md-12">

        <div class="card">

          <div class="card-header">
            <h4>Adicionar Dispositivo
              <a href="../view/Dispositivos.php" class="btn btn-danger float-end">
                Voltar
              </a>
            </h4>
          </div>

          <div class="card-body">

            <form action="../view/acoesD.php" method="POST">

              <div class="mb-3">

                <label>Nome do Dispositivo</label>
                <input type="text" name="nome" class="form-control">

                <label>Tipo</label>
                <input type="text" name="tipo" class="form-control">

                <label>Localização</label>
                <input type="text" name="localizacao" class="form-control">

                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="" disabled selected>Selecione</option>
                  <option value="Ativo">Ativo</option>
                  <option value="Inativo">Inativo</option>
                </select>

              </div>

              <div class="mb-3">
                <button type="submit" name="create_dispositivo" class="btn btn-primary">
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