<?php

namespace App\Http\Controllers;

use App\Helpers\Notifier;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(): View
    {
        $clientes = Cliente::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request): RedirectResponse
    {
        Cliente::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()
            ->route('clientes.index')
            ->with('status', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente): View
    {
        $this->authorizeOwner($cliente);

        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente): View
    {
        $this->authorizeOwner($cliente);

        return view('clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $this->authorizeOwner($cliente);

        $cliente->update($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('status', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        $this->authorizeOwner($cliente);

        if ($cliente->proyectos()->exists()) {
            $count = $cliente->proyectos()->count();
            return back()->withErrors([
                'delete' => "No se puede eliminar el cliente porque tiene {$count} proyecto(s) asociado(s). Elimina o reasigna los proyectos primero.",
            ]);
        }

        $nombre = $cliente->nombre;
        $cliente->delete();

        Notifier::notify(auth()->user(), 'cliente_delete', 'Cliente eliminado', "Se eliminó el cliente: {$nombre}");

        return redirect()
            ->route('clientes.index')
            ->with('status', 'Cliente eliminado.');
    }

    private function authorizeOwner(Cliente $cliente): void
    {
        if ($cliente->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para acceder a este cliente.');
        }
    }
}
