<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProyectoController;
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
