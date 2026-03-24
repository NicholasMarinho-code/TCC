<?php
require_once("../config.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Vincular Usuário e Dispositivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../view/navbar.php'; ?>

<div class="container mt-5">
    <h3>Vincular Usuário a Dispositivo</h3>

    <form action="acoesVinculo.php" method="POST">
        <div class="mb-3">
            <label>Usuário</label>
            <select name="usuario_id" class="form-control" required>
                <option value="" disabled selected>Selecione um usuário</option>
                <?php
                $usuarios = mysqli_query($conexao, "SELECT id, nome FROM Usuario");
                while ($u = mysqli_fetch_assoc($usuarios)) {
                    echo "<option value='{$u['id']}'>{$u['nome']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Dispositivo</label>
            <select name="dispositivo_id" class="form-control" required>
                <option value="" disabled selected>Selecione um dispositivo</option>
                <?php
                $dispositivos = mysqli_query($conexao, "SELECT id, nome FROM Dispositivo");
                while ($d = mysqli_fetch_assoc($dispositivos)) {
                    echo "<option value='{$d['id']}'>{$d['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="vincular" class="btn btn-primary">Vincular</button>
        <a href="menu.php"><button type="button" class="btn btn-danger">Voltar</button></a>
    </form>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>