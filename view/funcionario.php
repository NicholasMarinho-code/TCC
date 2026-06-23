<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Menu Funcionário</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SEU CSS -->
    <link href="../css/menu.css" rel="stylesheet">
</head>

<body class="bg-zero">

    <div class="container py-5 text-center">

        <h2 class="titulo mb-5">Escolha uma opção</h2>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Usuários</h3>
                    <p>Gerenciar usuários do sistema</p>
                    <a href="TabelaFuncionários.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Dispositivos</h3>
                    <p>Gerenciar dispositivos</p>
                    <a href="DispositivosFuncionario.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Leitura da Temperatura</h3>
                    <p>Ver temperaturas</p>
                    <a href="LeituraFuncionario.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
