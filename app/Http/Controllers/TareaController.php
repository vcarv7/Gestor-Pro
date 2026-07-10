<?php

namespace App\Http\Controllers;

use App\Helpers\Notifier;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Models\Actividad;
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
        $titulo = $tarea->nombre;
        $tarea->delete();

        Notifier::notify(auth()->user(), 'tarea_bulk_delete', 'Tarea eliminada', "Se eliminó la tarea: {$titulo}");

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea eliminada.');
    }

    // Acciones bulk sobre todas las tareas de un proyecto

    public function completeAll(Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeProyectoOwner($proyecto);

        $count = Tarea::where('user_id', auth()->id())
            ->where('proyecto_id', $proyecto->id)
            ->where('completada', false)
            ->update(['completada' => true]);

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('status', "{$count} tarea(s) marcada(s) como completadas.");
    }

    public function destroyAll(Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeProyectoOwner($proyecto);

        $count = Tarea::where('user_id', auth()->id())
            ->where('proyecto_id', $proyecto->id)
            ->count();

        Tarea::where('user_id', auth()->id())
            ->where('proyecto_id', $proyecto->id)
            ->delete();

        Actividad::create([
            'user_id' => auth()->id(),
            'action' => 'delete_all',
            'subject_type' => Proyecto::class,
            'subject_id' => $proyecto->id,
            'subject_label' => $proyecto->titulo,
            'description' => "{$count} tarea(s) eliminada(s)",
        ]);

        Notifier::notify(auth()->user(), 'tarea_bulk_delete', 'Tareas eliminadas', "Se eliminaron {$count} tarea(s) del proyecto: {$proyecto->titulo}");

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
