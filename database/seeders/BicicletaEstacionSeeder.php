<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Perfil;
use App\Models\Estacion;
use App\Models\Bicicleta;
use App\Models\Trayecto;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BicicletaEstacionSeeder extends Seeder
{
    private array $usuarios = [
        // ─── Alejandro (foto local) ───
        ['name' => 'Alejandro Blanco', 'email' => 'alejandro@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2004-06-15', 'foto' => '/img/avatars/alejandro.png'],

        // ─── Famosos (sin foto, avatar con inicial) ───
        ['name' => 'Cristiano Ronaldo', 'email' => 'cristiano@blarosbikes.com', 'nacionalidad' => 'Portugués', 'nacimiento' => '1985-02-05', 'foto' => null],
        ['name' => 'Sergio Ramos', 'email' => 'sergio.ramos@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '1986-03-30', 'foto' => null],
        ['name' => 'Rosalía Vila', 'email' => 'rosalia@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '1992-09-25', 'foto' => null],
        ['name' => 'Rafael Nadal', 'email' => 'rafa.nadal@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '1986-06-03', 'foto' => null],
        ['name' => 'Aitana Bonmatí', 'email' => 'aitana.bonmati@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '1998-01-18', 'foto' => null],
        ['name' => 'Lamine Yamal', 'email' => 'lamine.yamal@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2007-07-13', 'foto' => null],
        ['name' => 'Álvaro Morata', 'email' => 'morata@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '1992-10-23', 'foto' => null],
        ['name' => 'Pedri González', 'email' => 'pedri@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2002-11-25', 'foto' => null],
        ['name' => 'Amaia Romero', 'email' => 'amaia@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '1999-01-03', 'foto' => null],
        ['name' => 'Iker Casillas', 'email' => 'casillas@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '1981-05-20', 'foto' => null],
        ['name' => 'Penélope Cruz', 'email' => 'penelope@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '1974-04-28', 'foto' => null],
        ['name' => 'Pau Gasol', 'email' => 'pau.gasol@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '1980-07-06', 'foto' => null],
        ['name' => 'James Rodríguez', 'email' => 'james@blarosbikes.com', 'nacionalidad' => 'Colombiano', 'nacimiento' => '1991-07-12', 'foto' => null],
        ['name' => 'Lionel Messi', 'email' => 'messi@blarosbikes.com', 'nacionalidad' => 'Argentino', 'nacimiento' => '1987-06-24', 'foto' => null],
        ['name' => 'Kylian Mbappé', 'email' => 'mbappe@blarosbikes.com', 'nacionalidad' => 'Francés', 'nacimiento' => '1998-12-20', 'foto' => null],
        ['name' => 'Gianluigi Donnarumma', 'email' => 'donnarumma@blarosbikes.com', 'nacionalidad' => 'Italiano', 'nacimiento' => '1999-02-25', 'foto' => null],
        ['name' => 'Erling Haaland', 'email' => 'haaland@blarosbikes.com', 'nacionalidad' => 'Noruego', 'nacimiento' => '2000-07-21', 'foto' => null],
        ['name' => 'Vinícius Júnior', 'email' => 'vinicius@blarosbikes.com', 'nacionalidad' => 'Brasileño', 'nacimiento' => '2000-07-12', 'foto' => null],

        // ─── Genéricos españoles (con foto) ───
        ['name' => 'María García López', 'email' => 'maria.garcia@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2001-03-22', 'foto' => 'https://i.pravatar.cc/150?img=5'],
        ['name' => 'Pablo Hernández', 'email' => 'pablo.hernandez@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2000-11-08', 'foto' => 'https://i.pravatar.cc/150?img=12'],
        ['name' => 'Laura Martínez Ruiz', 'email' => 'laura.martinez@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2002-07-14', 'foto' => 'https://i.pravatar.cc/150?img=9'],
        ['name' => 'Carmen Rodríguez', 'email' => 'carmen.rodriguez@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '1999-09-18', 'foto' => 'https://i.pravatar.cc/150?img=20'],
        ['name' => 'Javier López Díaz', 'email' => 'javier.lopez@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2003-01-25', 'foto' => 'https://i.pravatar.cc/150?img=33'],
        ['name' => 'Ana Fernández', 'email' => 'ana.fernandez@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2001-05-30', 'foto' => 'https://i.pravatar.cc/150?img=23'],
        ['name' => 'Diego Sánchez Pérez', 'email' => 'diego.sanchez@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2000-12-03', 'foto' => 'https://i.pravatar.cc/150?img=51'],
        ['name' => 'Lucía Moreno', 'email' => 'lucia.moreno@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2002-04-11', 'foto' => 'https://i.pravatar.cc/150?img=44'],
        ['name' => 'Sofía Torres Gil', 'email' => 'sofia.torres@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2001-08-19', 'foto' => 'https://i.pravatar.cc/150?img=47'],
        ['name' => 'Carlos Ruiz Martín', 'email' => 'carlos.ruiz@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '1998-02-27', 'foto' => 'https://i.pravatar.cc/150?img=53'],
        ['name' => 'Hugo Jiménez', 'email' => 'hugo.jimenez@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2003-10-05', 'foto' => 'https://i.pravatar.cc/150?img=57'],
        ['name' => 'Elena Navarro', 'email' => 'elena.navarro@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2000-06-22', 'foto' => 'https://i.pravatar.cc/150?img=26'],
        ['name' => 'Paula Díaz Romero', 'email' => 'paula.diaz@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2002-11-29', 'foto' => 'https://i.pravatar.cc/150?img=38'],
        ['name' => 'Adrián Vega', 'email' => 'adrian.vega@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2003-03-08', 'foto' => 'https://i.pravatar.cc/150?img=59'],
        ['name' => 'Marta Ortega', 'email' => 'marta.ortega@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2000-07-31', 'foto' => 'https://i.pravatar.cc/150?img=32'],
        ['name' => 'Álvaro Ruiz Gómez', 'email' => 'alvaro.ruiz@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2001-09-14', 'foto' => 'https://i.pravatar.cc/150?img=52'],
        ['name' => 'Clara Domínguez', 'email' => 'clara.dominguez@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2003-05-21', 'foto' => 'https://i.pravatar.cc/150?img=43'],
        ['name' => 'Daniel Herrera', 'email' => 'daniel.herrera@blarosbikes.com', 'nacionalidad' => 'Español', 'nacimiento' => '2000-02-10', 'foto' => 'https://i.pravatar.cc/150?img=56'],
        ['name' => 'Natalia Romero Paz', 'email' => 'natalia.romero@blarosbikes.com', 'nacionalidad' => 'Española', 'nacimiento' => '2002-08-03', 'foto' => 'https://i.pravatar.cc/150?img=36'],

        // ─── Genéricos internacionales (con foto) ───
        ['name' => 'Giulia Rossi', 'email' => 'giulia.rossi@blarosbikes.com', 'nacionalidad' => 'Italiana', 'nacimiento' => '2000-08-25', 'foto' => 'https://i.pravatar.cc/150?img=25'],
        ['name' => 'Thomas Bauer', 'email' => 'thomas.bauer@blarosbikes.com', 'nacionalidad' => 'Alemán', 'nacimiento' => '1999-11-03', 'foto' => 'https://i.pravatar.cc/150?img=60'],
        ['name' => 'Emily Johnson', 'email' => 'emily.johnson@blarosbikes.com', 'nacionalidad' => 'Estadounidense', 'nacimiento' => '2002-06-18', 'foto' => 'https://i.pravatar.cc/150?img=16'],
        ['name' => 'Yuki Tanaka', 'email' => 'yuki.tanaka@blarosbikes.com', 'nacionalidad' => 'Japonés', 'nacimiento' => '2001-02-14', 'foto' => 'https://i.pravatar.cc/150?img=10'],
    ];

    public function run(): void
    {
        // ─── Crear usuarios con nombres reales ───
        $users = collect();
        $contador = 1;
        foreach ($this->usuarios as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
            ]);

            Perfil::create([
                'user_id' => $user->id,
                'matricula' => 'MAT-' . str_pad($contador++, 4, '0', STR_PAD_LEFT),
                'telefono' => '+34 6' . fake()->numerify('## ## ## ##'),
                'direccion' => fake()->address(),
                'fecha_nacimiento' => $userData['nacimiento'],
                'nacionalidad' => $userData['nacionalidad'],
                'foto' => $userData['foto'] ?? null,
            ]);

            $users->push($user);
        }

        // ─── Crear 50 estaciones ───
        $estaciones = collect();
        for ($i = 0; $i < 50; $i++) {
            $numBicis = fake()->numberBetween(3, 7);
            $estacion = Estacion::factory()
                ->has(Bicicleta::factory()->count($numBicis), 'bicicletas')
                ->create();
            $estaciones->push($estacion);
        }

        // Mapa nombre → id para buscar estaciones por nombre
        $estacionPorNombre = $estaciones->mapWithKeys(fn($e) => [strtolower($e->nombre) => $e]);

        $todasBicis = Bicicleta::all();

        $ahora = Carbon::now();
        $hora = $ahora->hour;

        // ─── Mapear cada bici a su estación actual para trayectos realistas ───
        $biciEstacion = [];
        foreach ($todasBicis as $bici) {
            $biciEstacion[$bici->id] = $bici->estacion_id;
        }

        // ─── Trayectos históricos realistas (últimos 7 días) ───
        for ($dia = 6; $dia >= 0; $dia--) {
            $fecha = $ahora->copy()->subDays($dia);

            // Franjas horarias con distinta intensidad
            $franjas = [
                ['horaMin' => 7, 'horaMax' => 9, 'min' => 8, 'max' => 14],   // Mañana punta
                ['horaMin' => 10, 'horaMax' => 11, 'min' => 3, 'max' => 6],  // Media mañana
                ['horaMin' => 12, 'horaMax' => 14, 'min' => 5, 'max' => 10], // Mediodía
                ['horaMin' => 15, 'horaMax' => 16, 'min' => 3, 'max' => 5],  // Sobremesa
                ['horaMin' => 17, 'horaMax' => 19, 'min' => 6, 'max' => 12], // Tarde punta
                ['horaMin' => 20, 'horaMax' => 22, 'min' => 1, 'max' => 3],  // Noche
            ];

            foreach ($franjas as $franja) {
                $num = fake()->numberBetween($franja['min'], $franja['max']);
                for ($j = 0; $j < $num; $j++) {
                    $inicio = $fecha->copy()
                        ->setHour(fake()->numberBetween($franja['horaMin'], $franja['horaMax']))
                        ->setMinute(fake()->numberBetween(0, 59));
                    $duracion = fake()->numberBetween(5, 40);
                    $fin = $inicio->copy()->addMinutes($duracion);

                    $user = $users->random();
                    $bici = $todasBicis->random();

                    // Trayecto realista: sale de donde está la bici
                    $estacionInicioId = $biciEstacion[$bici->id] ?? $estaciones->random()->id;
                    // Llega a otra estación cercana (cualquier otra)
                    $estacionFin = $estaciones->where('id', '!=', $estacionInicioId)->random();

                    Trayecto::create([
                        'user_id' => $user->id,
                        'bicicleta_id' => $bici->id,
                        'estacion_inicio_id' => $estacionInicioId,
                        'estacion_fin_id' => $estacionFin->id,
                        'started_at' => $inicio,
                        'ended_at' => $fin,
                    ]);

                    // Actualizar posición de la bici tras el trayecto
                    $biciEstacion[$bici->id] = $estacionFin->id;
                }
            }
        }

        // Sincronizar estacion_id y batería basada en último trayecto real
        foreach ($todasBicis as $bici) {
            if (isset($biciEstacion[$bici->id])) {
                $bici->update(['estacion_id' => $biciEstacion[$bici->id]]);
            }

            // Buscar el último trayecto de esta bici
            $ultimoTrayecto = Trayecto::where('bicicleta_id', $bici->id)
                ->whereNotNull('ended_at')
                ->orderBy('ended_at', 'desc')
                ->first();

            if ($ultimoTrayecto) {
                // La bici gastó batería en el trayecto (duración en min / 1.2 = % gastado)
                $duracionMin = $ultimoTrayecto->started_at->diffInMinutes($ultimoTrayecto->ended_at);
                $bateriaGastada = (int) round($duracionMin / 1.2);
                $bateriaAlLlegar = max(5, min(100, 100 - $bateriaGastada));

                $bici->update([
                    'bateria' => $bateriaAlLlegar,
                    'ultimo_uso' => $ultimoTrayecto->ended_at,
                ]);
            } else {
                // Bici sin trayectos → lleva mucho aparcada → 100%
                $bici->update([
                    'bateria' => 100,
                    'ultimo_uso' => $ahora->copy()->subHours(5),
                ]);
            }
        }

        // ─── Trayecto especial: Cristiano Ronaldo de Sol a Vicálvaro Centro ───
        $cristiano = $users->firstWhere('name', 'Cristiano Ronaldo');
        $estacionSol = $estacionPorNombre['estación sol'] ?? $estaciones->random();
        $estacionVicalvaro = $estacionPorNombre['estación vicálvaro centro'] ?? $estaciones->random();

        // Bici que esté en Sol
        $biciCristiano = Bicicleta::where('estacion_id', $estacionSol->id)->first();
        if (!$biciCristiano) {
            // Si no hay ninguna en Sol, mover una
            $biciCristiano = $todasBicis->random();
        }

        // Trayecto de ayer a las 10:30
        $inicioCR = $ahora->copy()->subDay()->setHour(10)->setMinute(30);
        $finCR = $inicioCR->copy()->addMinutes(52); // 52 min Sol→Vicálvaro

        Trayecto::create([
            'user_id' => $cristiano->id,
            'bicicleta_id' => $biciCristiano->id,
            'estacion_inicio_id' => $estacionSol->id,
            'estacion_fin_id' => $estacionVicalvaro->id,
            'started_at' => $inicioCR,
            'ended_at' => $finCR,
        ]);

        // La bici queda en Vicálvaro
        $biciCristiano->update(['estacion_id' => $estacionVicalvaro->id, 'bateria' => 57]);

        // Otro trayecto de Cristiano más reciente (hoy por la mañana)
        $estacionRetiro = $estacionPorNombre['estación retiro norte'] ?? $estaciones->random();
        $biciCR2 = Bicicleta::where('estacion_id', $estacionRetiro->id)->first() ?? $todasBicis->random();
        $inicioCR2 = $ahora->copy()->setHour(8)->setMinute(15);
        $finCR2 = $inicioCR2->copy()->addMinutes(28);

        Trayecto::create([
            'user_id' => $cristiano->id,
            'bicicleta_id' => $biciCR2->id,
            'estacion_inicio_id' => $estacionRetiro->id,
            'estacion_fin_id' => $estacionSol->id,
            'started_at' => $inicioCR2,
            'ended_at' => $finCR2,
        ]);

        // ─── Trayectos de Alejandro Blanco: Vicálvaro Centro → UDIT Suanzes (favoritos) ───
        $alejandro = $users->firstWhere('name', 'Alejandro Blanco');
        $estacionVicCentro = $estacionPorNombre['estación vicálvaro centro'] ?? $estaciones->random();
        $estacionUDIT = $estacionPorNombre['estación udit suanzes'] ?? $estaciones->random();

        // 15 trayectos de Alejandro en los últimos días (su ruta diaria al campus)
        for ($d = 14; $d >= 0; $d--) {
            $fechaAle = $ahora->copy()->subDays($d);
            // Evitar fines de semana
            if ($fechaAle->isWeekend()) continue;

            // Ida: mañana (7:30-8:30) Vicálvaro → UDIT
            $biciIda = Bicicleta::where('estacion_id', $estacionVicCentro->id)->first() ?? $todasBicis->random();
            $inicioIda = $fechaAle->copy()->setHour(fake()->numberBetween(7, 8))->setMinute(fake()->numberBetween(15, 45));
            $finIda = $inicioIda->copy()->addMinutes(fake()->numberBetween(12, 18));

            Trayecto::create([
                'user_id' => $alejandro->id,
                'bicicleta_id' => $biciIda->id,
                'estacion_inicio_id' => $estacionVicCentro->id,
                'estacion_fin_id' => $estacionUDIT->id,
                'started_at' => $inicioIda,
                'ended_at' => $finIda,
                'favorito' => true,
            ]);

            // Vuelta: tarde (14:00-15:30) UDIT → Vicálvaro
            $biciVuelta = Bicicleta::where('estacion_id', $estacionUDIT->id)->first() ?? $todasBicis->random();
            $inicioVuelta = $fechaAle->copy()->setHour(fake()->numberBetween(14, 15))->setMinute(fake()->numberBetween(0, 30));
            $finVuelta = $inicioVuelta->copy()->addMinutes(fake()->numberBetween(12, 18));

            Trayecto::create([
                'user_id' => $alejandro->id,
                'bicicleta_id' => $biciVuelta->id,
                'estacion_inicio_id' => $estacionUDIT->id,
                'estacion_fin_id' => $estacionVicCentro->id,
                'started_at' => $inicioVuelta,
                'ended_at' => $finVuelta,
                'favorito' => true,
            ]);
        }

        // ─── Trayectos activos según hora ───
        if ($hora >= 7 && $hora < 19) {
            $numActivos = fake()->numberBetween(8, 15);
        } elseif ($hora >= 19) {
            $numActivos = fake()->numberBetween(3, 6);
        } else {
            $numActivos = fake()->numberBetween(1, 3);
        }

        $bicisParaActivos = Bicicleta::where('estado', 'disponible')->inRandomOrder()->limit($numActivos + 5)->get();
        $usersLibres = $users->shuffle();
        $activosCreados = 0;

        foreach ($bicisParaActivos as $bici) {
            if ($activosCreados >= $numActivos) break;
            if ($activosCreados >= $usersLibres->count()) break;

            $user = $usersLibres[$activosCreados];
            // Sale de donde está la bici realmente
            $estacionSalida = $bici->estacion_id ? Estacion::find($bici->estacion_id) : $estaciones->random();

            $inicioActivo = $ahora->copy()->subMinutes(fake()->numberBetween(3, 45));

            Trayecto::create([
                'user_id' => $user->id,
                'bicicleta_id' => $bici->id,
                'estacion_inicio_id' => $estacionSalida->id,
                'estacion_fin_id' => null,
                'started_at' => $inicioActivo,
                'ended_at' => null,
            ]);

            // Calcular batería gastada en el trayecto activo
            $minutosEnUso = $ahora->diffInMinutes($inicioActivo);
            $bateriaGastada = (int) round($minutosEnUso / 1.2);
            $nuevaBateria = max(0, min(100, $bici->bateria - $bateriaGastada));

            $bici->update([
                'estado' => 'no-disponible',
                'estacion_id' => null,
                'bateria' => $nuevaBateria,
                'ultimo_uso' => $inicioActivo,
            ]);
            $activosCreados++;
        }

        // ─── Bicicletas en mantenimiento ───
        $numMantenimiento = fake()->numberBetween(3, 6);
        Bicicleta::where('estado', 'disponible')
            ->inRandomOrder()
            ->limit($numMantenimiento)
            ->update(['estado' => 'en-mantenimiento', 'bateria' => 0]);

        // La batería real se calcula dinámicamente en el modelo (getBateriaRealAttribute)
        // No hace falta ajustarla aquí
    }
}


