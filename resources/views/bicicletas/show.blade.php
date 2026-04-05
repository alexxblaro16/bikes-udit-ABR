<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAROSBIKES — {{ $bicicleta->codigo }}</title>
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
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.15); } }
        h1 { color: #f5c518; font-size: 28px; margin-bottom: 5px; font-weight: 800; }
        h2 { color: #e0e0e0; font-size: 18px; margin: 25px 0 15px; font-weight: 600; }
        .alert { padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; font-size: 14px; animation: slideIn 0.4s ease-out; }
        .alert-success { background: rgba(245, 197, 24, 0.15); color: #f5c518; border: 1px solid rgba(245, 197, 24, 0.3); }
        .alert-error { background: rgba(220, 53, 69, 0.15); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.3); }

        .detail-card { background: #2a2a2a; border-radius: 12px; padding: 30px; border-left: 4px solid #f5c518; margin-bottom: 25px; animation: fadeInUp 0.5s ease-out; }
        .bike-icon { font-size: 48px; margin-bottom: 10px; animation: float 3s ease-in-out infinite; display: inline-block; }
        .detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-top: 20px; }
        .detail-item .label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 4px; }
        .detail-item .value { font-size: 16px; font-weight: 600; color: #e0e0e0; }
        .detail-item .value a { color: #f5c518; text-decoration: none; transition: all 0.2s; }
        .detail-item .value a:hover { text-shadow: 0 0 10px rgba(245, 197, 24, 0.5); }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; transition: all 0.3s; display: inline-block; }
        .badge:hover { transform: scale(1.1); }
        .badge-success { background: rgba(40, 167, 69, 0.2); color: #51cf66; }
        .badge-danger { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; }
        .badge-warning { background: rgba(245, 197, 24, 0.2); color: #f5c518; }
        .badge-info { background: rgba(23, 162, 184, 0.2); color: #66d9ef; }

        #map { width: 100%; height: 250px; border-radius: 8px; margin-bottom: 25px; border: 2px solid #333; animation: fadeInUp 0.6s ease-out 0.2s forwards; opacity: 0; }
        .map-label { font-size: 12px; color: #888; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
        .transit-box { background: #2a2a2a; border-radius: 8px; padding: 30px; text-align: center; margin-bottom: 25px; border: 1px dashed #f5c518; animation: fadeInUp 0.6s ease-out; }
        .transit-box .icon { font-size: 40px; animation: float 2s ease-in-out infinite; display: inline-block; }
        .transit-box p { color: #f5c518; font-weight: 600; margin-top: 10px; }

        table { width: 100%; border-collapse: separate; border-spacing: 0; background: #2a2a2a; border-radius: 8px; overflow: hidden; }
        th { padding: 14px 16px; text-align: left; background: #333; color: #f5c518; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        td { padding: 14px 16px; border-bottom: 1px solid #333; font-size: 14px; transition: all 0.2s; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(245, 197, 24, 0.05); padding-left: 20px; }
        td a { color: #f5c518; text-decoration: none; transition: all 0.2s; }
        td a:hover { text-shadow: 0 0 8px rgba(245, 197, 24, 0.4); }
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
        <a href="javascript:history.back()" class="back-link">&larr; Volver</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="detail-card">
            <div class="bike-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f5c518" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="48" height="48"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h3"/></svg>
            </div>
            <h1>{{ $bicicleta->codigo }}</h1>
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="label">Marca</div>
                    <div class="value">{{ $bicicleta->marca }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Modelo</div>
                    <div class="value">{{ $bicicleta->modelo }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Estación actual</div>
                    <div class="value">
                        @if($bicicleta->estacion)
                            <a href="{{ route('estaciones.show', $bicicleta->estacion->id) }}">{{ $bicicleta->estacion->nombre }}</a>
                        @else
                            <span class="badge badge-info">En tránsito</span>
                        @endif
                    </div>
                </div>
                <div class="detail-item">
                    <div class="label">Estado</div>
                    <div class="value">
                        @if($bicicleta->estado === 'disponible')
                            <span class="badge badge-success">Disponible</span>
                        @elseif($bicicleta->estado === 'no-disponible')
                            <span class="badge badge-danger">No disponible</span>
                        @else
                            <span class="badge badge-warning">En mantenimiento</span>
                        @endif
                    </div>
                </div>
                <div class="detail-item">
                    <div class="label">Batería</div>
                    <div class="value">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @php $bat = $bicicleta->bateria_real; @endphp
                            <div style="width: 100px; background: #444; border-radius: 10px; height: 10px; overflow: hidden;">
                                <div style="height: 100%; border-radius: 10px; width: {{ $bat }}%; background: {{ $bat >= 100 ? '#51cf66' : ($bat > 50 ? '#7bc96f' : ($bat > 20 ? '#f5c518' : '#ff6b6b')) }};"></div>
                            </div>
                            <span style="font-size: 14px; font-weight: 600; color: {{ $bat >= 100 ? '#51cf66' : ($bat > 50 ? '#7bc96f' : ($bat > 20 ? '#f5c518' : '#ff6b6b')) }};">{{ $bat }}%</span>
                        </div>
                        <div style="font-size: 12px; color: #888; margin-top: 4px;">~{{ $bicicleta->tiempo_restante }} de autonomía</div>
                    </div>
                </div>
            </div>
        </div>

        @if($bicicleta->estacion && $bicicleta->estacion->latitud && $bicicleta->estacion->longitud)
            <p class="map-label">Ubicación actual de la bicicleta</p>
            <div id="map"></div>
        @elseif(!$bicicleta->estacion)
            <div class="transit-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f5c518" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="48" height="48"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h3"/></svg>
                </div>
                <p>Esta bicicleta está en tránsito</p>
            </div>
        @endif

        <h2>Historial de trayectos</h2>

        @if($bicicleta->trayectos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Salida</th>
                        <th>Llegada</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bicicleta->trayectos->sortByDesc('started_at') as $trayecto)
                        <tr style="animation: fadeInUp 0.4s ease-out {{ 0.08 * $loop->index }}s forwards; opacity: 0;">
                            <td><a href="{{ route('trayectos.index', $trayecto->user->id) }}">{{ $trayecto->user->name }}</a></td>
                            <td>{{ $trayecto->estacionInicio->nombre }}</td>
                            <td>{{ $trayecto->estacionFin ? $trayecto->estacionFin->nombre : '—' }}</td>
                            <td>{{ $trayecto->started_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $trayecto->ended_at ? $trayecto->ended_at->format('d/m/Y H:i') : '—' }}</td>
                            <td>
                                @if($trayecto->ended_at)
                                    <span class="badge badge-success">Finalizado</span>
                                @else
                                    <span class="badge badge-warning">En curso</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">Esta bicicleta no tiene trayectos registrados.</div>
        @endif
    </div>

    @if($bicicleta->estacion && $bicicleta->estacion->latitud && $bicicleta->estacion->longitud)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            const map = L.map('map').setView([{{ $bicicleta->estacion->latitud }}, {{ $bicicleta->estacion->longitud }}], 16);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 19
            }).addTo(map);
            const bikeSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="22" height="22"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h3"/></svg>`;
            const bikeIcon = L.divIcon({
                html: `<div style="background:#f5c518;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 25px rgba(245,197,24,0.7);border:3px solid #e0b300;">${bikeSvg}</div>`,
                className: '', iconSize: [40, 40], iconAnchor: [20, 20]
            });
            L.marker([{{ $bicicleta->estacion->latitud }}, {{ $bicicleta->estacion->longitud }}], {icon: bikeIcon}).addTo(map)
                .bindPopup('<strong style="color:#f5c518;">{{ $bicicleta->codigo }}</strong><br>{{ $bicicleta->estacion->nombre }}').openPopup();
        </script>
    @endif
</body>
</html>

