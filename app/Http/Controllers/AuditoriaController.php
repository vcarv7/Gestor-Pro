<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\View\View;

class AuditoriaController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $startOfDay = now()->startOfDay();

        $accionesHoy = Actividad::where('user_id', $userId)
            ->where('created_at', '>=', $startOfDay)
            ->count();

        $usuariosActivos = Actividad::where('created_at', '>=', $startOfDay)
            ->distinct('user_id')
            ->count('user_id');

        $accionesCriticas = Actividad::where('user_id', $userId)
            ->where('action', 'delete')
            ->where('created_at', '>=', $startOfDay)
            ->count();

        $actividades = Actividad::with('user')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('auditoria.index', compact(
            'accionesHoy', 'usuariosActivos', 'accionesCriticas', 'actividades'
        ));
    }
}
