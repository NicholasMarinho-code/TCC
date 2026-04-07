<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/stilo.css">
    <link rel="stylesheet" href="css/botao.css">
</head>
<body>

<header>
    <h1>Home</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="./view/sobre.php">Nossa Equipe</a></li>
        </ul>
    </nav>
    <div>
        <input type="checkbox" class="checkbox" id="chk">

        <label class="label"  for="chk">
        <i class="fas fa-moon"></i>
        <i class="fas fa-sun"></i>
        <div class="ball"></div>
        </label>
    </div>

    <a href="./view/login.php" class="btn-login">Login</a>
</header>

<section class="hero-fridge">
    <div class="hero-fridge-content">
        <h2>Monitoramento e Análise de Temperaturas em Refrigeradores</h2>
        <p>
            Nosso projeto utiliza sensores e processamento de dados para analisar variações de temperatura em sistemas de refrigeração,
            garantindo eficiência, segurança e melhor conservação dos alimentos.
        </p>

        <div class="hero-buttons">
            <a href="view/sobre.php" class="btn-primary">Conheça a Equipe</a>
        </div>
    </div>
</section>

<section class="cards-section">
    <h2>Nossa Solução</h2>

    <div class="cards-container">
        <div class="card">
            <h3>Sensoriamento</h3>
            <p>Captura constante da temperatura interna do refrigerador utilizando sensores precisos.</p>
        </div>

        <div class="card">
            <h3>Análise de Dados</h3>
            <p>Processamento dos valores coletados para identificar variações e possíveis falhas.</p>
        </div>

        <div class="card">
            <h3>Otimização</h3>
            <p>Propostas de melhorias para reduzir consumo energético e aumentar a eficiência do refrigerador.</p>
        </div>
    </div>
</section>

<footer>
    <p>© 2025 - Todos os direitos reservados.</p>
</footer>


    <script src="https://kit.fontawesome.com/878fd54421.js" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
