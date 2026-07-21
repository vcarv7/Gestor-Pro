<?php

namespace App\Http\Controllers;

use App\Helpers\Notifier;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(Request $request): View
    {
        $papelera = $request->boolean('papelera');

        $clientes = Cliente::where('user_id', auth()->id())
            ->when($papelera, fn ($q) => $q->onlyTrashed(), fn ($q) => $q->whereNull('deleted_at'))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('clientes.index', compact('clientes', 'papelera'));
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
        $this->authorize('view', $cliente);

        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente): View
    {
        $this->authorize('update', $cliente);

        return view('clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $this->authorize('update', $cliente);

        $cliente->update($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('status', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        $this->authorize('delete', $cliente);

        $nombre = $cliente->nombre;
        $cliente->delete();

        Notifier::notify(auth()->user(), 'cliente_delete', 'Cliente eliminado', "Se eliminó el cliente: {$nombre}");

        return redirect()
            ->route('clientes.index')
            ->with('status', 'Cliente movido a la papelera.');
    }

    public function restore($id): RedirectResponse
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $cliente);

        $cliente->restore();

        return redirect()
            ->route('clientes.index', ['papelera' => 1])
            ->with('status', 'Cliente restaurado correctamente.');
    }

    public function forceDelete($id): RedirectResponse
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $cliente);

        $nombre = $cliente->nombre;
        $cliente->forceDelete();

        Notifier::notify(auth()->user(), 'cliente_delete', 'Cliente eliminado permanentemente', "Se eliminó permanentemente el cliente: {$nombre}");

        return redirect()
            ->route('clientes.index', ['papelera' => 1])
            ->with('status', 'Cliente eliminado permanentemente.');
    }
}
