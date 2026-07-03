<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
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
    // CLIENTES (mock data, sin DB)
    // ============================================================================
    Route::prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/', fn() => view('clientes.index', ['clientes' => getMockClientes()]))->name('index');
        Route::get('/crear', fn() => view('clientes.create'))->name('create');
        Route::get('/{id}', fn($id) => view('clientes.show', ['id' => $id, 'cliente' => getMockCliente($id)]))->name('show');
        Route::get('/{id}/editar', fn($id) => view('clientes.edit', ['id' => $id, 'cliente' => getMockCliente($id)]))->name('edit');
    });

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
// MOCK DATA HELPERS
// ============================================================================
function getMockClientes(): array
{
    return [
        ['id' => 1, 'name' => 'Julianne Doe', 'email' => 'j.doe@techsphere.com', 'phone' => '+1 (555) 123-4567', 'company' => 'TECHSPHERE INC', 'notes' => 'VIP client, priority support'],
        ['id' => 2, 'name' => 'Mark Solstice', 'email' => 'mark@solstice.design', 'phone' => '+1 (555) 987-6543', 'company' => 'SOLSTICE DESIGN', 'notes' => 'Pending invoice approval'],
        ['id' => 3, 'name' => 'Anita Weaver', 'email' => 'a.weaver@growth.io', 'phone' => '+1 (555) 246-8101', 'company' => 'GROWTH IO', 'notes' => 'New lead from referral'],
        ['id' => 4, 'name' => 'David Park', 'email' => 'dpark@venter.com', 'phone' => '+1 (555) 000-1000', 'company' => 'VENTER', 'notes' => 'Standard terms'],
        ['id' => 5, 'name' => 'Elena Fischer', 'email' => 'elena@fischer.at', 'phone' => '+1 (555) 000-1001', 'company' => 'FISCHER GMBH', 'notes' => 'Standard terms'],
        ['id' => 6, 'name' => 'Samir Al-Fayed', 'email' => 'samir@global.sa', 'phone' => '+1 (555) 000-1002', 'company' => 'GLOBAL TRADINGS', 'notes' => 'Standard terms'],
        ['id' => 7, 'name' => 'Clara Thorne', 'email' => 'clara@thorney.net', 'phone' => '+1 (555) 000-1003', 'company' => 'THORNEY LEGAL', 'notes' => 'Standard terms'],
        ['id' => 8, 'name' => 'Liam Hudson', 'email' => 'liam@hudson.co', 'phone' => '+1 (555) 000-1004', 'company' => 'HUDSON MEDIA', 'notes' => 'Standard terms'],
        ['id' => 9, 'name' => 'Sofia Rossi', 'email' => 's.rossi@italo.it', 'phone' => '+1 (555) 000-1005', 'company' => 'ITALO DESIGN', 'notes' => 'Standard terms'],
        ['id' => 10, 'name' => 'James Miller', 'email' => 'james@miller.biz', 'phone' => '+1 (555) 000-1006', 'company' => 'MILLER & CO', 'notes' => 'Standard terms'],
    ];
}

function getMockCliente(int $id): array
{
    $clientes = getMockClientes();
    foreach ($clientes as $c) {
        if ($c['id'] === $id) return $c;
    }
    return $clientes[0];
}

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
