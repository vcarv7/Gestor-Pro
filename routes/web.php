<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    // AUDITORIA (DB real, auto-logging via model events)
    // ============================================================================
    Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
});
