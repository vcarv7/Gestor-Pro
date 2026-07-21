<x-app-layout>
    <x-slot:title>Clientes</x-slot:title>

    <div class="space-y-lg">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-md">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Clientes</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                    Gestioná tu red profesional y directorio de contactos.
                </p>
            </div>
            @unless ($papelera)
                <a href="{{ route('clientes.create') }}"
                    class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    <span>+ Nuevo Cliente</span>
                </a>
            @endunless
        </div>

        {{-- Tabs --}}
        <div class="flex items-center gap-xs border-b border-outline-variant">
            <a href="{{ route('clientes.index', ['papelera' => 0]) }}"
                class="px-lg py-sm font-label-md text-label-md {{ $papelera ? 'text-on-surface-variant hover:text-on-surface' : 'text-primary border-b-2 border-primary' }} transition-colors">
                Activos
            </a>
            <a href="{{ route('clientes.index', ['papelera' => 1]) }}"
                class="px-lg py-sm font-label-md text-label-md {{ $papelera ? 'text-primary border-b-2 border-primary' : 'text-on-surface-variant hover:text-on-surface' }} transition-colors">
                Papelera
            </a>
        </div>

        {{-- Flash message --}}
        @if (session('status'))
            <div class="rounded-xl p-md bg-secondary-container border-secondary-fixed">
                <p class="font-body-md text-body-md text-on-secondary-container">{{ session('status') }}</p>
            </div>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="rounded-xl p-md bg-error-container border border-error">
                <ul class="space-y-xs">
                    @foreach ($errors->all() as $error)
                        <li class="font-body-md text-body-md text-on-error-container">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Stats --}}
        @unless ($papelera)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                <x-stat-card label="Mis Clientes" :value="$clientes->total()" icon="group" iconBg="primary" />
                <x-stat-card label="Con Email" :value="$clientes->whereNotNull('email')->count()" icon="contact_page" iconBg="primary" />
                <div class="login-card rounded-xl p-lg flex items-center gap-md bg-secondary-container border-secondary-fixed">
                    <span class="material-symbols-outlined text-on-secondary-container text-[28px]">info</span>
                    <p class="font-body-sm text-body-sm text-on-secondary-container">
                        <strong>Validación:</strong> El nombre y el email son obligatorios, y el email debe ser único.
                    </p>
                </div>
            </div>
        @endunless

        {{-- Tabla de clientes --}}
        <div class="login-card rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-surface-container border-b border-outline-variant">
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Email</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Teléfono</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Empresa</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Notas</th>
                            <th class="px-lg py-md text-right font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $c)
                            <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                <td class="px-lg py-md">
                                    @if ($papelera)
                                        <div class="flex items-center gap-sm">
                                            <x-avatar :name="$c->nombre" size="sm" />
                                            <span class="font-body-md text-body-md text-on-surface-variant line-through">{{ $c->nombre }}</span>
                                        </div>
                                    @else
                                        <a href="{{ route('clientes.show', $c) }}" class="flex items-center gap-sm group">
                                            <x-avatar :name="$c->nombre" size="sm" />
                                            <span class="font-body-md text-body-md text-on-surface group-hover:text-primary font-semibold">{{ $c->nombre }}</span>
                                        </a>
                                    @endif
                                </td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">{{ $c->email }}</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">{{ $c->telefono ?? '—' }}</td>
                                <td class="px-lg py-md">
                                    @if ($c->empresa)
                                        <x-status-badge variant="info">{{ $c->empresa }}</x-status-badge>
                                    @else
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">—</span>
                                    @endif
                                </td>
                                <td class="px-lg py-md font-body-sm text-body-sm italic text-on-surface-variant max-w-xs truncate">{{ $c->notas ?? '—' }}</td>
                                <td class="px-lg py-md text-right">
                                    @if ($papelera)
                                        <div class="flex items-center justify-end gap-xs">
                                            <form method="POST" action="{{ route('clientes.restore', $c->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-on-surface-variant hover:text-primary p-sm rounded-md hover:bg-surface-container-high transition-colors" title="Restaurar">
                                                    <span class="material-symbols-outlined text-[20px]">restore_from_trash</span>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('clientes.force-delete', $c->id) }}" class="inline" onsubmit="return confirm('¿Eliminar permanentemente {{ $c->nombre }}? No se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-on-surface-variant hover:text-error p-sm rounded-md hover:bg-surface-container-high transition-colors" title="Eliminar permanentemente">
                                                    <span class="material-symbols-outlined text-[20px]">delete_forever</span>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-end gap-xs">
                                            <a href="{{ route('clientes.show', $c) }}" class="text-on-surface-variant hover:text-primary p-sm rounded-md hover:bg-surface-container-high transition-colors" title="Ver">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <a href="{{ route('clientes.edit', $c) }}" class="text-on-surface-variant hover:text-primary p-sm rounded-md hover:bg-surface-container-high transition-colors" title="Editar">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </a>
                                            <form method="POST" action="{{ route('clientes.destroy', $c) }}" class="inline" onsubmit="return confirm('¿Mover {{ $c->nombre }} a la papelera?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-on-surface-variant hover:text-error p-sm rounded-md hover:bg-surface-container-high transition-colors" title="Eliminar">
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-lg py-xl text-center">
                                    @if ($papelera)
                                        <p class="font-body-md text-body-md text-on-surface-variant">La papelera está vacía.</p>
                                    @else
                                        <p class="font-body-md text-body-md text-on-surface-variant">No tenés clientes todavía.</p>
                                        <a href="{{ route('clientes.create') }}" class="inline-block mt-md font-label-md text-label-md text-primary hover:underline">
                                            Crear el primero
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($clientes->hasPages())
                <div class="px-md py-md border-t border-outline-variant">
                    {{ $clientes->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
