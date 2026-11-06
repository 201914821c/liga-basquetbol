# Liga de Básquetbol

Aplicación web desarrollada con Laravel para la gestión integral de una liga de básquetbol. Permite administrar usuarios, equipos, jugadores y partidos, además de consultar resultados y estadísticas.

## Funcionalidades

- Registro e inicio de sesión de usuarios.
- Gestión de equipos (crear, editar, eliminar y consultar).
- Gestión de jugadores por equipo, con validación de dorsal único por equipo.
- Registro y control de partidos (programados y finalizados).
- Registro de resultados y cálculo automático de la tabla de posiciones.
- Panel principal con resumen de la liga y próximos partidos.

## Tecnologías

- PHP 8.3
- Laravel 13
- MySQL 8.0
- Blade + Bootstrap 5
- Git y GitHub

## Requisitos

- PHP 8.3 o superior con las extensiones `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`, `curl` y `gd`.
- Composer 2.
- MySQL 8.0 o MariaDB.
- Git.

## Instalación

1. Clonar el repositorio:

```bash
git clone <URL_DEL_REPOSITORIO>
cd liga-basquetbol
```

2. Instalar las dependencias de PHP:

```bash
composer install
```

3. Crear el archivo de entorno y generar la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

En Windows PowerShell:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

4. Crear la base de datos en MySQL:

```sql
CREATE DATABASE liga_basquetbol CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

5. Configurar las credenciales de la base de datos en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=liga_basquetbol
DB_USERNAME=root
DB_PASSWORD=
```

6. Ejecutar las migraciones y los datos de demostración:

```bash
php artisan migrate --seed
```

7. Levantar el servidor de desarrollo:

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`.

## Credenciales de demostración

- Correo: `admin@liga.test`
- Contraseña: `password`

## Pruebas

```bash
php artisan test
```

## Estructura del proyecto

- `app/Http/Controllers`: controladores de autenticación, equipos, jugadores, partidos y estadísticas.
- `app/Models`: modelos `Equipo`, `Jugador`, `Partido` y `User`.
- `app/Services/ClasificacionService.php`: cálculo de la tabla de posiciones.
- `database/migrations`: estructura de las tablas.
- `database/seeders`: datos de demostración.
- `resources/views`: vistas Blade.
- `routes/web.php`: rutas de la aplicación.
- `doc/practica_liga.md`: documentación técnica del proyecto.

## Flujo de trabajo con Git

El desarrollo se organizó con ramas por funcionalidad:

- `feature/autenticacion`
- `feature/equipos`
- `feature/jugadores`
- `feature/partidos`
- `feature/estadisticas`
- `feature/datos-demo`
- `feature/documentacion`

Cada rama se integró a `main` mediante un merge, manteniendo un historial progresivo de commits descriptivos.
