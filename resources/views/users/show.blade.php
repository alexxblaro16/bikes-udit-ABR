<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAROSBIKES — {{ $user->name }}</title>
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
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.8); } to { opacity: 1; transform: scale(1); } }
        @keyframes countUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Perfil */
        .profile-header { background: #2a2a2a; border-radius: 16px; padding: 35px; margin-bottom: 25px; animation: fadeInUp 0.6s ease-out; display: flex; gap: 30px; align-items: center; border: 1px solid #333; position: relative; overflow: hidden; }
        .profile-header::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f5c518, #e0b300, #f5c518); }
        .avatar-large { width: 100px; height: 100px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 800; color: #1a1a1a; flex-shrink: 0; background: linear-gradient(135deg, #f5c518, #e0b300); box-shadow: 0 0 30px rgba(245, 197, 24, 0.3); animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards; opacity: 0; }
        .profile-info h1 { color: #f5c518; font-size: 28px; font-weight: 800; margin-bottom: 4px; }
        .profile-info .details { color: #999; font-size: 14px; line-height: 1.8; }
        .profile-info .details strong { color: #ccc; }
        .profile-info .badge-nacionalidad { background: rgba(245, 197, 24, 0.15); color: #f5c518; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; margin-top: 6px; }

        /* Stats grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-bottom: 30px; }
        .stat-box { background: #2a2a2a; border-radius: 12px; padding: 20px; text-align: center; border: 1px solid #333; transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); animation: scaleIn 0.5s ease-out forwards; opacity: 0; }
        .stat-box:nth-child(1) { animation-delay: 0.1s; }
        .stat-box:nth-child(2) { animation-delay: 0.15s; }
        .stat-box:nth-child(3) { animation-delay: 0.2s; }
        .stat-box:nth-child(4) { animation-delay: 0.25s; }
        .stat-box:nth-child(5) { animation-delay: 0.3s; }
        .stat-box:nth-child(6) { animation-delay: 0.35s; }
        .stat-box:hover { transform: translateY(-4px); border-color: #f5c518; box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        .stat-box .icon { font-size: 24px; margin-bottom: 8px; }
        .stat-box .value { font-size: 28px; font-weight: 800; color: #f5c518; animation: countUp 0.6s ease-out; }
        .stat-box .label { font-size: 12px; color: #888; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Tabla trayectos */
        h2 { color: #e0e0e0; font-size: 18px; margin: 25px 0 15px; font-weight: 600; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; background: #2a2a2a; border-radius: 8px; overflow: hidden; }
        th { padding: 14px 16px; text-align: left; background: #333; color: #f5c518; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        td { padding: 12px 16px; border-bottom: 1px solid #333; font-size: 13px; transition: all 0.2s; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(245, 197, 24, 0.05); }
        tr.activo td { background: rgba(245, 197, 24, 0.08); }
        td a { color: #f5c518; text-decoration: none; }
        td a:hover { text-shadow: 0 0 8px rgba(245, 197, 24, 0.4); }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-success { background: rgba(40, 167, 69, 0.2); color: #51cf66; }
        .badge-warning { background: rgba(245, 197, 24, 0.2); color: #f5c518; }
        .empty { text-align: center; padding: 40px; color: #666; }
        .fav-btn { background: none; border: none; cursor: pointer; font-size: 20px; transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1); }
        .fav-btn:hover { transform: scale(1.3); }
        .fav-btn.active { color: #f5c518; text-shadow: 0 0 10px rgba(245, 197, 24, 0.5); }

        .btn { padding: 10px 20px; background: #f5c518; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: 600; transition: all 0.3s; display: inline-block; }
        .btn:hover { background: #e0b300; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(245, 197, 24, 0.3); }
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
        <a href="{{ route('users.index') }}" class="back-link">&larr; Volver a usuarios</a>

        <div class="profile-header">
            @if($user->perfil && $user->perfil->foto)
                <img src="{{ $user->perfil->foto }}" class="avatar-large" style="object-fit: cover;">
            @else
                <div class="avatar-large">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            @endif
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <div class="details">
                    <strong>Email:</strong> {{ $user->email }}<br>
                    @if($user->perfil)
                        <strong>ID:</strong> {{ $user->perfil->matricula }}<br>
                        <strong>Edad:</strong> {{ $user->perfil->edad }} años<br>
                        <strong>Teléfono:</strong> {{ $user->perfil->telefono ?? 'No registrado' }}<br>
                        <span class="badge-nacionalidad">{{ $user->perfil->nacionalidad }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f5c518" stroke-width="2" width="28" height="28"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div class="value">{{ $totalTrayectos }}</div>
                <div class="label">Trayectos</div>
            </div>
            <div class="stat-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#51cf66" stroke-width="2" width="28" height="28"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="value">{{ number_format($kmEstimados, 1) }}</div>
                <div class="label">Km recorridos</div>
            </div>
            <div class="stat-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#66d9ef" stroke-width="2" width="28" height="28"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="value">{{ $tiempoTotal >= 60 ? floor($tiempoTotal/60) . 'h ' . ($tiempoTotal%60) . 'm' : $tiempoTotal . ' min' }}</div>
                <div class="label">Tiempo pedaleando</div>
            </div>
            <div class="stat-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#a9dc76" stroke-width="2" width="28" height="28"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M7 12l2.5 2.5L17 7"/></svg>
                </div>
                <div class="value">{{ $co2Ahorrado }} kg</div>
                <div class="label">CO₂ ahorrado</div>
            </div>
            <div class="stat-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#ff6b6b" stroke-width="2" width="28" height="28"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <div class="value">{{ number_format($caloriasQuemadas) }}</div>
                <div class="label">Calorías quemadas</div>
            </div>
            <div class="stat-box">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#f5c518" stroke-width="2" width="28" height="28"><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="18.5" cy="17.5" r="3.5"/><path d="M15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3 11.5V14l-3-3 4-3 2 3h3"/></svg>
                </div>
                <div class="value">{{ $trayectosFinalizados->pluck('bicicleta_id')->unique()->count() }}</div>
                <div class="label">Bicis usadas</div>
            </div>
        </div>

        <h2>Historial de trayectos</h2>

        @if($user->trayectos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Bicicleta</th>
                        <th>Salida</th>
                        <th>Llegada</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->trayectos->sortByDesc('started_at')->take(20) as $trayecto)
                        <tr class="{{ $trayecto->ended_at ? '' : 'activo' }}">
                            <td><a href="{{ route('bicicletas.show', $trayecto->bicicleta->id) }}">{{ $trayecto->bicicleta->codigo }}</a></td>
                            <td>{{ $trayecto->estacionInicio->nombre }}</td>
                            <td>{{ $trayecto->estacionFin ? $trayecto->estacionFin->nombre : '—' }}</td>
                            <td>{{ $trayecto->started_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($trayecto->ended_at)
                                    {{ $trayecto->started_at->diffForHumans($trayecto->ended_at, true) }}
                                @else
                                    {{ $trayecto->started_at->diffForHumans(now(), true) }}
                                @endif
                            </td>
                            <td>
                                @if($trayecto->ended_at)
                                    <span class="badge badge-success">Finalizado</span>
                                @else
                                    <span class="badge badge-warning">En curso</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('trayectos.favorito', $trayecto->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:none;border:none;cursor:pointer;font-size:18px;transition:transform 0.3s;{{ $trayecto->favorito ? 'transform:scale(1.2);' : 'opacity:0.4;' }}" title="{{ $trayecto->favorito ? 'Quitar de favoritos' : 'Añadir a favoritos' }}">
                                        {{ $trayecto->favorito ? '★' : '☆' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($user->trayectos->count() > 20)
                <p style="text-align: center; color: #888; margin-top: 15px; font-size: 13px;">Mostrando los 20 trayectos más recientes de {{ $user->trayectos->count() }} totales</p>
            @endif
        @else
            <div class="empty">Este usuario no tiene trayectos registrados.</div>
        @endif
    </div>
</body>
</html>


