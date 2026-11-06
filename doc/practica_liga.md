# Documentación técnica: Gestión de Liga de Básquetbol

## Arquitectura del sistema

La aplicación está construida con Laravel 13 bajo el patrón MVC. El flujo de una petición comienza en `routes/web.php`, pasa por el middleware de autenticación y llega a un controlador, que valida la entrada, invoca modelos Eloquent y devuelve una vista Blade. La persistencia se realiza sobre MySQL 8.0 mediante migraciones versionadas. La interfaz usa Bootstrap 5 servido localmente desde `public/vendor`, evitando dependencias de CDN en tiempo de ejecución.

La lógica de negocio que no pertenece a un controlador se aisló en `app/Services/ClasificacionService.php`. Esto mantiene los controladores delgados, permite reutilizar el cálculo de la tabla de posiciones y facilita las pruebas automatizadas. La configuración sensible se maneja con variables de entorno: `.env` permanece fuera del repositorio y `.env.example` documenta las claves requeridas.

## Clases, controladores y modelos

- `AuthController`: registro, inicio y cierre de sesión.
- `DashboardController`: resumen de equipos, jugadores y partidos.
- `EquipoController`: CRUD de equipos.
- `JugadorController`: CRUD de jugadores filtrado por equipo.
- `PartidoController`: CRUD de partidos y registro de resultados.
- `EstadisticaController`: tabla de posiciones, resultados y próximos encuentros.
- `ClasificacionService`: cálculo de posiciones.
- Modelos `Equipo`, `Jugador`, `Partido` y `User`, con relaciones Eloquent.
- Vistas Blade organizadas por módulo (`equipos`, `jugadores`, `partidos`, `estadisticas`).

## Funcionalidades principales

El sistema exige autenticación para acceder a los módulos. Los equipos se registran con nombre único, ciudad, entrenador y año de fundación. Los jugadores se asignan a un equipo y validan que el dorsal sea único dentro de ese equipo. Los partidos se programan entre dos equipos distintos y pueden finalizarse registrando un marcador; al hacerlo se actualiza automáticamente la tabla de posiciones. Las estadísticas otorgan dos puntos por victoria y uno por derrota, y ordenan por puntos, diferencia y puntos anotados.

## Fragmentos relevantes

La validación del dorsal combina una regla condicional por equipo y la exclusión del propio registro durante la edición:

```php
Rule::unique('jugadores', 'dorsal')
    ->where(fn ($query) => $query->where('equipo_id', $request->integer('equipo_id')))
    ->ignore($jugador?->id),
```

El registro de resultados actualiza el estado del partido de forma transaccional a nivel de fila:

```php
$partido->update([
    'puntos_local' => $data['puntos_local'],
    'puntos_visitante' => $data['puntos_visitante'],
    'estado' => 'finalizado',
]);
```

La tabla de posiciones recorre únicamente partidos finalizados y acumula puntos a favor y en contra según la condición de local o visitante:

```php
if ($partido->equipo_local_id === $equipo->id) {
    $pf += $partido->puntos_local;
    $pc += $partido->puntos_visitante;
}
```

## Problemas encontrados y soluciones

1. El PHP incluido en XAMPP era la versión 5.6, incompatible con Laravel 13. Se instaló PHP 8.3 portable y Composer, habilitando las extensiones necesarias.
2. Composer falló por la intercepción SSL del antivirus. Se descargó el bundle de certificados y se configuró `curl.cainfo` y `openssl.cafile`.
3. El parámetro generado por `Route::resource('jugadores', ...)` era `{jugadore}` por la singularización automática. Se corrigió con `->parameters(['jugadores' => 'jugador'])`.
4. La eliminación de equipos con partidos podía romper la integridad referencial. Se agregó una validación que impide la operación y muestra un mensaje.
5. El antivirus bloqueó renombrados temporales de Composer; se resolvió reintentando la instalación.

## Decisiones técnicas

Se eligió Laravel por ser el framework sugerido y por su soporte de migraciones, validación y pruebas. La autenticación se implementó de forma explícita para controlar el flujo y evitar dependencias adicionales. Bootstrap se almacenó localmente para que la aplicación funcione sin Internet. El cálculo de posiciones se extrajo a un servicio para poder probarlo de forma aislada. Se añadieron pruebas de características para autenticación, equipos, jugadores, partidos y estadísticas, y datos de demostración para facilitar la evaluación. El trabajo se organizó en ramas `feature/*` integradas a `main`, con commits descriptivos que evidencian la evolución del proyecto.
