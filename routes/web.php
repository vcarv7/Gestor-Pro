<?php

use App\Http\Controllers\ArchivoAdjuntoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
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

    // Búsqueda global (autocomplete en header)
    Route::get('/buscar', [SearchController::class, 'search'])->name('search');

    // ============================================================================
    // CLIENTES
    // ============================================================================
    Route::resource('clientes', ClienteController::class);
    Route::patch('clientes/{id}/restore', [ClienteController::class, 'restore'])->name('clientes.restore');
    Route::delete('clientes/{id}/force', [ClienteController::class, 'forceDelete'])->name('clientes.force-delete');

    // ============================================================================
    // PROYECTOS
    // ============================================================================
    Route::resource('proyectos', ProyectoController::class);
    Route::patch('proyectos/{id}/restore', [ProyectoController::class, 'restore'])->name('proyectos.restore');
    Route::delete('proyectos/{id}/force', [ProyectoController::class, 'forceDelete'])->name('proyectos.force-delete');

    // Exportar proyecto a PDF
    Route::get('proyectos/{proyecto}/pdf', [ProyectoController::class, 'exportPdf'])
        ->name('proyectos.pdf');

    // Archivos adjuntos de proyectos
    Route::post('proyectos/{proyecto}/archivos', [ArchivoAdjuntoController::class, 'store'])
        ->name('proyectos.archivos.store');
    Route::get('archivos/{archivo}/descargar', [ArchivoAdjuntoController::class, 'download'])
        ->name('archivos.download');
    Route::delete('archivos/{archivo}', [ArchivoAdjuntoController::class, 'destroy'])
        ->name('archivos.destroy');
    Route::patch('archivos/{id}/restore', [ArchivoAdjuntoController::class, 'restore'])->name('archivos.restore');
    Route::delete('archivos/{id}/force', [ArchivoAdjuntoController::class, 'forceDelete'])->name('archivos.force-delete');

    // ============================================================================
    // TAREAS (anidadas en proyectos, shallow routes)
    // ============================================================================
    Route::resource('proyectos.tareas', TareaController::class)->shallow();

    // Acciones bulk sobre todas las tareas de un proyecto
    Route::patch('proyectos/{proyecto}/tareas/complete-all', [TareaController::class, 'completeAll'])
        ->name('proyectos.tareas.complete-all');
    Route::delete('proyectos/{proyecto}/tareas/destroy-all', [TareaController::class, 'destroyAll'])
        ->name('proyectos.tareas.destroy-all');

    // Restore / force delete de tareas (shallow, por id de tarea)
    Route::patch('tareas/{id}/restore', [TareaController::class, 'restore'])->name('tareas.restore');
    Route::delete('tareas/{id}/force', [TareaController::class, 'forceDelete'])->name('tareas.force-delete');

    // ============================================================================
    // AUDITORIA
    // ============================================================================
    Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');

    // ============================================================================
    // AJUSTES (Settings)
    // ============================================================================
    Route::get('/ajustes', [SettingsController::class, 'show'])->name('settings.show');
    Route::put('/ajustes/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
    Route::put('/ajustes/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
    Route::put('/ajustes/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.update-notifications');
    Route::put('/ajustes/appearance', [SettingsController::class, 'updateAppearance'])->name('settings.update-appearance');
    Route::delete('/ajustes/account', [SettingsController::class, 'destroy'])->name('settings.destroy-account');

    // ============================================================================
    // NOTIFICACIONES
    // ============================================================================
    Route::get('/notificaciones', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notificaciones/recent', [NotificationsController::class, 'recent'])->name('notifications.recent');
    Route::patch('/notificaciones/{notification}/read', [NotificationsController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::patch('/notificaciones/read-all', [NotificationsController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
});
