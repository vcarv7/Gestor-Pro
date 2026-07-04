<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
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
    // PROYECTOS (DB real, scope por user_id)
    // ============================================================================
    Route::resource('proyectos', ProyectoController::class);

    // ============================================================================
    // TAREAS (anidadas en proyectos, shallow routes)
    // ============================================================================
    Route::resource('proyectos.tareas', TareaController::class)->shallow();

    // Bulk delete de tareas (ruta con {proyecto} para autorización)
    Route::delete('proyectos/{proyecto}/tareas/bulk', [TareaController::class, 'bulkDestroy'])
        ->name('proyectos.tareas.bulk-destroy');

    // ============================================================================
    // AUDITORIA (mock data)
    // ============================================================================
    Route::prefix('auditoria')->name('auditoria.')->group(function () {
        Route::get('/', fn() => view('auditoria.index', ['actividades' => getMockActividades()]))->name('index');
    });
});

// ============================================================================
// MOCK DATA HELPERS (solo para auditoria)
// ============================================================================
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
