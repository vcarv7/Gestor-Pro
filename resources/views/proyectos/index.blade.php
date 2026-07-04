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
            <a href="{{ route('proyectos.create') }}"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Nuevo Proyecto</span>
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
                <p class="font-headline-sm text-headline-sm text-on-surface mt-md">No tenés proyectos todavía</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Creá tu primer proyecto para empezar.</p>
                <a href="{{ route('proyectos.create') }}" class="inline-block mt-md px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    Crear proyecto
                </a>
            </div>
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

            <div class="px-md py-md">
                {{ $proyectos->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
