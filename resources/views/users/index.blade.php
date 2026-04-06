<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLAROSBIKES — Usuarios</title>
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
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        h1 { color: #f5c518; font-size: 32px; margin-bottom: 5px; font-weight: 800; animation: fadeInUp 0.5s ease-out; }
        .subtitle { color: #888; font-size: 13px; margin-bottom: 25px; }
        .user-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
        .user-card { background: #2a2a2a; border-radius: 12px; padding: 20px; border: 1px solid #333; transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1); cursor: pointer; text-decoration: none; color: inherit; display: flex; gap: 16px; align-items: center; animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
        .user-card:hover { border-color: #f5c518; transform: translateY(-4px) scale(1.01); box-shadow: 0 12px 30px rgba(0,0,0,0.4); }
        .avatar { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; color: #1a1a1a; flex-shrink: 0; background: linear-gradient(135deg, #f5c518, #e0b300); }
        .user-card .info h3 { font-size: 15px; font-weight: 700; color: #e0e0e0; margin-bottom: 4px; }
        .user-card .info .meta { font-size: 12px; color: #888; line-height: 1.6; }
        .user-card .info .meta strong { color: #f5c518; }
        .user-card .stats { display: flex; gap: 12px; margin-top: 8px; }
        .mini-stat { font-size: 11px; color: #999; }
        .mini-stat span { color: #f5c518; font-weight: 700; font-size: 13px; }
        .search-wrapper { position: relative; margin-bottom: 25px; }
        .search-input { width: 100%; padding: 14px 20px 14px 50px; background: #2a2a2a; border: 2px solid #333; border-radius: 12px; color: #e0e0e0; font-size: 15px; font-family: 'Inter', sans-serif; outline: none; transition: all 0.3s; }
        .search-input::placeholder { color: #666; }
        .search-input:focus { border-color: #f5c518; box-shadow: 0 0 20px rgba(245, 197, 24, 0.1); }
        .search-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); }
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
        <h1>Usuarios</h1>
        <p class="subtitle">{{ $users->count() }} usuarios registrados en BLAROSBIKES</p>

        <div class="search-wrapper">
            <input type="text" class="search-input" id="searchUsers" placeholder="Buscar usuario por nombre...">
            <div class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
        </div>

        <div class="user-grid" id="userGrid">
            @foreach($users->sortBy('name') as $user)
                <a href="{{ route('users.show', $user->id) }}" class="user-card" data-name="{{ strtolower($user->name) }}" style="animation-delay: {{ min(0.05 * $loop->index, 1.5) }}s;">
                    @if($user->perfil && $user->perfil->foto)
                        <img src="{{ $user->perfil->foto }}" class="avatar" style="object-fit: cover;">
                    @else
                        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                    <div class="info">
                        <h3>{{ $user->name }}</h3>
                        <div class="meta">
                            @if($user->perfil)
                                {{ $user->perfil->nacionalidad }} · {{ $user->perfil->edad ?? '?' }} años
                            @endif
                        </div>
                        <div class="stats">
                            <div class="mini-stat"><span>{{ $user->trayectos->count() }}</span> trayectos</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <script>
        document.getElementById('searchUsers').addEventListener('input', function () {
            const q = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            document.querySelectorAll('.user-card').forEach(card => {
                const name = card.getAttribute('data-name').normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                card.style.display = name.includes(q) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
