<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAROSBIKES — Estaciones</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #1a1a1a; color: #e0e0e0; min-height: 100vh; }

        /* Navbar */
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

        /* Animaciones */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fadeInRight { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @keyframes glow { 0%, 100% { box-shadow: 0 0 5px rgba(245, 197, 24, 0.2); } 50% { box-shadow: 0 0 25px rgba(245, 197, 24, 0.5); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        @keyframes borderGlow { 0%, 100% { border-color: #333; } 50% { border-color: rgba(245, 197, 24, 0.4); } }

        .fade-in { animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; opacity: 0; }
        .fade-in:nth-child(1) { animation-delay: 0.1s; }
        .fade-in:nth-child(2) { animation-delay: 0.2s; }
        .fade-in:nth-child(3) { animation-delay: 0.3s; }

        h1 { color: #f5c518; font-size: 32px; margin-bottom: 5px; font-weight: 800; animation: fadeInLeft 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
        .subtitle { color: #888; font-size: 13px; margin-bottom: 25px; animation: fadeInLeft 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.1s forwards; opacity: 0; }

        /* Alertas */
        .alert { padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; font-size: 14px; animation: slideIn 0.4s ease-out; }
        .alert-success { background: rgba(245, 197, 24, 0.15); color: #f5c518; border: 1px solid rgba(245, 197, 24, 0.3); }
        .alert-error { background: rgba(220, 53, 69, 0.15); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.3); }

        /* Stats */
        .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px; }
        .stat-card { background: #2a2a2a; border-radius: 12px; padding: 22px; border-left: 4px solid #f5c518; transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); cursor: default; position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(245,197,24,0.05) 0%, transparent 60%); opacity: 0; transition: opacity 0.4s; }
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.4); }
        .stat-card:hover::before { opacity: 1; }
        .stat-card .number { font-size: 36px; font-weight: 800; color: #f5c518; transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); position: relative; }
        .stat-card:hover .number { transform: scale(1.15); text-shadow: 0 0 20px rgba(245, 197, 24, 0.4); }
        .stat-card .label { font-size: 13px; color: #888; margin-top: 4px; transition: color 0.3s; }
        .stat-card:hover .label { color: #bbb; }

        /* Mapa */
        #map { width: 100%; height: 400px; border-radius: 12px; margin-bottom: 25px; border: 2px solid #333; animation: fadeInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.3s forwards; opacity: 0; transition: border-color 0.3s; }
        #map:hover { border-color: rgba(245, 197, 24, 0.4); }

        /* Tabla */
        table { width: 100%; border-collapse: separate; border-spacing: 0; background: #2a2a2a; border-radius: 8px; overflow: hidden; }
        th { padding: 14px 16px; text-align: left; background: #333; color: #f5c518; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        td { padding: 14px 16px; border-bottom: 1px solid #333; font-size: 14px; transition: all 0.2s; }
        tr:last-child td { border-bottom: none; }
        tr { transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1); }
        tr:hover { transform: scale(1.01); }
        tr:hover td { background: rgba(245, 197, 24, 0.08); padding-left: 22px; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; transition: transform 0.2s; display: inline-block; }
        .badge:hover { transform: scale(1.1); }
        .badge-success { background: rgba(40, 167, 69, 0.2); color: #51cf66; }
        .badge-danger { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; }
        .btn { padding: 8px 16px; background: #f5c518; color: #1a1a1a; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1); display: inline-block; position: relative; overflow: hidden; }
        .btn::after { content: ''; position: absolute; top: 50%; left: 50%; width: 0; height: 0; background: rgba(255,255,255,0.2); border-radius: 50%; transform: translate(-50%, -50%); transition: width 0.5s, height 0.5s; }
        .btn:hover::after { width: 200px; height: 200px; }
        .btn:hover { background: #e0b300; transform: translateY(-3px); box-shadow: 0 6px 20px rgba(245, 197, 24, 0.4); }
        .btn:active { transform: translateY(-1px); }
        .progress-bar { width: 100%; background: #444; border-radius: 10px; height: 8px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #f5c518, #e0b300, #f5c518); background-size: 200% 100%; border-radius: 10px; transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1); animation: shimmer 3s linear infinite; }
        .empty { text-align: center; padding: 60px; color: #666; font-size: 16px; }

        /* Buscador */
        .search-wrapper { position: relative; margin-bottom: 25px; animation: fadeInUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.15s forwards; opacity: 0; }
        .search-input { width: 100%; padding: 16px 20px 16px 50px; background: #2a2a2a; border: 2px solid #333; border-radius: 12px; color: #e0e0e0; font-size: 16px; font-family: 'Inter', sans-serif; outline: none; transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); }
        .search-input::placeholder { color: #666; }
        .search-input:focus { border-color: #f5c518; box-shadow: 0 0 25px rgba(245, 197, 24, 0.15); background: #333; }
        .search-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); transition: all 0.3s; }
        .search-input:focus ~ .search-icon svg { stroke: #f5c518; }
        .search-clear { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #666; font-size: 20px; cursor: pointer; transition: all 0.3s; display: none; width: 28px; height: 28px; border-radius: 50%; display: none; align-items: center; justify-content: center; }
        .search-clear:hover { color: #f5c518; background: rgba(245, 197, 24, 0.1); }
        .search-clear.visible { display: flex; }
        .search-count { font-size: 12px; color: #888; margin-top: 8px; transition: all 0.3s; }
        .search-count span { color: #f5c518; font-weight: 600; }
        .highlight { background: rgba(245, 197, 24, 0.3); color: #f5c518; padding: 1px 2px; border-radius: 3px; }
        tr.hidden-row { display: none; }
        tr.match-row { animation: slideIn 0.3s ease-out; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-10px); } to { opacity: 1; transform: translateX(0); } }
        .no-results { text-align: center; padding: 40px; color: #666; display: none; }
        .no-results .icon { font-size: 48px; margin-bottom: 10px; opacity: 0.3; }
        .no-results p { font-size: 15px; }
        .no-results .suggestion { color: #f5c518; font-weight: 500; margin-top: 8px; font-size: 13px; }
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
        <h1>Estaciones</h1>
        <p class="subtitle">Red de estaciones de bicicletas del campus (caché 60s)</p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($estaciones->count() > 0)
            @php
                $totalBicis = $estaciones->sum(fn($e) => $e->bicicletas->count());
                $totalDisponibles = $estaciones->sum(fn($e) => $e->bicicletas->where('estado', 'disponible')->count());
            @endphp

            <div class="stats-row">
                <div class="stat-card fade-in">
                    <div class="number">{{ $estaciones->count() }}</div>
                    <div class="label">Estaciones activas</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="number">{{ $totalBicis }}</div>
                    <div class="label">Bicicletas totales</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="number">{{ $totalDisponibles }}</div>
                    <div class="label">Disponibles ahora</div>
                </div>
            </div>

            <div id="map"></div>

            <div class="search-wrapper">
                <input type="text" class="search-input" id="searchInput" placeholder="Buscar estación... (ej: Vicálvaro, Sol, Suanzes, Vallecas...)" autocomplete="off">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <button class="search-clear" id="searchClear" title="Limpiar">&times;</button>
                <div class="search-count" id="searchCount"></div>
            </div>

            <div class="no-results" id="noResults">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="1.5" width="48" height="48"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                </div>
                <p>No se encontraron estaciones</p>
                <p class="suggestion" id="searchSuggestion"></p>
            </div>

            <table id="stationsTable">
                <thead>
                    <tr>
                        <th>Estación</th>
                        <th>Ubicación</th>
                        <th>Capacidad</th>
                        <th>Disponibilidad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estaciones as $estacion)
                        @php
                            $disponibles = $estacion->bicicletas->where('estado', 'disponible')->count();
                            $total = $estacion->bicicletas->count();
                            $porcentaje = $total > 0 ? round(($disponibles / $total) * 100) : 0;
                        @endphp
                        <tr class="station-row" data-nombre="{{ strtolower($estacion->nombre) }}" data-ubicacion="{{ strtolower($estacion->ubicacion) }}" style="animation: fadeInUp 0.5s ease-out {{ min(0.1 * $loop->index, 2) }}s forwards; opacity: 0;">
                            <td style="font-weight: 600;" class="cell-nombre">{{ $estacion->nombre }}</td>
                            <td style="color: #999;" class="cell-ubicacion">{{ $estacion->ubicacion }}</td>
                            <td>{{ $estacion->capacidad }}</td>
                            <td style="min-width: 180px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span class="badge {{ $disponibles > 0 ? 'badge-success' : 'badge-danger' }}">{{ $disponibles }}/{{ $total }}</span>
                                    <div class="progress-bar" style="flex: 1;">
                                        <div class="progress-fill" style="width: {{ $porcentaje }}%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('estaciones.show', $estacion->id) }}" class="btn">Ver detalle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                const bikeSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h3"/></svg>`;

                const map = L.map('map').setView([40.4300, -3.6600], 12);
                L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OpenStreetMap &copy; CARTO',
                    maxZoom: 19
                }).addTo(map);

                const bikeIcon = L.divIcon({
                    html: `<div style="background:#f5c518;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 0 15px rgba(245,197,24,0.6);border:2px solid #e0b300;">${bikeSvg}</div>`,
                    className: '',
                    iconSize: [32, 32],
                    iconAnchor: [16, 16],
                    popupAnchor: [0, -16]
                });

                @foreach($estaciones as $estacion)
                    @if($estacion->latitud && $estacion->longitud)
                        @php
                            $disp = $estacion->bicicletas->where('estado', 'disponible')->count();
                            $tot = $estacion->bicicletas->count();
                        @endphp
                        L.marker([{{ $estacion->latitud }}, {{ $estacion->longitud }}], {icon: bikeIcon})
                            .addTo(map)
                            .bindPopup('<div style="font-family:Inter,sans-serif;"><strong style="color:#f5c518;">{{ $estacion->nombre }}</strong><br>{{ $estacion->ubicacion }}<br><br><span style="color:#51cf66;font-weight:bold;">{{ $disp }}/{{ $tot }}</span> bicis disponibles<br><a href="{{ route("estaciones.show", $estacion->id) }}" style="color:#f5c518;">Ver detalle →</a></div>');
                    @endif
                @endforeach

                // ─── Buscador inteligente ───
                const searchInput = document.getElementById('searchInput');
                const searchClear = document.getElementById('searchClear');
                const searchCount = document.getElementById('searchCount');
                const noResults = document.getElementById('noResults');
                const searchSuggestion = document.getElementById('searchSuggestion');
                const rows = document.querySelectorAll('.station-row');
                const table = document.getElementById('stationsTable');

                // Quitar tildes para búsqueda fuzzy
                function normalize(str) {
                    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
                }

                // Highlight del texto que coincide
                function highlightText(text, query) {
                    if (!query) return text;
                    const normText = normalize(text);
                    const normQuery = normalize(query);
                    const idx = normText.indexOf(normQuery);
                    if (idx === -1) return text;
                    const before = text.substring(0, idx);
                    const match = text.substring(idx, idx + query.length);
                    const after = text.substring(idx + query.length);
                    return `${before}<span class="highlight">${match}</span>${after}`;
                }

                // Nombres de zonas para sugerencias
                const zonas = ['Vicálvaro', 'Suanzes', 'Sol', 'Vallecas', 'Salamanca', 'Moncloa', 'Latina', 'Pozuelo', 'Moratalaz', 'Ventas', 'San Blas', 'Las Rosas', 'Atocha', 'Cibeles', 'Chueca', 'Malasaña', 'La Elipa', 'Canillejas', 'Retiro', 'Ciudad Lineal'];

                let searchTimeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const query = this.value.trim();
                        const normQuery = normalize(query);

                        searchClear.classList.toggle('visible', query.length > 0);

                        if (!query) {
                            rows.forEach(r => {
                                r.classList.remove('hidden-row', 'match-row');
                                r.querySelector('.cell-nombre').innerHTML = r.querySelector('.cell-nombre').textContent;
                                r.querySelector('.cell-ubicacion').innerHTML = r.querySelector('.cell-ubicacion').textContent;
                            });
                            searchCount.innerHTML = '';
                            noResults.style.display = 'none';
                            table.style.display = '';
                            return;
                        }

                        let matches = 0;
                        rows.forEach(r => {
                            const nombre = r.getAttribute('data-nombre');
                            const ubicacion = r.getAttribute('data-ubicacion');
                            const normNombre = normalize(nombre);
                            const normUbicacion = normalize(ubicacion);

                            if (normNombre.includes(normQuery) || normUbicacion.includes(normQuery)) {
                                r.classList.remove('hidden-row');
                                r.classList.add('match-row');
                                r.querySelector('.cell-nombre').innerHTML = highlightText(r.querySelector('.cell-nombre').textContent, query);
                                r.querySelector('.cell-ubicacion').innerHTML = highlightText(r.querySelector('.cell-ubicacion').textContent, query);
                                matches++;
                            } else {
                                r.classList.add('hidden-row');
                                r.classList.remove('match-row');
                            }
                        });

                        if (matches > 0) {
                            searchCount.innerHTML = `<span>${matches}</span> estación${matches !== 1 ? 'es' : ''} encontrada${matches !== 1 ? 's' : ''}`;
                            noResults.style.display = 'none';
                            table.style.display = '';
                        } else {
                            searchCount.innerHTML = '';
                            table.style.display = 'none';
                            noResults.style.display = 'block';
                            // Sugerir zona parecida
                            const closest = zonas.find(z => normalize(z).includes(normQuery.substring(0, 3)));
                            searchSuggestion.textContent = closest ? `¿Quizás buscabas "${closest}"?` : 'Prueba con otro nombre de barrio o zona';
                        }
                    }, 150); // Debounce 150ms
                });

                searchClear.addEventListener('click', function () {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                    searchInput.focus();
                });

                // Atajo: Ctrl+K o / para enfocar buscador
                document.addEventListener('keydown', function (e) {
                    if ((e.ctrlKey && e.key === 'k') || (e.key === '/' && document.activeElement !== searchInput)) {
                        e.preventDefault();
                        searchInput.focus();
                    }
                    if (e.key === 'Escape' && document.activeElement === searchInput) {
                        searchInput.value = '';
                        searchInput.dispatchEvent(new Event('input'));
                        searchInput.blur();
                    }
                });
            </script>
        @else
            <div class="empty">No hay estaciones registradas.</div>
        @endif
    </div>
</body>
</html>


