<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Menu</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SEU CSS -->
    <link href="../css/menu.css" rel="stylesheet">
</head>

<!-- Card de alertas flutuante -->
<div id="alert-widget" style="
  position: fixed; top: 20px; right: 20px; z-index: 9999;
  width: 280px; display: none;
  background: rgba(20,20,30,0.97);
  border: 1px solid rgba(255,94,58,0.4);
  border-radius: 10px;
  overflow: hidden;
  font-family: 'Space Mono', monospace;
">
  <div style="display:flex; align-items:center; justify-content:space-between; padding:10px 14px; background:rgba(255,94,58,0.1); border-bottom:1px solid rgba(255,94,58,0.2);">
    <div style="display:flex; align-items:center; gap:8px;">
      <span style="font-size:11px; font-weight:700; letter-spacing:.1em; color:#ff5e3a;">⚠ ALERTAS</span>
      <span id="widget-badge" style="font-size:10px; font-weight:700; padding:1px 7px; border-radius:99px; background:#ff5e3a; color:#fff;">0</span>
    </div>
    <a href="alerta.php" style="font-size:10px; color:#ff5e3a; text-decoration:none; letter-spacing:.05em;">VER TODOS →</a>
  </div>
  <div id="widget-lista" style="padding:8px 0; max-height:220px; overflow-y:auto;"></div>
</div>

<script>
  const WIDGET_API = 'api_temperatura.php';
  const WIDGET_HOT  = 40;
  const WIDGET_COLD = 10;
  let widgetAlertas = [];

  async function widgetAtualizar() {
    try {
      const res = await fetch(WIDGET_API + '?t=' + Date.now());
      if (!res.ok) return;
      const dados = await res.json();

      // Pega o último valor de cada dispositivo
      const mapa = {};
      dados.forEach(l => {
        if (!mapa[l.dispositivo_id]) mapa[l.dispositivo_id] = [];
        mapa[l.dispositivo_id].push(l);
      });

      Object.values(mapa).forEach(arr => {
        const ultimo = arr.sort((a,b) => new Date(b.data_hora) - new Date(a.data_hora))[0];
        const t = parseFloat(ultimo.temperatura);
        if (t >= WIDGET_HOT || t <= WIDGET_COLD) {
          widgetAlertas.unshift({
            id: ultimo.dispositivo_id,
            temp: t,
            tipo: t >= WIDGET_HOT ? 'hot' : 'cold',
            hora: new Date(ultimo.data_hora).toLocaleTimeString('pt-BR', {hour:'2-digit',minute:'2-digit',second:'2-digit'})
          });
        }
      });

      if (widgetAlertas.length > 5) widgetAlertas = widgetAlertas.slice(0, 5);
      widgetRender();
    } catch(e) {}
  }

  function widgetRender() {
    const widget = document.getElementById('alert-widget');
    const lista  = document.getElementById('widget-lista');
    const badge  = document.getElementById('widget-badge');

    widget.style.display = widgetAlertas.length > 0 ? '' : 'none';
    badge.textContent = widgetAlertas.length;

    lista.innerHTML = widgetAlertas.map(a => {
      const isHot = a.tipo === 'hot';
      const cor   = isHot ? '#ff5e3a' : '#5eb8ff';
      const icone = isHot ? '▲' : '▼';
      return `<div style="display:flex;align-items:center;gap:10px;padding:8px 14px;border-left:3px solid ${cor}; margin:4px 0; background:${isHot?'rgba(255,94,58,0.06)':'rgba(94,184,255,0.06)'}">
        <span style="color:${cor};font-size:13px;">${icone}</span>
        <div style="flex:1">
          <div style="font-size:10px;color:#888;">${a.id}</div>
          <div style="font-size:13px;font-weight:700;color:${cor};">${a.temp.toFixed(1)} °C</div>
        </div>
        <div style="font-size:10px;color:#666;">${a.hora}</div>
      </div>`;
    }).join('');
  }

  widgetAtualizar();
  setInterval(widgetAtualizar, 30000); // atualiza a cada 30 segundos
</script>

<body class="bg-zero">

    <div class="container py-5 text-center">

        <h2 class="titulo mb-5">Escolha uma opção</h2>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Usuários</h3>
                    <p>Gerenciar usuários do sistema</p>
                    <a href="Usuarios.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Dispositivos</h3>
                    <p>Gerenciar dispositivos</p>
                    <a href="Dispositivos.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Vínculos</h3>
                    <p>Gerenciar vínculos</p>
                    <a href="vincular.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Relação</h3>
                    <p>Gerenciar relações</p>
                    <a href="relacao.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Leitura da Temperatura</h3>
                    <p>Ver temperaturas</p>
                    <a href="Leitura.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>
             <div class="col-md-6">
                <div class="card card-zero p-4">
                    <h3>Alertas</h3>
                    <p>Ver alertas</p>
                    <a href="alerta.php" class="btn btn-info btn-zero">Acessar</a>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
