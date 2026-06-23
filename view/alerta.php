<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alertas de Temperatura</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/navbar.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/leitura.css">
  <style>
    .alerts-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 28px;
    }
    .alerts-header h2 {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.12em;
      color: var(--muted);
      margin: 0 0 4px;
    }
    .alerts-header h1 {
      font-family: 'Space Mono', monospace;
      font-size: 26px;
      font-weight: 700;
      color: var(--text);
      margin: 0;
    }

    /* Configurações */
    .config-row {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
      padding: 14px 18px;
      background: var(--card-bg, rgba(255,255,255,0.03));
      border: 1px solid var(--border);
      border-radius: 8px;
      margin-bottom: 24px;
    }
    .config-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      color: var(--muted);
    }
    .config-item input[type="number"] {
      width: 64px;
      padding: 4px 8px;
      font-family: 'Space Mono', monospace;
      font-size: 12px;
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--border);
      border-radius: 4px;
      color: var(--text);
      text-align: center;
    }
    .config-sep { width: 1px; height: 20px; background: var(--border); }

    /* Resumo */
    .summary-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 12px;
      margin-bottom: 24px;
    }
    .summary-card {
      padding: 14px 16px;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: rgba(255,255,255,0.02);
    }
    .summary-card .label {
      font-family: 'Space Mono', monospace;
      font-size: 10px;
      letter-spacing: 0.1em;
      color: var(--muted);
      margin-bottom: 6px;
    }
    .summary-card .value {
      font-family: 'Space Mono', monospace;
      font-size: 24px;
      font-weight: 700;
      color: var(--text);
    }
    .summary-card.hot .value  { color: #ff5e3a; }
    .summary-card.cold .value { color: #5eb8ff; }
    .summary-card.ok .value   { color: #3dffa0; }

    /* Alertas */
    .alerts-toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 12px;
    }
    .section-label {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.1em;
      color: var(--muted);
    }
    .btn-clear {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      padding: 5px 12px;
      background: none;
      border: 1px solid var(--border);
      border-radius: 4px;
      color: var(--muted);
      cursor: pointer;
      transition: color .2s, border-color .2s;
    }
    .btn-clear:hover { color: #ff5e3a; border-color: #ff5e3a; }

    .alerts-list { display: flex; flex-direction: column; gap: 8px; }

    .alert-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      padding: 14px 16px;
      border-left: 3px solid transparent;
      border-radius: 0 6px 6px 0;
      background: rgba(255,255,255,0.02);
      border-top: 1px solid var(--border);
      border-right: 1px solid var(--border);
      border-bottom: 1px solid var(--border);
      animation: fadeIn .25s ease;
    }
    @keyframes fadeIn { from { opacity:0; transform:translateY(-4px); } to { opacity:1; transform:none; } }

    .alert-item.hot  { border-left-color: #ff5e3a; background: rgba(255,94,58,0.06); }
    .alert-item.cold { border-left-color: #5eb8ff; background: rgba(94,184,255,0.06); }

    .alert-icon { font-size: 20px; flex-shrink: 0; margin-top: 1px; }
    .alert-item.hot  .alert-icon { color: #ff5e3a; }
    .alert-item.cold .alert-icon { color: #5eb8ff; }

    .alert-body { flex: 1; }
    .alert-device {
      font-family: 'Space Mono', monospace;
      font-size: 12px;
      color: var(--muted);
      margin-bottom: 3px;
    }
    .alert-msg {
      font-family: 'Space Mono', monospace;
      font-size: 14px;
      font-weight: 700;
    }
    .alert-item.hot  .alert-msg { color: #ff5e3a; }
    .alert-item.cold .alert-msg { color: #5eb8ff; }

    .alert-sub {
      font-size: 12px;
      color: var(--muted);
      margin-top: 3px;
    }

    .alert-right { text-align: right; flex-shrink: 0; }
    .alert-time {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      color: var(--muted);
    }
    .alert-temp {
      font-family: 'Space Mono', monospace;
      font-size: 18px;
      font-weight: 700;
      margin-top: 4px;
    }
    .alert-item.hot  .alert-temp { color: #ff5e3a; }
    .alert-item.cold .alert-temp { color: #5eb8ff; }

    .empty-state {
      padding: 48px 24px;
      text-align: center;
      border: 1px dashed var(--border);
      border-radius: 8px;
      color: var(--muted);
      font-family: 'Space Mono', monospace;
      font-size: 12px;
    }
    .empty-state svg { display: block; margin: 0 auto 12px; opacity: .4; }

    /* Status bar */
    .status-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .status-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: #3dffa0;
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
    .status-text {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      letter-spacing: 0.1em;
      color: #3dffa0;
    }
    .update-time {
      font-family: 'Space Mono', monospace;
      font-size: 11px;
      color: var(--muted);
      margin-left: auto;
    }
  </style>
</head>
<body>

<?php include 'navbar.php' ?>

<div class="container">

  <div class="alerts-header">
    <div>
      <h2>SISTEMA DE MONITORAMENTO</h2>
      <h1>ALERTAS</h1>
    </div>
    <div class="status-bar" style="margin-bottom:0;">
      <div class="status-dot"></div>
      <span class="status-text">AO VIVO</span>
      <span class="update-time" id="update-time">aguardando...</span>
    </div>
  </div>

  <!-- Configuração de limites -->
  <div class="config-row">
    <span style="font-family:'Space Mono',monospace; font-size:11px; letter-spacing:.1em; color:var(--muted);">LIMITES</span>
    <div class="config-sep"></div>
    <div class="config-item">
      🔴 Temperatura alta acima de
      <input type="number" id="lim-hot" value="40" step="1" min="-50" max="200"> °C
    </div>
    <div class="config-sep"></div>
    <div class="config-item">
      🔵 Temperatura baixa abaixo de
      <input type="number" id="lim-cold" value="10" step="1" min="-50" max="200"> °C
    </div>
    <div class="config-sep"></div>
<div class="config-item">
  ⏱ Atualizar a cada
  <input type="number" id="lim-intervalo" value="60" step="1" min="5" max="3600"> segundos
</div>
  </div>

  <!-- Cards de resumo -->
  <div class="summary-grid">
    <div class="summary-card hot">
      <div class="label">TEMP. ALTA</div>
      <div class="value" id="count-hot">0</div>
    </div>
    <div class="summary-card cold">
      <div class="label">TEMP. BAIXA</div>
      <div class="value" id="count-cold">0</div>
    </div>
    <div class="summary-card ok">
      <div class="label">NORMAL</div>
      <div class="value" id="count-ok">0</div>
    </div>
    <div class="summary-card">
      <div class="label">TOTAL ALERTAS</div>
      <div class="value" id="count-total">0</div>
    </div>
  </div>

  <!-- Barra de ferramentas -->
  <div class="alerts-toolbar">
    <span class="section-label">HISTÓRICO DE ALERTAS</span>
    <button class="btn-clear" onclick="limparAlertas()">⟳ LIMPAR LISTA</button>
  </div>

  <!-- Lista de alertas -->
  <div class="alerts-list" id="alerts-list">
    <div class="empty-state">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      Aguardando leituras...
    </div>
  </div>

</div>

<script>
  const API_URL = 'api_temperatura.php';
  const INTERVALO_MS = 2000;

  let alertas = [];
  let contagemDispositivos = {};

  function getLimites() {
  function val(id, fallback) {
    const el = document.getElementById(id);
    return el ? parseFloat(el.value) || fallback : fallback;
  }
  return {
    hot:       val('lim-hot', 40),
    cold:      val('lim-cold', 10),
    max:       val('lim-max', 20),
    intervalo: val('lim-intervalo', 60)
  };
}

  function formatarData(str) {
    const d = new Date(str);
    if (isNaN(d)) return str;
    return d.toLocaleString('pt-BR', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' });
  }

  function limparAlertas() {
    alertas = [];
    renderAlertas();
  }

  function adicionarAlerta(dispositivo_id, temperatura, tipo, data_hora) {
    const lim = getLimites();
    alertas.unshift({ dispositivo_id, temperatura, tipo, data_hora, ts: new Date() });
    if (alertas.length > lim.max) alertas = alertas.slice(0, lim.max);
  }

  function renderAlertas() {
    const lista = document.getElementById('alerts-list');
    const lim = getLimites();

    // Contadores
    const hot   = alertas.filter(a => a.tipo === 'hot').length;
    const cold  = alertas.filter(a => a.tipo === 'cold').length;
    document.getElementById('count-hot').textContent   = hot;
    document.getElementById('count-cold').textContent  = cold;
    document.getElementById('count-total').textContent = alertas.length;

    if (!alertas.length) {
      lista.innerHTML = `<div class="empty-state">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Nenhum alerta registrado
      </div>`;
      return;
    }

    lista.innerHTML = alertas.map(a => {
      const isHot = a.tipo === 'hot';
      const diff  = isHot
        ? `+${(a.temperatura - lim.hot).toFixed(1)} °C acima do limite`
        : `-${(lim.cold - a.temperatura).toFixed(1)} °C abaixo do limite`;
      const icone = isHot ? '▲' : '▼';
      const msg   = isHot ? 'TEMPERATURA ELEVADA' : 'TEMPERATURA BAIXA';

      return `<div class="alert-item ${isHot ? 'hot' : 'cold'}">
        <div class="alert-icon">${icone}</div>
        <div class="alert-body">
          <div class="alert-device">DISPOSITIVO · ${a.dispositivo_id}</div>
          <div class="alert-msg">${msg}</div>
          <div class="alert-sub">${diff}</div>
        </div>
        <div class="alert-right">
          <div class="alert-time">${formatarData(a.data_hora || a.ts)}</div>
          <div class="alert-temp">${parseFloat(a.temperatura).toFixed(1)} °C</div>
        </div>
      </div>`;
    }).join('');
  }

  function agruparPorDispositivo(dados) {
    const mapa = {};
    dados.forEach(l => {
      if (!mapa[l.dispositivo_id]) mapa[l.dispositivo_id] = [];
      mapa[l.dispositivo_id].push(l);
    });
    return mapa;
  }

  function ultimoPorDispositivo(agrupado) {
    return Object.values(agrupado).map(arr => arr[arr.length - 1]);
  }

  async function atualizar() {
    try {
      const res = await fetch(API_URL + '?t=' + Date.now());
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const dados = await res.json();

      const lim = getLimites();
      const agrupado = agruparPorDispositivo(dados);
      const ultimos  = ultimoPorDispositivo(agrupado);

      // Conta dispositivos normais
      let normais = 0;
      ultimos.forEach(l => {
        const t = parseFloat(l.temperatura);
        if (t >= lim.hot)       adicionarAlerta(l.dispositivo_id, t, 'hot',  l.data_hora);
        else if (t <= lim.cold) adicionarAlerta(l.dispositivo_id, t, 'cold', l.data_hora);
        else                    normais++;
      });

      document.getElementById('count-ok').textContent = normais;
      document.getElementById('update-time').textContent = 'Atualizado: ' + new Date().toLocaleTimeString('pt-BR');

      renderAlertas();
    } catch (err) {
      document.getElementById('update-time').textContent = 'Erro: ' + err.message;
    }
  }

  renderAlertas();
  atualizar();
  setInterval(atualizar, INTERVALO_MS);
</script>
</body>
</html>