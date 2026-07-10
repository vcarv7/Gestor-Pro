<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = trim($request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json(['query' => $query, 'results' => []]);
        }

        $userId = auth()->id();

        $clientes = Cliente::where('user_id', $userId)
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('empresa', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'nombre', 'email', 'empresa'])
            ->map(fn ($c) => [
                'type' => 'cliente',
                'type_label' => 'Cliente',
                'id' => $c->id,
                'title' => $c->nombre,
                'subtitle' => $c->empresa ?: $c->email,
                'url' => route('clientes.show', $c),
                'icon' => 'group',
                'badge_variant' => 'primary',
            ]);

        $proyectos = Proyecto::where('user_id', $userId)
            ->where(function ($q) use ($query) {
                $q->where('titulo', 'like', "%{$query}%")
                  ->orWhere('descripcion', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get(['id', 'titulo', 'estado'])
            ->map(fn ($p) => [
                'type' => 'proyecto',
                'type_label' => 'Proyecto',
                'id' => $p->id,
                'title' => $p->titulo,
                'subtitle' => ucfirst($p->estado),
                'url' => route('proyectos.show', $p),
                'icon' => 'folder',
                'badge_variant' => 'secondary',
            ]);

        $tareas = Tarea::where('user_id', $userId)
            ->where('nombre', 'like', "%{$query}%")
            ->limit(5)
            ->get(['id', 'nombre', 'proyecto_id', 'completada'])
            ->map(fn ($t) => [
                'type' => 'tarea',
                'type_label' => 'Tarea',
                'id' => $t->id,
                'title' => $t->nombre,
                'subtitle' => $t->completada ? 'Completada' : 'Pendiente',
                'url' => route('proyectos.show', $t->proyecto_id),
                'icon' => 'task',
                'badge_variant' => 'tertiary',
            ]);

        return response()->json([
            'query' => $query,
            'count' => $clientes->count() + $proyectos->count() + $tareas->count(),
            'results' => [...$clientes, ...$proyectos, ...$tareas],
        ]);
    }
}
