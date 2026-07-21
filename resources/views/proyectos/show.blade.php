<x-app-layout>
    <x-slot:title>{{ $proyecto->titulo }}</x-slot:title>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-lg">

        {{-- MAIN --}}
        <div class="space-y-lg">

            <a href="{{ route('proyectos.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Proyectos
            </a>

            @if ($proyecto->trashed())
                <div class="rounded-xl p-md bg-error-container border border-error flex items-center gap-md">
                    <span class="material-symbols-outlined text-on-error-container text-[24px]">delete</span>
                    <div class="flex-1">
                        <p class="font-body-md text-body-md text-on-error-container font-semibold">Proyecto en la papelera</p>
                        <p class="font-body-sm text-body-sm text-on-error-container">Este proyecto fue eliminado y está en la papelera.</p>
                    </div>
                    <form method="POST" action="{{ route('proyectos.restore', $proyecto->id) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-md py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                            Restaurar
                        </button>
                    </form>
                </div>
            @endif

            {{-- Flash --}}
            @if (session('status'))
                <div class="login-card rounded-xl p-md bg-secondary-container border-secondary-fixed">
                    <p class="font-body-md text-body-md text-on-secondary-container">{{ session('status') }}</p>
                </div>
            @endif

            {{-- Hero --}}
            <div class="login-card rounded-xl p-lg">
                <div class="flex items-start justify-between gap-md flex-wrap">
                    <div class="min-w-0 flex-1">
                        <h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $proyecto->titulo }}</h1>
                        @if ($proyecto->descripcion)
                            <p class="font-body-md text-body-md text-on-surface-variant mt-xs leading-relaxed max-w-3xl">
                                {{ $proyecto->descripcion }}
                            </p>
                        @endif
                    </div>
                    <div class="flex items-center gap-sm shrink-0">
                        <a href="{{ route('proyectos.edit', $proyecto) }}"
                            class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Editar
                        </a>
                    </div>
                </div>
            </div>

            {{-- 3 Info cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                <div class="login-card rounded-xl p-lg">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Cliente</p>
                    @if ($proyecto->cliente)
                        <a href="{{ route('clientes.show', $proyecto->cliente) }}" class="flex items-center gap-sm hover:text-primary">
                            <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-md text-label-md">
                                {{ mb_strtoupper(mb_substr(explode(' ', $proyecto->cliente->nombre)[0] ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-body-md text-body-md text-on-surface font-semibold">{{ $proyecto->cliente->nombre }}</p>
                                @if ($proyecto->cliente->empresa)
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $proyecto->cliente->empresa }}</p>
                                @endif
                            </div>
                        </a>
                    @else
                        <p class="font-body-sm text-body-sm text-on-surface-variant italic">Sin cliente asignado</p>
                    @endif
                </div>

                <div class="login-card rounded-xl p-lg">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Cronograma</p>
                    <dl class="space-y-sm">
                        <div class="flex items-center justify-between">
                            <dt class="font-body-sm text-body-sm text-on-surface-variant">Inicio:</dt>
                            <dd class="font-body-md text-body-md text-on-surface font-semibold">
                                {{ $proyecto->fecha_inicio?->format('d M Y') ?? '—' }}
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="font-body-sm text-body-sm text-on-surface-variant">Entrega:</dt>
                            <dd class="font-body-md text-body-md text-on-surface font-semibold">
                                {{ $proyecto->fecha_entrega?->format('d M Y') ?? '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="login-card rounded-xl p-lg">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Estado</p>
                    <x-status-badge :variant="$proyecto->estadoBadgeVariant()">
                        <span class="w-2 h-2 rounded-full bg-current opacity-70"></span>
                        {{ $proyecto->estadoLabel() }}
                    </x-status-badge>
                </div>
            </div>

            {{-- Tareas del Proyecto --}}
            <div class="login-card rounded-xl overflow-hidden">
                <div class="p-lg flex items-center justify-between border-b border-outline-variant">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Tareas del Proyecto</h2>
                    <a href="{{ route('proyectos.tareas.create', $proyecto) }}"
                        class="inline-flex items-center gap-sm font-label-md text-label-md text-primary hover:underline">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Nueva Tarea
                    </a>
                </div>

                @if ($proyecto->tareas->count() > 0)
                    {{-- Bulk actions bar --}}
                    <div class="px-lg py-md bg-surface-container border-b border-outline-variant flex items-center justify-between flex-wrap gap-sm">
                        <div class="flex items-center gap-sm">
                            <span class="font-label-md text-label-md text-on-surface">
                                {{ $proyecto->tareas->count() }} tarea(s) en total
                            </span>
                            <span class="text-outline">•</span>
                            <span class="font-label-md text-label-md text-on-surface-variant">
                                {{ $proyecto->tareas->where('completada', true)->count() }} completada(s)
                            </span>
                        </div>
                        <div class="flex items-center gap-sm">
                            <form method="POST" action="{{ route('proyectos.tareas.complete-all', $proyecto) }}" onsubmit="return confirm('¿Marcar todas las tareas pendientes como completadas?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-primary text-primary font-label-md text-label-md hover:bg-primary-container transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">done_all</span>
                                    Marcar todas como cumplidas
                                </button>
                            </form>
                            <form method="POST" action="{{ route('proyectos.tareas.destroy-all', $proyecto) }}" onsubmit="return confirm('¿Eliminar TODAS las tareas del proyecto? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-error text-error font-label-md text-label-md hover:bg-error-container transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                                    Eliminar todas las tareas
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                @php
                    $tareasActivas = $proyecto->tareas->filter(fn($t) => !$t->trashed());
                    $tareasPapelera = $proyecto->tareas->filter(fn($t) => $t->trashed());
                @endphp

                <ul class="divide-y divide-outline-variant">
                    @forelse ($tareasActivas as $tarea)
                        <li class="flex items-center gap-md p-lg {{ $tarea->completada ? 'opacity-60' : '' }}">
                            <form method="POST" action="{{ route('tareas.update', $tarea) }}" id="toggle-{{ $tarea->id }}" class="contents">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="completada" value="{{ $tarea->completada ? 0 : 1 }}">
                                <input type="hidden" name="nombre" value="{{ $tarea->nombre }}">
                                <input type="hidden" name="prioridad" value="{{ $tarea->prioridad }}">
                                <input type="hidden" name="descripcion" value="{{ $tarea->descripcion }}">
                                <input type="hidden" name="fecha_limite" value="{{ $tarea->fecha_limite?->format('Y-m-d') }}">
                                <input type="checkbox"
                                    onchange="document.getElementById('toggle-{{ $tarea->id }}').submit()"
                                    {{ $tarea->completada ? 'checked' : '' }}
                                    class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">
                            </form>

                            <span class="flex-1 font-body-md text-body-md {{ $tarea->completada ? 'text-on-surface-variant line-through' : 'text-on-surface' }}">
                                {{ $tarea->nombre }}
                                @if ($tarea->fecha_limite)
                                    <span class="ml-sm font-body-sm text-body-sm text-on-surface-variant">({{ $tarea->fechaHumana() }})</span>
                                @endif
                            </span>
                            <x-status-badge :variant="$tarea->prioridadBadgeVariant()">{{ $tarea->prioridadLabel() }}</x-status-badge>
                            <a href="{{ route('tareas.edit', $tarea) }}"
                                class="text-on-surface-variant hover:text-primary p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="inline" onsubmit="return confirm('¿Mover tarea a la papelera?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-on-surface-variant hover:text-error p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="p-lg text-center">
                            <p class="font-body-md text-body-md text-on-surface-variant">No hay tareas activas.</p>
                        </li>
                    @endforelse
                </ul>

                @if ($tareasPapelera->isNotEmpty())
                    <div class="border-t border-outline-variant px-lg py-md bg-surface-container">
                        <details class="group">
                            <summary class="flex items-center gap-sm cursor-pointer font-label-md text-label-md text-on-surface-variant hover:text-on-surface">
                                <span class="material-symbols-outlined text-[18px] group-open:rotate-90 transition-transform">chevron_right</span>
                                Tareas en papelera ({{ $tareasPapelera->count() }})
                            </summary>
                            <ul class="mt-md space-y-sm">
                                @foreach ($tareasPapelera as $tarea)
                                    <li class="flex items-center gap-md p-sm rounded-md bg-surface-container-high">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[18px]">delete</span>
                                        <span class="flex-1 font-body-sm text-body-sm text-on-surface-variant line-through">{{ $tarea->nombre }}</span>
                                        <form method="POST" action="{{ route('tareas.restore', $tarea->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-primary hover:text-on-primary-container font-label-sm text-label-sm p-xs" title="Restaurar">
                                                Restaurar
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('tareas.force-delete', $tarea->id) }}" class="inline" onsubmit="return confirm('¿Eliminar permanentemente esta tarea?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-error hover:text-error font-label-sm text-label-sm p-xs" title="Eliminar permanentemente">
                                                Eliminar
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    </div>
                @endif
            </div>

        </div>

        {{-- RIGHT SIDEBAR: Archivos Adjuntos (mock) --}}
        <aside>
            @include('partials.proyecto-archivos', ['proyecto' => $proyecto])
        </aside>

    </div>
</x-app-layout>
