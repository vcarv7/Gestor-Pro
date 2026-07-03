<x-app-layout>
    <div class="space-y-lg">

        {{-- Header --}}
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Proyectos</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Todos tus proyectos, activos y completados.
            </p>
        </div>

        {{-- Lista de proyectos --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
            @foreach ($proyectos as $p)
                <a href="{{ route('proyectos.show', $p['id']) }}" class="login-card rounded-xl p-lg hover:shadow-md transition-shadow block">
                    <div class="flex items-start justify-between gap-sm mb-md">
                        <span class="material-symbols-outlined text-primary text-3xl">folder_open</span>
                        <x-status-badge :variant="$p['estado'] === 'Completado' ? 'success' : 'info'">{{ $p['estado'] }}</x-status-badge>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $p['name'] }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">{{ $p['cliente'] }}</p>
                    <div class="mt-md pt-md border-t border-outline-variant flex items-center justify-between">
                        <div class="font-label-sm text-label-sm text-on-surface-variant">
                            Entrega: <span class="text-on-surface font-medium">{{ $p['fecha_entrega'] }}</span>
                        </div>
                        <div class="font-label-sm text-label-sm text-on-surface-variant">
                            {{ $p['tareas_done'] }}/{{ $p['tareas_count'] }} tareas
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</x-app-layout>
