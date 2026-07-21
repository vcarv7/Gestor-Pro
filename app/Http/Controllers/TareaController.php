<?php

namespace App\Http\Controllers;

use App\Helpers\Notifier;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use App\Models\Actividad;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TareaController extends Controller
{
    public function index(Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('view', $proyecto);
        return redirect()->route('proyectos.show', $proyecto);
    }

    public function create(Proyecto $proyecto): View
    {
        $this->authorize('view', $proyecto);
        return view('tareas.create', compact('proyecto'));
    }

    public function store(StoreTareaRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('view', $proyecto);

        Tarea::create($request->validated() + [
            'user_id' => auth()->id(),
            'proyecto_id' => $proyecto->id,
        ]);

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('status', 'Tarea creada correctamente.');
    }

    public function show(Tarea $tarea): RedirectResponse
    {
        $this->authorize('view', $tarea);
        return redirect()->route('proyectos.show', $tarea->proyecto_id);
    }

    public function edit(Tarea $tarea): View
    {
        $this->authorize('update', $tarea);
        $proyecto = $tarea->proyecto;
        return view('tareas.edit', compact('proyecto', 'tarea'));
    }

    public function update(UpdateTareaRequest $request, Tarea $tarea): RedirectResponse
    {
        $this->authorize('update', $tarea);
        $tarea->update($request->validated());
        $proyectoId = $tarea->proyecto_id;

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea actualizada correctamente.');
    }

    public function destroy(Tarea $tarea): RedirectResponse
    {
        $this->authorize('delete', $tarea);
        $proyectoId = $tarea->proyecto_id;
        $titulo = $tarea->nombre;
        $tarea->delete();

        Notifier::notify(auth()->user(), 'tarea_bulk_delete', 'Tarea eliminada', "Se eliminó la tarea: {$titulo}");

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea eliminada.');
    }

    public function restore($id): RedirectResponse
    {
        $tarea = Tarea::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $tarea);

        $proyectoId = $tarea->proyecto_id;
        $tarea->restore();

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea restaurada.');
    }

    public function forceDelete($id): RedirectResponse
    {
        $tarea = Tarea::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $tarea);

        $proyectoId = $tarea->proyecto_id;
        $tarea->forceDelete();

        return redirect()
            ->route('proyectos.show', $proyectoId)
            ->with('status', 'Tarea eliminada permanentemente.');
    }

    public function completeAll(Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('view', $proyecto);

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
        $this->authorize('view', $proyecto);

        $tareas = Tarea::where('user_id', auth()->id())
            ->where('proyecto_id', $proyecto->id)
            ->get();

        $count = $tareas->count();

        foreach ($tareas as $tarea) {
            $tarea->delete();
        }

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
}
