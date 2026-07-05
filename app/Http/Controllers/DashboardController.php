<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();
        $now = now();
        $startOfWeek = $now->copy()->startOfWeek();

        // 1) Stat cards
        $totalClientes = Cliente::where('user_id', $userId)->count();
        $proyectosActivos = Proyecto::where('user_id', $userId)
            ->where('estado', 'en_progreso')->count();
        $tareasPendientes = Tarea::where('user_id', $userId)
            ->where('completada', false)->count();

        // 2) Chart: proyectos por mes (últimos 6)
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

        // 3) Tareas urgentes: top 5 Alta con fecha_limite próxima
        $tareasUrgentes = Tarea::with('proyecto')
            ->where('user_id', $userId)
            ->where('completada', false)
            ->where('prioridad', 'alta')
            ->whereNotNull('fecha_limite')
            ->orderBy('fecha_limite', 'asc')
            ->limit(5)
            ->get();

        // 4) Progreso semanal
        $tareasCompletadasSemana = Tarea::where('user_id', $userId)
            ->where('completada', true)
            ->where('updated_at', '>=', $startOfWeek)
            ->count();
        $tareasTotales = Tarea::where('user_id', $userId)->count();
        $progresoSemanal = $tareasTotales > 0
            ? (int) round(($tareasCompletadasSemana / $tareasTotales) * 100)
            : 0;

        // 5) Actividad reciente: mezclar últimos items creados
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

        // Ordenar por fecha DESC y tomar 5
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
