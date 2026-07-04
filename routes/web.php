<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============================================================================
// RUTAS DE AUTENTICACIÓN
// ============================================================================
require __DIR__.'/auth.php';

// ============================================================================
// RUTAS PÚBLICAS / REDIRECTS
// ============================================================================
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

// ============================================================================
// RUTAS PROTEGIDAS (Dashboard + módulos)
// ============================================================================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard.dashboard'))->name('dashboard');

    // ============================================================================
    // CLIENTES (DB real, scope por user_id)
    // ============================================================================
    Route::resource('clientes', ClienteController::class);

    // ============================================================================
    // PROYECTOS (mock data)
    // ============================================================================
    Route::prefix('proyectos')->name('proyectos.')->group(function () {
        Route::get('/', fn() => view('proyectos.index', ['proyectos' => getMockProyectos()]))->name('index');
        Route::get('/{id}', fn($id) => view('proyectos.show', ['id' => $id, 'proyecto' => getMockProyecto($id)]))->name('show');
    });

    // ============================================================================
    // AUDITORIA (mock data)
    // ============================================================================
    Route::prefix('auditoria')->name('auditoria.')->group(function () {
        Route::get('/', fn() => view('auditoria.index', ['actividades' => getMockActividades()]))->name('index');
    });
});

// ============================================================================
// MOCK DATA HELPERS (solo para proyectos y auditoria)
// ============================================================================
function getMockProyectos(): array
{
    return [
        ['id' => 1, 'name' => 'Rediseño Web - Clínica Dental', 'cliente' => 'Clínica Dental Juan Pérez', 'estado' => 'En Progreso', 'fecha_inicio' => '15 Ene 2024', 'fecha_entrega' => '28 Feb 2024', 'tareas_count' => 4, 'tareas_done' => 1],
        ['id' => 2, 'name' => 'Branding Global', 'cliente' => 'Solstice Design', 'estado' => 'En Progreso', 'fecha_inicio' => '01 Mar 2024', 'fecha_entrega' => '15 Abr 2024', 'tareas_count' => 6, 'tareas_done' => 2],
        ['id' => 3, 'name' => 'App Finanzas UI', 'cliente' => 'Miller & Co', 'estado' => 'Completado', 'fecha_inicio' => '10 Nov 2023', 'fecha_entrega' => '20 Dic 2023', 'tareas_count' => 8, 'tareas_done' => 8],
    ];
}

function getMockProyecto(int $id): array
{
    $proyectos = getMockProyectos();
    foreach ($proyectos as $p) {
        if ($p['id'] === $id) return $p;
    }
    return $proyectos[0];
}

function getMockActividades(): array
{
    return [
        ['id' => 1, 'user' => 'Carlos', 'rol' => 'Admin Principal', 'accion' => 'Actualizó el proyecto', 'proyecto' => 'Branding Rediseño Nike', 'detalle' => 'Estado: En progreso → Revisión', 'timestamp' => 'Hace 2 mins', 'critica' => false],
        ['id' => 2, 'user' => 'Ana Martinez', 'rol' => 'Editor', 'accion' => 'Subió archivos a', 'proyecto' => 'Campaña Verano 24', 'detalle' => '3 imágenes JPG, 1 archivo AI', 'timestamp' => 'Hace 15 mins', 'critica' => false],
        ['id' => 3, 'user' => 'Carlos', 'rol' => 'Admin Principal', 'accion' => 'Eliminó el cliente', 'proyecto' => 'Global Tech S.A.', 'detalle' => '', 'timestamp' => 'Hoy, 10:45 AM', 'critica' => true],
        ['id' => 4, 'user' => 'Sistema', 'rol' => 'Automatización', 'accion' => 'Backup diario completado con éxito', 'proyecto' => '', 'detalle' => 'Tamaño: 1.2 GB', 'timestamp' => 'Hoy, 04:00 AM', 'critica' => false],
        ['id' => 5, 'user' => 'Roberto Ruiz', 'rol' => 'Colaborador', 'accion' => 'Creó nuevo hito en', 'proyecto' => 'App Finanzas UI', 'detalle' => '"Entrega fase 1 - Wireframes"', 'timestamp' => 'Ayer, 18:22 PM', 'critica' => false],
    ];
}
