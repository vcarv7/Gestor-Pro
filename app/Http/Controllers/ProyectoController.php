<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProyectoController extends Controller
{
    public function index(): View
    {
        $proyectos = Proyecto::where('user_id', auth()->id())
            ->with('cliente')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('proyectos.index', compact('proyectos'));
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
        $this->authorizeOwner($proyecto);
        $proyecto->load(['cliente', 'tareas' => fn($q) => $q->orderBy('completada')->orderByDesc('created_at')]);

        return view('proyectos.show', compact('proyecto'));
    }

    public function edit(Proyecto $proyecto): View
    {
        $this->authorizeOwner($proyecto);
        $clientes = $this->getMisClientes();
        return view('proyectos.edit', compact('proyecto', 'clientes'));
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeOwner($proyecto);
        $proyecto->update($request->validated());

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $this->authorizeOwner($proyecto);
        $proyecto->delete();

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Proyecto eliminado.');
    }

    private function getMisClientes()
    {
        return Cliente::where('user_id', auth()->id())
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'empresa']);
    }

    private function authorizeOwner(Proyecto $proyecto): void
    {
        if ($proyecto->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este proyecto.');
        }
    }
}
