<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();
        $now = now();
        $startOfWeek = $now->copy()->startOfWeek();

        $stats = DB::selectOne(
            "SELECT
                total_clientes,
                proyectos_activos,
                tareas_pendientes,
                total_tareas,
                tareas_completadas,
                total_archivos
             FROM v_dashboard_stats
             WHERE user_id = ?",
            [$userId]
        ) ?: (object) [
            'total_clientes' => 0,
            'proyectos_activos' => 0,
            'tareas_pendientes' => 0,
            'total_tareas' => 0,
            'tareas_completadas' => 0,
            'total_archivos' => 0,
        ];

        $totalClientes = $stats->total_clientes;
        $proyectosActivos = $stats->proyectos_activos;
        $tareasPendientes = $stats->tareas_pendientes;
        $tareasTotales = $stats->total_tareas;

        $proyectosPorMes = collect();
        for ($i = 5; $i >= 0; $i--) {
            $mes = $now->copy()->subMonths($i);
            $count = Proyecto::where('user_id', $userId)
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->count();
            $proyectosPorMes->push([
                'label' => $mes->format('M'),
                'count' => $count,
            ]);
        }

        $tareasUrgentes = Tarea::with('proyecto')
            ->where('user_id', $userId)
            ->where('completada', false)
            ->where('prioridad', 'alta')
            ->whereNotNull('fecha_limite')
            ->orderBy('fecha_limite', 'asc')
            ->limit(5)
            ->get();

        $tareasCompletadasSemana = Tarea::where('user_id', $userId)
            ->where('completada', true)
            ->where('updated_at', '>=', $startOfWeek)
            ->count();
        $progresoSemanal = $tareasTotales > 0
            ? (int) round(($tareasCompletadasSemana / $tareasTotales) * 100)
            : 0;

        $actividad = collect();

        if ($ultimoCliente = Cliente::where('user_id', $userId)->latest('created_at')->first()) {
            $actividad->push([
                'icon' => 'person_add',
                'titulo' => 'Nuevo cliente: ' . $ultimoCliente->nombre,
                'detalle' => $ultimoCliente->empresa,
                'fecha' => $ultimoCliente->created_at,
                'url' => route('clientes.show', $ultimoCliente),
            ]);
        }
        if ($ultimoProyecto = Proyecto::with('cliente')
            ->where('user_id', $userId)
            ->latest('created_at')
            ->first()
        ) {
            $actividad->push([
                'icon' => 'folder',
                'titulo' => 'Proyecto: ' . $ultimoProyecto->titulo,
                'detalle' => $ultimoProyecto->cliente?->nombre ?? 'Sin cliente',
                'fecha' => $ultimoProyecto->created_at,
                'url' => route('proyectos.show', $ultimoProyecto),
            ]);
        }
        if ($ultimaTarea = Tarea::with('proyecto')
            ->where('user_id', $userId)
            ->latest('created_at')
            ->first()
        ) {
            $actividad->push([
                'icon' => 'checklist',
                'titulo' => 'Tarea: ' . $ultimaTarea->nombre,
                'detalle' => $ultimaTarea->proyecto?->titulo ?? 'Sin proyecto',
                'fecha' => $ultimaTarea->created_at,
                'url' => route('tareas.edit', $ultimaTarea),
            ]);
        }

        $actividadReciente = $actividad
            ->sortByDesc('fecha')
            ->take(5)
            ->values();

        return view('dashboard.dashboard', compact(
            'totalClientes', 'proyectosActivos', 'tareasPendientes',
            'proyectosPorMes', 'tareasUrgentes',
            'progresoSemanal', 'tareasCompletadasSemana', 'tareasTotales',
            'actividadReciente'
        ));
    }
}
