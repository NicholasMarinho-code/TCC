<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe</title>
    <link rel="stylesheet" href="../css/sobre.css">
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
    <div class="carousel-container">
        <img src="../img/DaviDaruix.jpg" class="active">
        <img src="../img/LucasLima.jpg">
        <img src="../img/MelTakeda.jpg">
        <img src="../img/NicMarinho.jpg">
        <img src="../img/pcGOAT.jpg">
    </div>

    <div class="carousel-buttons carousel-buttons-left">
        <button onclick="prev()">‹</button>
    </div>

    <div class="carousel-buttons carousel-buttons-right">
        <button onclick="next()">›</button>
    </div>

    <div class="carousel-indicators">
        <div class="indicator active" onclick="goToSlide(0)"></div>
        <div class="indicator" onclick="goToSlide(1)"></div>
        <div class="indicator" onclick="goToSlide(2)"></div>
        <div class="indicator" onclick="goToSlide(3)"></div>
        <div class="indicator" onclick="goToSlide(4)"></div>
    </div>
</div>

<footer>
    <p>© 2025 - Todos os direitos reservados.</p>
</footer>

<script>
let index = 0;
const images = document.querySelectorAll(".carousel img");
const indicators = document.querySelectorAll(".carousel-indicators .indicator");

function updateCarousel() {
    // Update images
    images.forEach((img, i) => {
        img.classList.remove("active", "prev", "next");
        if (i === index) {
            img.classList.add("active");
        } else if (i === (index - 1 + images.length) % images.length) {
            img.classList.add("prev");
        } else if (i === (index + 1) % images.length) {
            img.classList.add("next");
        }
    });

    indicators.forEach((indicator, i) => {
        indicator.classList.toggle("active", i === index);
    });
}

function showImage(i) {
    index = i;
    updateCarousel();
}

function next() {
    index = (index + 1) % images.length;
    updateCarousel();
}

function prev() {
    index = (index - 1 + images.length) % images.length;
    updateCarousel();
}

function goToSlide(i) {
    index = i;
    updateCarousel();
}

updateCarousel();

setInterval(next, 5000);
</script>

</body>
</html>
