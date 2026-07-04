<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TareaController extends Controller
{
    public function index(Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeProyectoOwner($proyecto);
        // Las tareas se muestran dentro del show del proyecto, redirigir allí
        return redirect()->route('proyectos.show', $proyecto);
    }

    public function create(Proyecto $proyecto): View
    {
        $this->authorizeProyectoOwner($proyecto);
        return view('tareas.create', compact('proyecto'));
    }

    public function store(StoreTareaRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeProyectoOwner($proyecto);

        Tarea::create($request->validated() + [
            'user_id' => auth()->id(),
            'proyecto_id' => $proyecto->id,
        ]);

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('status', 'Tarea creada correctamente.');
    }

    // Rutas shallow: no reciben {proyecto} en la URL, solo {tarea}

    public function edit(Tarea $tarea): View
    {
        $this->authorizeTareaOwner($tarea);
        $proyecto = $tarea->proyecto;
        return view('tareas.edit', compact('proyecto', 'tarea'));
    }

    public function update(UpdateTareaRequest $request, Tarea $tarea): RedirectResponse
    {
        $this->authorizeTareaOwner($tarea);
        $tarea->update($request->validated());
        $proyectoId = $tarea->proyecto_id;

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea actualizada correctamente.');
    }

    public function update_completada(Request $request, Tarea $tarea): RedirectResponse
    {
        $this->authorizeTareaOwner($tarea);
        $tarea->update(['completada' => $request->boolean('completada')]);
        $proyectoId = $tarea->proyecto_id;

        return back()->with('status', $tarea->completada ? 'Tarea completada.' : 'Tarea marcada como pendiente.');
    }

    public function destroy(Tarea $tarea): RedirectResponse
    {
        $this->authorizeTareaOwner($tarea);
        $proyectoId = $tarea->proyecto_id;
        $tarea->delete();

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea eliminada.');
    }

    // Bulk delete: con {proyecto} en URL (no shallow) porque necesita autorización

    public function bulkDestroy(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeProyectoOwner($proyecto);

        $request->validate([
            'tarea_ids' => ['required', 'string'],  // viene como JSON string desde el form
        ]);

        $ids = json_decode($request->input('tarea_ids'), true) ?? [];
        if (!is_array($ids) || empty($ids)) {
            return back()->withErrors(['tarea_ids' => 'No se seleccionaron tareas.']);
        }

        $count = Tarea::whereIn('id', $ids)
            ->where('user_id', auth()->id())
            ->where('proyecto_id', $proyecto->id)
            ->delete();

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('status', "{$count} tarea(s) eliminada(s).");
    }

    private function authorizeProyectoOwner(Proyecto $proyecto): void
    {
        if ($proyecto->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este proyecto.');
        }
    }

    private function authorizeTareaOwner(Tarea $tarea): void
    {
        if ($tarea->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a esta tarea.');
        }
    }
}
