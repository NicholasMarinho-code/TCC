<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Monitor de Temperatura</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/navbar.css" rel="stylesheet">
<link rel="stylesheet" href="../css/leitura.css">
</head>
<body>

<?php include 'navbar.php' ?>

<div class="container">

  <header>
    <div class="header-left">
      <h1>Sistema de monitoramento</h1>
      <h2>DE TEMPERATURAS</h2>
    </div>
    <div class="header-right">
      <div><span class="status-dot"></span><span class="status-text">AO VIVO</span></div>
      <div class="update-time" id="update-time">aguardando...</div>
    </div>
  </header>

  <div class="error-msg" id="error-msg"></div>

  <div class="section-title">Dispositivos ativos</div>
  <div class="devices-grid" id="devices-grid">
    <div class="loading">Carregando dispositivos...</div>
  </div>

  <div class="table-toggle-wrapper">
    <div class="section-title" style="margin-bottom:0">Últimas leituras</div>
    <button id="btn-toggle" onclick="toggleTabela()">MOSTRAR TEMPERATURAS</button>
  </div>
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>#ID</th>
          <th>Dispositivo</th>
          <th>Temperatura</th>
          <th>Status</th>
          <th>Data / Hora</th>
        </tr>
      </thead>
      <tbody id="tabela-body">
        <tr><td colspan="5" class="loading">Carregando...</td></tr>
      </tbody>
    </table>
  </div>

</div>

<script>
  const API_URL = 'api_temperatura.php';
  const INTERVALO_MS = 2000;
  
  function classeTempByValue(t) {
    if (t >= 60) return 'hot';
    if (t >= 40) return 'warm';
    if (t < 10)  return 'cold';
    return 'normal';
  }

  function labelTemp(t) {
    if (t >= 60) return 'Temperatura crítica';
    if (t >= 40) return 'Temperatura elevada';
    if (t < 10)  return 'Temperatura baixa';
    return 'Normal';
  }

  function badgeTemp(t) {
    const cls = classeTempByValue(t);
    const label = labelTemp(t);
    return `<span class="badge badge-${cls}">${label}</span>`;
  }

  function barPercent(t) {
    return Math.min(100, Math.max(0, ((t + 20) / 120) * 100)).toFixed(1);
  }

  function formatarData(str) {
    const d = new Date(str);
    if (isNaN(d)) return str;
    return d.toLocaleString('pt-BR', {
      day: '2-digit', month: '2-digit', year: 'numeric',
      hour: '2-digit', minute: '2-digit', second: '2-digit'
    });
  }

  function agruparPorDispositivo(dados) {
    const mapa = {};
    dados.forEach(linha => {
      const id = linha.dispositivo_id;
      if (!mapa[id] || new Date(linha.data_hora) > new Date(mapa[id].data_hora)) {
        mapa[id] = linha;
      }
    });
    return Object.values(mapa);
  }

  function renderCards(dados) {
    const dispositivos = agruparPorDispositivo(dados);
    const grid = document.getElementById('devices-grid');
    grid.innerHTML = dispositivos.map(d => {
      const cls = classeTempByValue(d.temperatura);
      const pct = barPercent(d.temperatura);
      return `
        <div class="device-card ${cls}">
          <div class="device-id">DISPOSITIVO · ${d.dispositivo_id}</div>
          <div class="temp-value">${parseFloat(d.temperatura).toFixed(1)}<span class="temp-unit">°C</span></div>
          <div class="temp-label">${labelTemp(d.temperatura)}</div>
          <div class="mini-bar"><div class="mini-bar-fill" style="width:${pct}%"></div></div>
          <div class="last-seen">Última leitura: ${formatarData(d.data_hora)}</div>
        </div>`;
    }).join('');
  }

  function renderTabela(dados) {
    const tbody = document.getElementById('tabela-body');
    if (!dados.length) {
      tbody.innerHTML = '<tr><td colspan="5" class="loading">Nenhum dado encontrado</td></tr>';
      return;
    }
    tbody.innerHTML = dados.slice(0, 30).reverse().map(linha => `
      <tr>
        <td class="mono" style="color:var(--muted)">${linha.id}</td>
        <td class="mono">${linha.dispositivo_id}</td>
        <td class="mono" style="color:var(--accent);font-weight:700">${parseFloat(linha.temperatura).toFixed(1)} °C</td>
        <td>${badgeTemp(linha.temperatura)}</td>
        <td class="mono" style="color:var(--muted)">${formatarData(linha.data_hora)}</td>
      </tr>
    `).join('');
  }

  async function atualizar() {
    try {
      const res = await fetch(API_URL + '?t=' + Date.now()); // cache-bust
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const dados = await res.json();

      document.getElementById('error-msg').style.display = 'none';
      renderCards(dados);
      renderTabela(dados);

      document.getElementById('update-time').textContent =
        'Atualizado: ' + new Date().toLocaleTimeString('pt-BR');

    } catch (err) {
      const el = document.getElementById('error-msg');
      el.style.display = 'block';
      el.textContent = 'Erro ao buscar dados: ' + err.message;
    }
  }

  atualizar();
  setInterval(atualizar, INTERVALO_MS);

  function toggleTabela() {
  const wrapper = document.querySelector('.table-wrapper');
  const btn = document.getElementById('btn-toggle');
  const visivel = wrapper.style.display !== 'none';
  wrapper.style.display = visivel ? 'none' : 'block';
  btn.textContent = visivel ? 'MOSTRAR TEMPERATURAS' : 'OCULTAR TEMPERATURAS';
}
document.querySelector('.table-wrapper').style.display = 'none';
</script>
</body>
</html>