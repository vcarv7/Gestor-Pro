<x-app-layout>
    <x-slot:title>Proyectos</x-slot:title>

    <div class="space-y-lg">

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-md">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Proyectos</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                    Todos tus proyectos, activos y completados.
                </p>
            </div>
            @unless ($papelera)
                <a href="{{ route('proyectos.create') }}"
                    class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Nuevo Proyecto</span>
                </a>
            @endunless
        </div>

        {{-- Tabs --}}
        <div class="flex items-center gap-xs border-b border-outline-variant">
            <a href="{{ route('proyectos.index', ['papelera' => 0]) }}"
                class="px-lg py-sm font-label-md text-label-md {{ $papelera ? 'text-on-surface-variant hover:text-on-surface' : 'text-primary border-b-2 border-primary' }} transition-colors">
                Activos
            </a>
            <a href="{{ route('proyectos.index', ['papelera' => 1]) }}"
                class="px-lg py-sm font-label-md text-label-md {{ $papelera ? 'text-primary border-b-2 border-primary' : 'text-on-surface-variant hover:text-on-surface' }} transition-colors">
                Papelera
            </a>
        </div>

        @if (session('status'))
            <div class="login-card rounded-xl p-md bg-secondary-container border-secondary-fixed">
                <p class="font-body-md text-body-md text-on-secondary-container">{{ session('status') }}</p>
            </div>
        @endif

        @if ($proyectos->isEmpty())
            <div class="login-card rounded-xl p-xl text-center">
                <span class="material-symbols-outlined text-on-surface-variant text-5xl">folder_off</span>
                @if ($papelera)
                    <p class="font-headline-sm text-headline-sm text-on-surface mt-md">La papelera está vacía</p>
                @else
                    <p class="font-headline-sm text-headline-sm text-on-surface mt-md">No tenés proyectos todavía</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Creá tu primer proyecto para empezar.</p>
                    <a href="{{ route('proyectos.create') }}" class="inline-block mt-md px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                        Crear proyecto
                    </a>
                @endif
            </div>
        @elseif ($papelera)
            <div class="space-y-md">
                @foreach ($proyectos as $p)
                    <div class="login-card rounded-xl p-lg flex items-center justify-between gap-md">
                        <div class="flex items-center gap-md min-w-0">
                            <span class="material-symbols-outlined text-on-surface-variant text-3xl shrink-0">folder_off</span>
                            <div class="min-w-0">
                                <h3 class="font-headline-sm text-headline-sm text-on-surface-variant line-through">{{ $p->titulo }}</h3>
                                @if ($p->cliente)
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">{{ $p->cliente->nombre }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-sm shrink-0">
                            <form method="POST" action="{{ route('proyectos.restore', $p->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-primary text-primary font-label-md text-label-md hover:bg-primary-container transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">restore_from_trash</span>
                                    Restaurar
                                </button>
                            </form>
                            <form method="POST" action="{{ route('proyectos.force-delete', $p->id) }}" class="inline" onsubmit="return confirm('¿Eliminar permanentemente {{ $p->titulo }}? No se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-error text-error font-label-md text-label-md hover:bg-error-container transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($proyectos->hasPages())
                <div class="px-md py-md">
                    {{ $proyectos->links() }}
                </div>
            @endif
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
                @foreach ($proyectos as $p)
                    <a href="{{ route('proyectos.show', $p) }}" class="login-card rounded-xl p-lg hover:shadow-md transition-shadow block">
                        <div class="flex items-start justify-between gap-sm mb-md">
                            <span class="material-symbols-outlined text-primary text-3xl">
                                {{ $p->estado === 'completado' ? 'folder_special' : 'folder_open' }}
                            </span>
                            <x-status-badge :variant="$p->estadoBadgeVariant()">{{ $p->estadoLabel() }}</x-status-badge>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $p->titulo }}</h3>
                        @if ($p->cliente)
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">
                                <span class="material-symbols-outlined text-[14px] align-middle">person</span>
                                {{ $p->cliente->nombre }}
                                @if ($p->cliente->empresa) · {{ $p->cliente->empresa }} @endif
                            </p>
                        @endif
                        <div class="mt-md pt-md border-t border-outline-variant flex items-center justify-between">
                            <div class="font-label-sm text-label-sm text-on-surface-variant">
                                @if ($p->fecha_entrega)
                                    Entrega: <span class="text-on-surface font-medium">{{ $p->fecha_entrega->format('d M Y') }}</span>
                                @else
                                    <span class="italic">Sin fecha de entrega</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($proyectos->hasPages())
                <div class="px-md py-md">
                    {{ $proyectos->links() }}
                </div>
            @endif
        @endif

    </div>
</x-app-layout>
