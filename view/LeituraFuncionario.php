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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
</head>
<body>

<?php include 'navbarFuncionario.php' ?>

<div class="container">
  <header>
    <div class="header-left">
      <h1>Sistema de monitoramento</h1>
      <h2>DE TEMPERATURA</h2>
    </div>
    <div class="header-right">
      <div><span class="status-dot"></span><span class="status-text">AO VIVO</span></div>
      <div class="update-time" id="update-time">aguardando...</div>
    </div>
  </header>

  <div class="error-msg" id="error-msg"></div>

  <div class="controls" style="display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:20px;">
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
  // Config
  const API_URL = 'api_temperatura.php';
  const INTERVALO_MS = 2000;

  // Chart defaults
  Chart.defaults.color = '#5c6880';
  Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';
  Chart.defaults.font.family = "'Space Mono', monospace";
  Chart.defaults.font.size = 10;

  // Helpers
  function classeTempByValue(t) { if (t >= 60) return 'hot'; if (t >= 40) return 'warm'; if (t < 10) return 'cold'; return 'normal'; }
  function labelTemp(t) { if (t >= 60) return 'Temperatura crítica'; if (t >= 40) return 'Temperatura elevada'; if (t < 10) return 'Temperatura baixa'; return 'Normal'; }
  function colorByClass(cls) { return { hot: '#ff5e3a', warm: '#ffb347', cold: '#5eb8ff', normal: '#3dffa0' }[cls]; }
  function badgeTemp(t) { const cls = classeTempByValue(t); return `<span class="badge badge-${cls}">${labelTemp(t)}</span>`; }
  function barPercent(t) { return Math.min(100, Math.max(0, ((t + 20) / 120) * 100)).toFixed(1); }
  function formatarData(str) { const d = new Date(str); if (isNaN(d)) return str; return d.toLocaleString('pt-BR', { day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit' }); }
  function formatarHora(str) { const d = new Date(str); if (isNaN(d)) return str; return d.toLocaleTimeString('pt-BR', { hour:'2-digit', minute:'2-digit', second:'2-digit' }); }

  // Agrupamento e últimos valores
  function agruparPorDispositivo(dados) { const mapa = {}; dados.forEach(l=>{ const id = l.dispositivo_id; if(!mapa[id]) mapa[id]=[]; mapa[id].push(l); }); Object.values(mapa).forEach(arr=>arr.sort((a,b)=> new Date(a.data_hora)-new Date(b.data_hora))); return mapa; }
  function ultimoPorDispositivo(agrupado) { return Object.entries(agrupado).map(([,arr])=> arr[arr.length-1]); }

  // Render
  function renderCards(agrupado){ const dispositivos = ultimoPorDispositivo(agrupado); const grid = document.getElementById('devices-grid'); grid.innerHTML = dispositivos.map(d=>{ const cls = classeTempByValue(d.temperatura); const pct = barPercent(d.temperatura); return `<div class="device-card ${cls}"><div class="device-id">DISPOSITIVO · ${d.dispositivo_id}</div><div class="temp-value">${parseFloat(d.temperatura).toFixed(1)}<span class="temp-unit">°C</span></div><div class="temp-label">${labelTemp(d.temperatura)}</div><div class="mini-bar"><div class="mini-bar-fill" style="width:${pct}%"></div></div><div class="last-seen">Última leitura: ${formatarData(d.data_hora)}</div></div>`; }).join(''); }

  // Overview chart (per-device series)
  const DEVICE_COLORS = ['#00d4ff','#3dffa0','#ffb347','#ff5e3a','#a78bfa','#f472b6','#34d399','#fbbf24','#60a5fa','#f87171'];
  const deviceColorMap = {}; let colorIndex=0; function getDeviceColor(id){ if(!deviceColorMap[id]) deviceColorMap[id]=DEVICE_COLORS[colorIndex++ % DEVICE_COLORS.length]; return deviceColorMap[id]; }

  function renderOverviewChart(agrupado){ const canvas = document.getElementById('chart-overview'); if(!canvas) return; const ids = Object.keys(agrupado); const datasets = ids.map(id=>{ const pts = agrupado[id].slice(-30); const cor = getDeviceColor(id); return { label: id, data: pts.map(p=>({x:new Date(p.data_hora), y:parseFloat(p.temperatura)})), borderColor:cor, backgroundColor:cor+'18', borderWidth:2, pointRadius:3, tension:.4, fill:false }; }); const existing = Chart.getChart(canvas); if(existing){ existing.data.datasets = datasets; existing.update('none'); return; } new Chart(canvas.getContext('2d'), { type:'line', data:{datasets}, options:{ responsive:true, interaction:{mode:'index',intersect:false}, plugins:{ legend:{display:true, position:'top'}, tooltip:{ callbacks:{ label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} °C` } } }, scales:{ x:{ type:'time', time:{ tooltipFormat:'HH:mm:ss' }, grid:{color:'rgba(255,255,255,0.04)'}, ticks:{color:'#4a5568'} }, y:{ grid:{color:'rgba(255,255,255,0.04)'}, ticks:{color:'#4a5568', callback: v=> v + ' °C'} } } } }); }

  // Per-device charts
  function renderDeviceCharts(agrupado){ const grid = document.getElementById('charts-grid'); if(!grid) return; Object.keys(agrupado).forEach(id=>{ if(!document.getElementById(`chart-card-${id}`)){ const card = document.createElement('div'); card.className='chart-card'; card.id=`chart-card-${id}`; card.innerHTML = `<div class="chart-card-header"><span class="chart-card-title">DISPOSITIVO · ${id}</span><span class="chart-card-temp" id="chart-card-temp-${id}">—</span></div><canvas id="canvas-${id}" height="100"></canvas>`; grid.appendChild(card); } const pts = agrupado[id].slice(-20); const ultima = parseFloat(pts[pts.length-1].temperatura); const cls=classeTempByValue(ultima); const cor=colorByClass(cls); const tempEl = document.getElementById(`chart-card-temp-${id}`); if(tempEl){ tempEl.textContent = ultima.toFixed(1)+' °C'; tempEl.style.color = cor; } const labels = pts.map(p=>formatarHora(p.data_hora)); const values = pts.map(p=>parseFloat(p.temperatura)); const canvas = document.getElementById(`canvas-${id}`); const existing = Chart.getChart(canvas); if(existing){ existing.data.labels = labels; existing.data.datasets[0].data = values; existing.data.datasets[0].borderColor = cor; existing.update('none'); } else { new Chart(canvas.getContext('2d'), { type:'line', data:{ labels, datasets:[{ label:'Temperatura (°C)', data:values, borderColor:cor, backgroundColor:cor+'15', pointRadius:3, borderWidth:2, tension:.4, fill:true }] }, options:{ responsive:true, plugins:{ legend:{display:false}, tooltip:{ callbacks:{ label: ctx => ` ${ctx.parsed.y.toFixed(1)} °C` } } }, scales:{ x:{ grid:{color:'rgba(255,255,255,0.04)'}, ticks:{color:'#4a5568'} }, y:{ grid:{color:'rgba(255,255,255,0.04)'}, ticks:{color:'#4a5568'} } } } }); } }); const loading = grid.querySelector('.loading'); if(loading) loading.remove(); }

  // Tabela
  function renderTabela(dados){ const tbody = document.getElementById('tabela-body'); if(!dados.length){ tbody.innerHTML = '<tr><td colspan="5" class="loading">Nenhum dado encontrado</td></tr>'; return; } tbody.innerHTML = dados.slice().reverse().map(l=>`<tr><td class="mono" style="color:var(--muted)">${l.id}</td><td class="mono">${l.dispositivo_id}</td><td class="mono" style="color:var(--accent);font-weight:700">${parseFloat(l.temperatura).toFixed(1)} °C</td><td>${badgeTemp(l.temperatura)}</td><td class="mono" style="color:var(--muted)">${formatarData(l.data_hora)}</td></tr>`).join(''); }

  // Atualização
  async function atualizar(){ try{ const res = await fetch(API_URL + '?t=' + Date.now()); if(!res.ok) throw new Error(`HTTP ${res.status}`); const dados = await res.json(); document.getElementById('error-msg').style.display='none'; const agrupado = agruparPorDispositivo(dados); renderCards(agrupado); renderOverviewChart(agrupado); renderDeviceCharts(agrupado); renderTabela(dados); document.getElementById('update-time').textContent = 'Atualizado: ' + new Date().toLocaleTimeString('pt-BR'); }catch(err){ const el = document.getElementById('error-msg'); el.style.display='block'; el.textContent = 'Erro ao buscar dados: ' + err.message; } }

  function toggleSecao(wrapperId, btnId, label){ const wrapper = document.getElementById(wrapperId); const btn = document.getElementById(btnId); const visivel = wrapper.style.display !== 'none'; wrapper.style.display = visivel ? 'none' : ''; btn.textContent = visivel ? `MOSTRAR ${label}` : `OCULTAR ${label}`; }

  // Inicializa
  atualizar(); setInterval(atualizar, INTERVALO_MS);
</script>
</body>
</html>