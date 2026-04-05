# Sistema de Préstamo de Bicicletas - Campus Universitario

Aplicación Laravel para gestionar el préstamo de bicicletas en un campus universitario.

**Asignatura:** Backend I - UDIT  
**Alumno:** Alejandro Blanco

## Descripción

El sistema permite gestionar estaciones de bicicletas, controlar el estado de cada bicicleta y registrar los trayectos que realizan los usuarios del campus.

## Stack técnico

- Laravel 12
- PHP 8.3
- MySQL 8.4
- Redis 7.2
- Docker Compose
- Nginx

## Modelos y relaciones

- **User ↔ Perfil**: relación 1:1
- **Estación → Bicicletas**: relación 1:N
- **User ↔ Bicicletas** (a través de Trayectos): relación M:N

### Esquema de la base de datos

```
users ──1:1── perfiles
  │
  └──M:N── trayectos ──M:N── bicicletas ──N:1── estaciones
```

## Funcionalidades

1. **Listar estaciones** con sus bicicletas (con caché de 60 segundos)
2. **Ver detalle de una bicicleta** con su estado (disponible, no-disponible, en-mantenimiento)
3. **Ver trayectos de un usuario** y con qué bicicletas los ha hecho
4. **Iniciar un trayecto**: el usuario coge una bicicleta de una estación
5. **Finalizar un trayecto**: el usuario devuelve la bicicleta a una estación

## Reglas de negocio

- Una bicicleta que no esté disponible **no se puede alquilar**
- Una bicicleta en uso **no se puede volver a alquilar**
- Un usuario **no puede tener más de un trayecto activo** a la vez

## Caché

El listado de estaciones usa `Cache::remember()` con un TTL de 60 segundos. Se invalida automáticamente al iniciar o finalizar un trayecto.

## Comando Artisan

```bash
php artisan bikes:report
```

Muestra un resumen del sistema: total de bicicletas, disponibilidad, trayectos activos, bicicletas por estación, etc.

## Cómo ejecutar

### 1. Clonar el repositorio

```bash
git clone https://github.com/alexxblaro16/bikes-udit.git
cd bikes-udit
```

### 2. Levantar los contenedores

```bash
docker compose up -d
```

### 3. Instalar dependencias

```bash
docker compose exec app composer install
```

### 4. Configurar el entorno

```bash
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
```

Editar el `.env` para que apunte a MySQL:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=clase
DB_USERNAME=clase
DB_PASSWORD=clase
```

### 5. Ejecutar migraciones y seeders

```bash
docker compose exec app php artisan migrate:fresh --seed
```

### 6. Acceder a la aplicación

Abrir en el navegador: [http://localhost:8001/estaciones](http://localhost:8001/estaciones)

## Rutas principales

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/estaciones` | Listado de estaciones |
| GET | `/estaciones/{id}` | Detalle de una estación |
| GET | `/bicicletas/{id}` | Detalle de una bicicleta |
| GET | `/trayectos/{user}` | Trayectos de un usuario |
| POST | `/trayectos/iniciar` | Iniciar un trayecto |
| POST | `/trayectos/{id}/finalizar` | Finalizar un trayecto |

## Seeders

El seeder crea automáticamente:
- 10 usuarios con perfil
- 5 estaciones con 4 bicicletas cada una (20 bicis)
- 6 trayectos finalizados
- 2 trayectos activos
- 1 bicicleta en mantenimiento


