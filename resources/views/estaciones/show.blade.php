<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAROSBIKES — {{ $estacion->nombre }}</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #1a1a1a; color: #e0e0e0; min-height: 100vh; }
        .navbar { background: #2a2a2a; padding: 15px 30px; border-bottom: 3px solid #f5c518; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1000; }
        .logo { color: #f5c518; font-size: 20px; font-weight: 800; letter-spacing: 2px; text-decoration: none; transition: text-shadow 0.3s; }
        .logo:hover { text-shadow: 0 0 20px rgba(245, 197, 24, 0.5); }
        .logo span { color: #888; font-weight: 400; }
        .nav-links { display: flex; gap: 20px; }
        .nav-links a { color: #bbb; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.3s; position: relative; }
        .nav-links a:hover { color: #f5c518; }
        .nav-links a::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: #f5c518; transition: width 0.3s; }
        .nav-links a:hover::after { width: 100%; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .back-link { color: #f5c518; text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; transition: all 0.2s; }
        .back-link:hover { gap: 10px; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes glow { 0%, 100% { box-shadow: 0 0 5px rgba(245, 197, 24, 0.1); } 50% { box-shadow: 0 0 15px rgba(245, 197, 24, 0.3); } }
        h1 { color: #f5c518; font-size: 28px; margin-bottom: 5px; font-weight: 800; }
        h2 { color: #e0e0e0; font-size: 18px; margin: 25px 0 15px; font-weight: 600; }
        .info { color: #999; font-size: 14px; margin-top: 10px; line-height: 1.8; }
        .info strong { color: #ccc; }
        .alert { padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; font-size: 14px; animation: slideIn 0.4s ease-out; }
        .alert-success { background: rgba(245, 197, 24, 0.15); color: #f5c518; border: 1px solid rgba(245, 197, 24, 0.3); }
        .alert-error { background: rgba(220, 53, 69, 0.15); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.3); }
        .header-card { background: #2a2a2a; padding: 25px; border-radius: 8px; border-left: 4px solid #f5c518; margin-bottom: 25px; animation: fadeInUp 0.5s ease-out; }
        #map { width: 100%; height: 250px; border-radius: 8px; margin-bottom: 25px; border: 2px solid #333; animation: fadeInUp 0.6s ease-out 0.2s forwards; opacity: 0; }
        .bike-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 15px; }
        .bike-card { background: #2a2a2a; border-radius: 12px; padding: 20px; border: 1px solid #333; transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); animation: fadeInUp 0.5s ease-out forwards; opacity: 0; position: relative; overflow: hidden; }
        .bike-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, #f5c518, transparent); opacity: 0; transition: opacity 0.4s; }
        .bike-card:hover { border-color: #f5c518; transform: translateY(-6px) scale(1.02); box-shadow: 0 12px 30px rgba(0,0,0,0.4); }
        .bike-card:hover::before { opacity: 1; }
        .bike-card .code { font-size: 20px; font-weight: 800; color: #f5c518; margin-bottom: 6px; }
        .bike-card .brand { font-size: 14px; color: #ccc; }
        .bike-card .model { font-size: 13px; color: #888; margin-bottom: 12px; }
        .bike-card .footer { display: flex; justify-content: space-between; align-items: center; margin-top: 12px; padding-top: 12px; border-top: 1px solid #333; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; transition: transform 0.2s; display: inline-block; }
        .badge:hover { transform: scale(1.1); }
        .badge-success { background: rgba(40, 167, 69, 0.2); color: #51cf66; }
        .badge-danger { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; }
        .badge-warning { background: rgba(245, 197, 24, 0.2); color: #f5c518; }
        .btn { padding: 8px 16px; background: #f5c518; color: #1a1a1a; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1); display: inline-block; position: relative; overflow: hidden; }
        .btn::after { content: ''; position: absolute; top: 50%; left: 50%; width: 0; height: 0; background: rgba(255,255,255,0.2); border-radius: 50%; transform: translate(-50%, -50%); transition: width 0.5s, height 0.5s; }
        .btn:hover::after { width: 200px; height: 200px; }
        .btn:hover { background: #e0b300; transform: translateY(-3px); box-shadow: 0 6px 20px rgba(245, 197, 24, 0.4); }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .empty { text-align: center; padding: 40px; color: #666; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('estaciones.index') }}" class="logo">BLAROS<span>BIKES</span></a>
        <div class="nav-links">
            <a href="{{ route('estaciones.index') }}">Estaciones</a>
            <a href="{{ route('users.index') }}">Usuarios</a>
        </div>
    </nav>

    <div class="container">
        <a href="{{ route('estaciones.index') }}" class="back-link">&larr; Volver a estaciones</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="header-card">
            <h1>{{ $estacion->nombre }}</h1>
            <div class="info">
                <strong>Ubicación:</strong> {{ $estacion->ubicacion }}<br>
                <strong>Capacidad:</strong> {{ $estacion->capacidad }} bicicletas
            </div>
        </div>

        @if($estacion->latitud && $estacion->longitud)
            <div id="map"></div>
        @endif

        <h2>Bicicletas en esta estación ({{ $estacion->bicicletas->count() }})</h2>

        @if($estacion->bicicletas->count() > 0)
            <div class="bike-grid">
                @foreach($estacion->bicicletas as $bici)
                    <div class="bike-card" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                        <div class="code">{{ $bici->codigo }}</div>
                        <div class="brand">{{ $bici->marca }} · {{ $bici->modelo }}</div>
                        @php $bat = $bici->bateria_real; @endphp
                        <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; background: #444; border-radius: 10px; height: 6px; overflow: hidden;">
                                <div style="height: 100%; border-radius: 10px; width: {{ $bat }}%; background: {{ $bat >= 100 ? '#51cf66' : ($bat > 50 ? '#7bc96f' : ($bat > 20 ? '#f5c518' : '#ff6b6b')) }};"></div>
                            </div>
                            <span style="font-size: 11px; color: {{ $bat >= 100 ? '#51cf66' : ($bat > 50 ? '#7bc96f' : ($bat > 20 ? '#f5c518' : '#ff6b6b')) }};">{{ $bat }}%</span>
                        </div>
                        <div class="footer">
                            @if($bici->estado === 'disponible')
                                <span class="badge badge-success">Disponible</span>
                            @elseif($bici->estado === 'no-disponible')
                                <span class="badge badge-danger">No disponible</span>
                            @else
                                <span class="badge badge-warning">En mantenimiento</span>
                            @endif
                            <a href="{{ route('bicicletas.show', $bici->id) }}" class="btn btn-sm">Ver detalle</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty">No hay bicicletas en esta estación.</div>
        @endif
    </div>

    @if($estacion->latitud && $estacion->longitud)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            const map = L.map('map').setView([{{ $estacion->latitud }}, {{ $estacion->longitud }}], 16);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 19
            }).addTo(map);
            const bikeSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h3"/></svg>`;
            const bikeIcon = L.divIcon({
                html: `<div style="background:#f5c518;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 20px rgba(245,197,24,0.6);border:2px solid #e0b300;animation:pulse 2s ease-in-out infinite;">${bikeSvg}</div>`,
                className: '', iconSize: [36, 36], iconAnchor: [18, 18]
            });
            L.marker([{{ $estacion->latitud }}, {{ $estacion->longitud }}], {icon: bikeIcon}).addTo(map)
                .bindPopup('<strong style="color:#f5c518;">{{ $estacion->nombre }}</strong><br>{{ $estacion->ubicacion }}').openPopup();
        </script>
        <style>@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.15); } }</style>
    @endif
</body>
</html>
