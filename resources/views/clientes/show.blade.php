<x-app-layout>
    <x-slot:title>{{ $cliente->nombre }}</x-slot:title>

    <div class="max-w-4xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('clientes.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Clientes
            </a>
        </div>

        {{-- Hero --}}
        <div class="login-card rounded-xl p-lg flex items-start gap-lg">
            <x-avatar :name="$cliente->nombre" size="lg" />
            <div class="flex-1 min-w-0">
                <h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $cliente->nombre }}</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">{{ $cliente->email }}</p>
                @if ($cliente->empresa)
                    <div class="mt-md">
                        <x-status-badge variant="info">{{ $cliente->empresa }}</x-status-badge>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-sm shrink-0">
                <a href="{{ route('clientes.edit', $cliente) }}"
                    class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Editar
                </a>
                <form method="POST" action="{{ route('clientes.destroy', $cliente) }}" class="inline" onsubmit="return confirm('¿Eliminar cliente {{ $cliente->nombre }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-error text-error font-label-md text-label-md hover:bg-error-container hover:text-on-error-container transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>

        {{-- Info grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div class="login-card rounded-xl p-lg">
                <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Contacto</h3>
                <dl class="space-y-md">
                    <div>
                        <dt class="font-label-sm text-label-sm text-on-surface-variant">Email</dt>
                        <dd class="font-body-md text-body-md text-on-surface mt-xs">{{ $cliente->email }}</dd>
                    </div>
                    <div>
                        <dt class="font-label-sm text-label-sm text-on-surface-variant">Teléfono</dt>
                        <dd class="font-body-md text-body-md text-on-surface mt-xs">{{ $cliente->telefono ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="login-card rounded-xl p-lg">
                <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Empresa</h3>
                <p class="font-body-md text-body-md text-on-surface">{{ $cliente->empresa ?? '—' }}</p>
            </div>
        </div>

        {{-- Notas --}}
        <div class="login-card rounded-xl p-lg">
            <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Notas</h3>
            <p class="font-body-md text-body-md text-on-surface italic whitespace-pre-line">{{ $cliente->notas ?? '—' }}</p>
        </div>

    </div>
</x-app-layout>
