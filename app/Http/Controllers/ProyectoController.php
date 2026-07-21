<?php

namespace App\Http\Controllers;

use App\Helpers\Notifier;
use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Models\Cliente;
use App\Models\Proyecto;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    public function index(Request $request): View
    {
        $papelera = $request->boolean('papelera');

        $proyectos = Proyecto::where('user_id', auth()->id())
            ->when($papelera, fn ($q) => $q->onlyTrashed(), fn ($q) => $q->whereNull('deleted_at'))
            ->with('cliente')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('proyectos.index', compact('proyectos', 'papelera'));
    }

    public function create(): View
    {
        $clientes = $this->getMisClientes();
        return view('proyectos.create', compact('clientes'));
    }

    public function store(StoreProyectoRequest $request): RedirectResponse
    {
        Proyecto::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Proyecto creado correctamente.');
    }

    public function show(Proyecto $proyecto): View
    {
        $this->authorize('view', $proyecto);

        $proyecto->load([
            'cliente',
            'tareas' => fn($q) => $q->withTrashed()->orderBy('completada')->orderByDesc('created_at'),
            'archivos' => fn($q) => $q->withTrashed(),
        ]);

        return view('proyectos.show', compact('proyecto'));
    }

    public function edit(Proyecto $proyecto): View
    {
        $this->authorize('update', $proyecto);

        $clientes = $this->getMisClientes();
        return view('proyectos.edit', compact('proyecto', 'clientes'));
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('update', $proyecto);

        $proyecto->update($request->validated());

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('delete', $proyecto);

        $nombre = $proyecto->titulo;
        $proyecto->delete();

        Notifier::notify(auth()->user(), 'proyecto_delete', 'Proyecto eliminado', "Se eliminó el proyecto: {$nombre}");

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Proyecto movido a la papelera.');
    }

    public function restore($id): RedirectResponse
    {
        $proyecto = Proyecto::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $proyecto);

        $proyecto->restore();

        return redirect()
            ->route('proyectos.index', ['papelera' => 1])
            ->with('status', 'Proyecto restaurado correctamente.');
    }

    public function forceDelete($id): RedirectResponse
    {
        $proyecto = Proyecto::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $proyecto);

        $nombre = $proyecto->titulo;
        $proyecto->forceDelete();

        Notifier::notify(auth()->user(), 'proyecto_delete', 'Proyecto eliminado permanentemente', "Se eliminó permanentemente el proyecto: {$nombre}");

        return redirect()
            ->route('proyectos.index', ['papelera' => 1])
            ->with('status', 'Proyecto eliminado permanentemente.');
    }

    public function exportPdf(Proyecto $proyecto): Response
    {
        $this->authorize('exportPdf', $proyecto);

        $proyecto->load(['cliente', 'tareas' => fn ($q) => $q->orderBy('completada')->orderBy('fecha_limite')]);

        $pdf = Pdf::loadView('proyectos.pdf', compact('proyecto'));
        $pdf->setPaper('letter', 'portrait');

        $filename = 'proyecto-' . Str::slug($proyecto->titulo) . '.pdf';

        return $pdf->download($filename);
    }

    private function getMisClientes()
    {
        return Cliente::where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'empresa']);
    }
}
