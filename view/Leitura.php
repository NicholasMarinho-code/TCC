<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Monitor de Temperatura</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<style>
  :root {
    --bg: #0a0e1a;
    --surface: #111827;
    --surface2: #1a2235;
    --border: rgba(255,255,255,0.07);
    --text: #e8eaf0;
    --muted: #5c6880;
    --accent: #00d4ff;
    --hot: #ff5e3a;
    --warm: #ffb347;
    --cold: #5eb8ff;
    --ok: #3dffa0;
    --mono: 'Space Mono', monospace;
    --sans: 'DM Sans', sans-serif;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: var(--bg); color: var(--text); font-family: var(--sans); min-height: 100vh; padding: 24px; }
  body::before {
    content: '';
    position: fixed; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none; z-index: 0; opacity: 0.4;
  }
  .container { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; }
  header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid var(--border);
  }
  .header-left h1 { font-family: var(--mono); font-size: 13px; letter-spacing: 0.15em; text-transform: uppercase; color: var(--muted); margin-bottom: 6px; }
  .header-left h2 { font-family: var(--mono); font-size: 22px; font-weight: 700; color: var(--accent); }
  .header-right { text-align: right; }
  .status-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--ok); margin-right: 6px; animation: pulse 2s ease-in-out infinite; }
  @keyframes pulse {
    0%,100% { opacity: 1; box-shadow: 0 0 0 0 rgba(61,255,160,0.4); }
    50%      { opacity: 0.7; box-shadow: 0 0 0 6px rgba(61,255,160,0); }
  }
  .status-text { font-family: var(--mono); font-size: 11px; color: var(--ok); letter-spacing: 0.1em; }
  .update-time { font-family: var(--mono); font-size: 11px; color: var(--muted); margin-top: 4px; }
  .section-title { font-family: var(--mono); font-size: 11px; letter-spacing: 0.15em; text-transform: uppercase; color: var(--muted); margin-bottom: 14px; }
  .devices-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; margin-bottom: 32px; }
  .device-card {
    background: var(--surface); border: 1px solid var(--border); border-radius: 14px;
    padding: 20px; position: relative; overflow: hidden;
    transition: border-color 0.3s, transform 0.2s; animation: fadeIn 0.4s ease both;
  }
  .device-card:hover { border-color: rgba(255,255,255,0.15); transform: translateY(-2px); }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  .device-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 14px 14px 0 0; }
  .device-card.hot::before    { background: linear-gradient(90deg, var(--hot), #ff8c00); }
  .device-card.warm::before   { background: linear-gradient(90deg, var(--warm), #ffe066); }
  .device-card.cold::before   { background: linear-gradient(90deg, var(--cold), #a0d4ff); }
  .device-card.normal::before { background: linear-gradient(90deg, var(--ok), #00bcd4); }
  .device-id { font-family: var(--mono); font-size: 11px; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 10px; }
  .temp-value { font-family: var(--mono); font-size: 42px; font-weight: 700; line-height: 1; margin-bottom: 4px; }
  .temp-unit { font-size: 20px; color: var(--muted); }
  .device-card.hot   .temp-value { color: var(--hot); }
  .device-card.warm  .temp-value { color: var(--warm); }
  .device-card.cold  .temp-value { color: var(--cold); }
  .device-card.normal .temp-value { color: var(--ok); }
  .temp-label { font-size: 12px; color: var(--muted); margin-bottom: 14px; }
  .device-card.hot   .temp-label::before { content: '🔴 '; }
  .device-card.warm  .temp-label::before { content: '🟡 '; }
  .device-card.cold  .temp-label::before { content: '🔵 '; }
  .device-card.normal .temp-label::before { content: '🟢 '; }
  .mini-bar { height: 4px; background: var(--border); border-radius: 2px; overflow: hidden; margin-top: 12px; }
  .mini-bar-fill { height: 100%; border-radius: 2px; transition: width 0.8s ease; }
  .device-card.hot   .mini-bar-fill { background: var(--hot); }
  .device-card.warm  .mini-bar-fill { background: var(--warm); }
  .device-card.cold  .mini-bar-fill { background: var(--cold); }
  .device-card.normal .mini-bar-fill { background: var(--ok); }
  .last-seen { font-family: var(--mono); font-size: 10px; color: var(--muted); margin-top: 10px; }
  .chart-overview-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 20px 24px; margin-bottom: 32px; }
  .charts-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; margin-bottom: 32px; }
  .chart-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 20px 20px 14px; animation: fadeIn 0.5s ease both; }
  .chart-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
  .chart-card-title { font-family: var(--mono); font-size: 11px; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
  .chart-card-temp { font-family: var(--mono); font-size: 15px; font-weight: 700; }
  .table-wrapper { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
  table { width: 100%; border-collapse: collapse; }
  thead th { font-family: var(--mono); font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); padding: 14px 20px; text-align: left; border-bottom: 1px solid var(--border); background: var(--surface2); }
  tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--surface2); }
  td { padding: 12px 20px; font-size: 13px; }
  td.mono { font-family: var(--mono); font-size: 12px; }
  .badge { display: inline-block; font-family: var(--mono); font-size: 10px; padding: 3px 8px; border-radius: 99px; font-weight: 700; letter-spacing: 0.05em; }
  .badge-hot    { background: rgba(255,94,58,0.15);  color: var(--hot); }
  .badge-warm   { background: rgba(255,179,71,0.15); color: var(--warm); }
  .badge-cold   { background: rgba(94,184,255,0.15); color: var(--cold); }
  .badge-normal { background: rgba(61,255,160,0.15); color: var(--ok); }
  .loading { text-align: center; padding: 40px; font-family: var(--mono); font-size: 12px; color: var(--muted); letter-spacing: 0.1em; }
  .error-msg { background: rgba(255,94,58,0.1); border: 1px solid rgba(255,94,58,0.3); border-radius: 10px; padding: 16px 20px; font-family: var(--mono); font-size: 12px; color: var(--hot); margin-bottom: 20px; display: none; }
  .btn-toggle { font-family: var(--mono); font-size: 11px; letter-spacing: 0.1em; background: rgba(0,212,255,0.1); color: var(--accent); border: 1px solid rgba(0,212,255,0.3); border-radius: 99px; padding: 5px 14px; cursor: pointer; transition: background 0.2s; }
  .btn-toggle:hover { background: rgba(0,212,255,0.2); }
</style>
</head>
<body>
<div class="container">
  <header>
    <div class="header-left">
      <h1>Sistema de monitoramento</h1>
      <h2>TEMP_MONITOR</h2>
    </div>
    <div class="header-right">
      <div><span class="status-dot"></span><span class="status-text">AO VIVO</span></div>
      <div class="update-time" id="update-time">aguardando...</div>
    </div>
  </header>

  <div class="error-msg" id="error-msg"></div>

  <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:20px;">
    <span class="section-title" style="margin-bottom:0">Dispositivos ativos</span>
    <span style="color:var(--border); font-size:16px;">|</span>
    <span class="section-title" style="margin-bottom:0">Histórico geral</span>
    <button class="btn-toggle" id="btn-overview" onclick="toggleSecao('chart-overview-wrap','btn-overview','GRÁFICO GERAL')">MOSTRAR GRÁFICO GERAL</button>
    <span style="color:var(--border); font-size:16px;">|</span>
    <span class="section-title" style="margin-bottom:0">Por dispositivo</span>
    <button class="btn-toggle" id="btn-device-charts" onclick="toggleSecao('charts-grid','btn-device-charts','GRÁFICOS POR DISPOSITIVO')">MOSTRAR GRÁFICOS POR DISPOSITIVO</button>
    <span style="color:var(--border); font-size:16px;">|</span>
    <span class="section-title" style="margin-bottom:0">Últimas leituras</span>
    <button class="btn-toggle" id="btn-toggle" onclick="toggleSecao('table-wrapper','btn-toggle','TEMPERATURAS')">MOSTRAR TEMPERATURAS</button>
  </div>

  <div class="devices-grid" id="devices-grid">
    <div class="loading">Carregando dispositivos...</div>
  </div>

  <div class="chart-overview-wrap" id="chart-overview-wrap" style="display:none; margin-bottom:32px;">
    <canvas id="chart-overview" height="90"></canvas>
  </div>

  <div class="charts-grid" id="charts-grid" style="display:none;">
    <div class="loading">Carregando gráficos...</div>
  </div>
  <div class="table-wrapper" id="table-wrapper" style="display:none;">
    <table>
      <thead>
        <tr><th>#ID</th><th>Dispositivo</th><th>Temperatura</th><th>Status</th><th>Data / Hora</th></tr>
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
  const DEVICE_COLORS = ['#00d4ff','#3dffa0','#ffb347','#ff5e3a','#a78bfa','#f472b6','#34d399','#fbbf24','#60a5fa','#f87171'];

  Chart.defaults.color = '#5c6880';
  Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';
  Chart.defaults.font.family = "'Space Mono', monospace";
  Chart.defaults.font.size = 10;

  // Paleta de cores por dispositivo (persistente entre updates)
  const deviceColorMap = {};
  let colorIndex = 0;
  function getDeviceColor(id) {
    if (!deviceColorMap[id]) {
      deviceColorMap[id] = DEVICE_COLORS[colorIndex % DEVICE_COLORS.length];
      colorIndex++;
    }
    return deviceColorMap[id];
  }

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
  function colorByClass(cls) {
    return { hot: '#ff5e3a', warm: '#ffb347', cold: '#5eb8ff', normal: '#3dffa0' }[cls];
  }
  function badgeTemp(t) {
    const cls = classeTempByValue(t);
    return `<span class="badge badge-${cls}">${labelTemp(t)}</span>`;
  }
  function barPercent(t) {
    return Math.min(100, Math.max(0, ((t + 20) / 120) * 100)).toFixed(1);
  }
  function formatarData(str) {
    const d = new Date(str);
    if (isNaN(d)) return str;
    return d.toLocaleString('pt-BR', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' });
  }
  function formatarHora(str) {
    const d = new Date(str);
    if (isNaN(d)) return str;
    return d.toLocaleTimeString('pt-BR', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
  }
  function agruparPorDispositivo(dados) {
    const mapa = {};
    dados.forEach(linha => {
      const id = linha.dispositivo_id;
      if (!mapa[id]) mapa[id] = [];
      mapa[id].push(linha);
    });
    Object.values(mapa).forEach(arr => arr.sort((a, b) => new Date(a.data_hora) - new Date(b.data_hora)));
    return mapa;
  }
  function ultimoPorDispositivo(agrupado) {
    return Object.entries(agrupado).map(([, arr]) => arr[arr.length - 1]);
  }

  // ── Cards ─────────────────────────────────────────────────
  function renderCards(agrupado) {
    const dispositivos = ultimoPorDispositivo(agrupado);
    document.getElementById('devices-grid').innerHTML = dispositivos.map(d => {
      const cls = classeTempByValue(d.temperatura);
      const pct = barPercent(d.temperatura);
      return `<div class="device-card ${cls}">
        <div class="device-id">DISPOSITIVO · ${d.dispositivo_id}</div>
        <div class="temp-value">${parseFloat(d.temperatura).toFixed(1)}<span class="temp-unit">°C</span></div>
        <div class="temp-label">${labelTemp(d.temperatura)}</div>
        <div class="mini-bar"><div class="mini-bar-fill" style="width:${pct}%"></div></div>
        <div class="last-seen">Última leitura: ${formatarData(d.data_hora)}</div>
      </div>`;
    }).join('');
  }

  // ── Gráfico panorâmico ────────────────────────────────────
  // Usa Chart.getChart(canvas) para recuperar instância existente com segurança
  function renderOverviewChart(agrupado) {
    const canvas = document.getElementById('chart-overview');
    const dispositivos = Object.keys(agrupado);

    const datasets = dispositivos.map(id => {
      const pontos = agrupado[id].slice(-30);
      const cor = getDeviceColor(id);
      return {
        label: id,
        data: pontos.map(p => ({ x: new Date(p.data_hora), y: parseFloat(p.temperatura) })),
        borderColor: cor, backgroundColor: cor + '18',
        borderWidth: 2, pointRadius: 3, pointHoverRadius: 6, tension: 0.4, fill: false,
      };
    });

    const existing = Chart.getChart(canvas);
    if (existing) {
      existing.data.datasets = datasets;
      existing.update('none');
      return;
    }

    new Chart(canvas.getContext('2d'), {
      type: 'line',
      data: { datasets },
      options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
          legend: { display: true, position: 'top', labels: { boxWidth: 12, padding: 16, color: '#8a9ab5', font: { size: 10 } } },
          tooltip: {
            backgroundColor: '#1a2235', borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1,
            titleColor: '#8a9ab5', bodyColor: '#e8eaf0',
            callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} °C` }
          }
        },
        scales: {
          x: {
            type: 'time',
            time: { tooltipFormat: 'HH:mm:ss', displayFormats: { millisecond: 'HH:mm:ss', second: 'HH:mm:ss', minute: 'HH:mm', hour: 'HH:mm' } },
            grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { maxTicksLimit: 8, color: '#4a5568' }
          },
          y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#4a5568', callback: v => v + ' °C' } }
        }
      }
    });
  }

  // ── Gráficos individuais ──────────────────────────────────
  // Mesmo padrão: Chart.getChart(canvas) → update; senão cria
  function renderDeviceCharts(agrupado) {
    const grid = document.getElementById('charts-grid');
    const dispositivos = Object.keys(agrupado);

    dispositivos.forEach(id => {
      // Cria o card HTML se ainda não existe
      if (!document.getElementById(`chart-card-${id}`)) {
        const card = document.createElement('div');
        card.className = 'chart-card';
        card.id = `chart-card-${id}`;
        card.innerHTML = `
          <div class="chart-card-header">
            <span class="chart-card-title">DISPOSITIVO · ${id}</span>
            <span class="chart-card-temp" id="chart-card-temp-${id}">—</span>
          </div>
          <canvas id="canvas-${id}" height="100"></canvas>`;
        grid.appendChild(card);
      }

      const pontos = agrupado[id].slice(-20);
      const ultima = parseFloat(pontos[pontos.length - 1].temperatura);
      const cls = classeTempByValue(ultima);
      const cor = colorByClass(cls);

      const tempEl = document.getElementById(`chart-card-temp-${id}`);
      if (tempEl) { tempEl.textContent = ultima.toFixed(1) + ' °C'; tempEl.style.color = cor; }

      const labels = pontos.map(p => formatarHora(p.data_hora));
      const values = pontos.map(p => parseFloat(p.temperatura));

      const canvas = document.getElementById(`canvas-${id}`);
      const existing = Chart.getChart(canvas);

      if (existing) {
        existing.data.labels = labels;
        existing.data.datasets[0].data = values;
        existing.data.datasets[0].borderColor = cor;
        existing.data.datasets[0].backgroundColor = cor + '15';
        existing.data.datasets[0].pointBackgroundColor = cor;
        existing.update('none');
      } else {
        new Chart(canvas.getContext('2d'), {
          type: 'line',
          data: {
            labels,
            datasets: [{
              label: 'Temperatura (°C)', data: values,
              borderColor: cor, backgroundColor: cor + '15', pointBackgroundColor: cor,
              pointRadius: 3, pointHoverRadius: 6, borderWidth: 2, tension: 0.4, fill: true,
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { display: false },
              tooltip: {
                backgroundColor: '#1a2235', borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1,
                titleColor: '#8a9ab5', bodyColor: '#e8eaf0',
                callbacks: { label: ctx => ` ${ctx.parsed.y.toFixed(1)} °C` }
              }
            },
            scales: {
              x: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#4a5568', maxTicksLimit: 6 } },
              y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: '#4a5568', callback: v => v + '°' } }
            }
          }
        });
      }
    });

    const loading = grid.querySelector('.loading');
    if (loading) loading.remove();
  }

  // ── Tabela ────────────────────────────────────────────────
  function renderTabela(dados) {
    const tbody = document.getElementById('tabela-body');
    if (!dados.length) { tbody.innerHTML = '<tr><td colspan="5" class="loading">Nenhum dado encontrado</td></tr>'; return; }
    tbody.innerHTML = dados.slice().reverse().map(linha => `
      <tr>
        <td class="mono" style="color:var(--muted)">${linha.id}</td>
        <td class="mono">${linha.dispositivo_id}</td>
        <td class="mono" style="color:var(--accent);font-weight:700">${parseFloat(linha.temperatura).toFixed(1)} °C</td>
        <td>${badgeTemp(linha.temperatura)}</td>
        <td class="mono" style="color:var(--muted)">${formatarData(linha.data_hora)}</td>
      </tr>`).join('');
  }

  // ── Loop principal ────────────────────────────────────────
  async function atualizar() {
    try {
      const res = await fetch(API_URL + '?t=' + Date.now());
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const dados = await res.json();
      document.getElementById('error-msg').style.display = 'none';
      const agrupado = agruparPorDispositivo(dados);
      renderCards(agrupado);
      renderOverviewChart(agrupado);
      renderDeviceCharts(agrupado);
      renderTabela(dados);
      document.getElementById('update-time').textContent = 'Atualizado: ' + new Date().toLocaleTimeString('pt-BR');
    } catch (err) {
      const el = document.getElementById('error-msg');
      el.style.display = 'block';
      el.textContent = 'Erro ao buscar dados: ' + err.message;
    }
  }

  function toggleSecao(wrapperId, btnId, label) {
    const wrapper = document.getElementById(wrapperId);
    const btn = document.getElementById(btnId);
    const visivel = wrapper.style.display !== 'none';
    wrapper.style.display = visivel ? 'none' : '';
    btn.textContent = visivel ? `MOSTRAR ${label}` : `OCULTAR ${label}`;
  }

  atualizar();
  setInterval(atualizar, INTERVALO_MS);
</script>
</body>
</html>