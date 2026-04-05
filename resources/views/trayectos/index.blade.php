<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAROSBIKES — Trayectos de {{ $user->name }}</title>
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
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-3px); } 75% { transform: translateX(3px); } }
        h1 { color: #f5c518; font-size: 28px; margin-bottom: 5px; font-weight: 800; }
        h2 { color: #e0e0e0; font-size: 18px; margin: 25px 0 15px; font-weight: 600; }
        .alert { padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; font-size: 14px; animation: slideIn 0.4s ease-out; }
        .alert-success { background: rgba(245, 197, 24, 0.15); color: #f5c518; border: 1px solid rgba(245, 197, 24, 0.3); }
        .alert-error { background: rgba(220, 53, 69, 0.15); color: #ff6b6b; border: 1px solid rgba(220, 53, 69, 0.3); animation: shake 0.4s ease-out; }

        .user-card { background: #2a2a2a; border-radius: 12px; padding: 25px; border-left: 4px solid #f5c518; margin-bottom: 25px; animation: fadeInUp 0.5s ease-out; display: flex; align-items: center; gap: 20px; }
        .user-avatar { width: 60px; height: 60px; background: linear-gradient(135deg, #f5c518, #e0b300); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; color: #1a1a1a; flex-shrink: 0; }
        .user-info { flex: 1; }
        .user-info .info { color: #999; font-size: 13px; line-height: 1.8; margin-top: 5px; }
        .user-info .info strong { color: #ccc; }

        .action-box { background: #2a2a2a; border-radius: 12px; padding: 25px; margin-bottom: 25px; border: 1px solid #333; animation: fadeInUp 0.6s ease-out 0.1s forwards; opacity: 0; transition: all 0.3s; }
        .action-box:hover { border-color: #f5c518; }
        .action-box.active-trip { border-color: #f5c518; background: rgba(245, 197, 24, 0.05); }
        .action-box.active-trip .live-dot { width: 8px; height: 8px; background: #f5c518; border-radius: 50%; display: inline-block; animation: blink 1.5s ease-in-out infinite; margin-right: 6px; }
        .action-box.new-trip { border-color: #51cf66; background: rgba(40, 167, 69, 0.03); }
        .action-box h3 { font-size: 16px; margin-bottom: 12px; font-weight: 700; }
        .action-box.active-trip h3 { color: #f5c518; }
        .action-box.new-trip h3 { color: #51cf66; }
        .action-box p { font-size: 14px; color: #bbb; margin-bottom: 15px; }
        .form-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .form-row select { padding: 10px 14px; border: 1px solid #444; border-radius: 6px; background: #333; color: #e0e0e0; font-size: 14px; font-family: 'Inter', sans-serif; min-width: 200px; transition: all 0.3s; }
        .form-row select:focus { outline: none; border-color: #f5c518; box-shadow: 0 0 10px rgba(245, 197, 24, 0.2); }
        .form-row label { font-weight: 500; color: #999; font-size: 13px; }

        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; transition: all 0.3s; display: inline-block; }
        .badge:hover { transform: scale(1.1); }
        .badge-success { background: rgba(40, 167, 69, 0.2); color: #51cf66; }
        .badge-danger { background: rgba(220, 53, 69, 0.2); color: #ff6b6b; }
        .badge-warning { background: rgba(245, 197, 24, 0.2); color: #f5c518; }
        .btn { padding: 10px 20px; background: #f5c518; color: #1a1a1a; text-decoration: none; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.3s; display: inline-block; font-family: 'Inter', sans-serif; }
        .btn:hover { background: #e0b300; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(245, 197, 24, 0.3); }
        .btn-green { background: #51cf66; }
        .btn-green:hover { background: #40c057; box-shadow: 0 4px 15px rgba(81, 207, 102, 0.3); }

        table { width: 100%; border-collapse: separate; border-spacing: 0; background: #2a2a2a; border-radius: 8px; overflow: hidden; }
        th { padding: 14px 16px; text-align: left; background: #333; color: #f5c518; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        td { padding: 14px 16px; border-bottom: 1px solid #333; font-size: 14px; transition: all 0.2s; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(245, 197, 24, 0.05); padding-left: 20px; }
        tr.activo td { background: rgba(245, 197, 24, 0.08); }
        tr.activo:hover td { background: rgba(245, 197, 24, 0.12); }
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
        <a href="{{ route('estaciones.index') }}" class="back-link">&larr; Volver a estaciones</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div class="user-info">
                <h1>{{ $user->name }}</h1>
                <div class="info">
                    <strong>Email:</strong> {{ $user->email }}
                    @if($user->perfil)
                        <br><strong>Matrícula:</strong> {{ $user->perfil->matricula }}
                        <br><strong>Teléfono:</strong> {{ $user->perfil->telefono ?? 'No registrado' }}
                    @endif
                </div>
            </div>
        </div>

        @php
            $trayectoActivo = $user->trayectos->whereNull('ended_at')->first();
        @endphp

        @if($trayectoActivo)
            <div class="action-box active-trip">
                <h3><span class="live-dot"></span> Trayecto en curso</h3>
                <p>
                    Bicicleta <strong>{{ $trayectoActivo->bicicleta->codigo }}</strong>
                    desde <strong>{{ $trayectoActivo->estacionInicio->nombre }}</strong>
                    — {{ $trayectoActivo->started_at->format('d/m/Y H:i') }}
                    (hace {{ $trayectoActivo->started_at->diffForHumans(now(), true) }})
                </p>
                <form method="POST" action="{{ route('trayectos.finalizar', $trayectoActivo->id) }}" class="form-row">
                    @csrf
                    <label>Devolver en:</label>
                    <select name="estacion_fin_id" required>
                        <option value="">Seleccionar estación</option>
                        @foreach($estaciones as $est)
                            <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn">Finalizar trayecto</button>
                </form>
            </div>
        @else
            <div class="action-box new-trip">
                <h3>Iniciar nuevo trayecto</h3>
                <form method="POST" action="{{ route('trayectos.iniciar') }}" class="form-row">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <label>Estación:</label>
                    <select name="estacion_id" id="estacion_select" required>
                        <option value="">Seleccionar estación</option>
                        @foreach($estaciones as $est)
                            <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                        @endforeach
                    </select>
                    <label>Bicicleta:</label>
                    <select name="bicicleta_id" id="bicicleta_select" required>
                        <option value="">Primero selecciona estación</option>
                    </select>
                    <button type="submit" class="btn btn-green">Iniciar trayecto</button>
                </form>
            </div>

            <script>
                const bicicletasPorEstacion = @json(
                    $estaciones->mapWithKeys(function ($est) {
                        return [$est->id => \App\Models\Bicicleta::where('estacion_id', $est->id)
                            ->where('estado', 'disponible')
                            ->get(['id', 'codigo', 'marca', 'modelo'])];
                    })
                );

                document.getElementById('estacion_select').addEventListener('change', function () {
                    const estacionId = this.value;
                    const biciSelect = document.getElementById('bicicleta_select');
                    biciSelect.innerHTML = '<option value="">Seleccionar bicicleta</option>';

                    if (estacionId && bicicletasPorEstacion[estacionId]) {
                        bicicletasPorEstacion[estacionId].forEach(function (bici) {
                            const option = document.createElement('option');
                            option.value = bici.id;
                            option.textContent = bici.codigo + ' — ' + bici.marca + ' ' + bici.modelo;
                            biciSelect.appendChild(option);
                        });
                    }
                });
            </script>
        @endif

        <h2>Historial de trayectos ({{ $user->trayectos->count() }})</h2>

        @if($user->trayectos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Bicicleta</th>
                        <th>Salida</th>
                        <th>Llegada</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Duración</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->trayectos->sortByDesc('started_at') as $trayecto)
                        <tr class="{{ $trayecto->ended_at ? '' : 'activo' }}" style="animation: fadeInUp 0.4s ease-out {{ 0.08 * $loop->index }}s forwards; opacity: 0;">
                            <td>
                                <a href="{{ route('bicicletas.show', $trayecto->bicicleta->id) }}">{{ $trayecto->bicicleta->codigo }}</a>
                            </td>
                            <td>{{ $trayecto->estacionInicio->nombre }}</td>
                            <td>{{ $trayecto->estacionFin ? $trayecto->estacionFin->nombre : '—' }}</td>
                            <td>{{ $trayecto->started_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $trayecto->ended_at ? $trayecto->ended_at->format('d/m/Y H:i') : '—' }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty">No hay trayectos registrados.</div>
        @endif
    </div>
</body>
</html>

