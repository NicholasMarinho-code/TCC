<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe</title>
    <link rel="stylesheet" href="../stilo.css">
</head>
<body>

<header>
    <h1>Nossa Equipe</h1>
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="sobre.php">Nossa Equipe</a></li>
        </ul>
    </nav>
    <a href="login.php" class="btn-login">Login / Cadastro</a>
</header>

<section style="padding: 40px; text-align: center;">
    <h2>Equipe do Projeto</h2>
    <p>Conheça os integrantes:</p>
</section>

<div class="carousel">
    <img src="../img/images.webp" class="active">
    <img src="../img/SOAD.webp">
    <img src="../img/RHCP.webp">
    <img src="../img/Nir.webp">

    <div class="carousel-buttons">
        <button onclick="prev()">‹</button>
        <button onclick="next()">›</button>
    </div>
</div>

<footer>
    © 2025 - Todos os direitos reservados.
</footer>

<script>
let index = 0;
const images = document.querySelectorAll(".carousel img");

function showImage(i) {
    images.forEach(img => img.classList.remove("active"));
    images[i].classList.add("active");
}

function next() {
    index = (index + 1) % images.length;
    showImage(index);
}

function prev() {
    index = (index - 1 + images.length) % images.length;
    showImage(index);
}

setInterval(next, 4000);
</script>

</body>
</html>
