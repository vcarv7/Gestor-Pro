<x-app-layout>
    <x-slot:title>{{ $proyecto->titulo }}</x-slot:title>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAll = document.getElementById('select-all');
            const checks = document.querySelectorAll('.tarea-check');
            const bulkBtn = document.getElementById('bulk-delete-btn');
            const countSpan = document.getElementById('bulk-count');
            const bulkForm = document.getElementById('bulk-form');
            const bulkIdsInput = document.getElementById('bulk-ids-input');

            function updateBulkState() {
                const selected = [...checks].filter(c => c.checked).map(c => c.value);
                countSpan.textContent = selected.length;
                bulkBtn.classList.toggle('hidden', selected.length === 0);
                if (selectAll) {
                    selectAll.checked = selected.length > 0 && selected.length === checks.length;
                    selectAll.indeterminate = selected.length > 0 && selected.length < checks.length;
                }
            }

            selectAll?.addEventListener('change', () => {
                checks.forEach(c => c.checked = selectAll.checked);
                updateBulkState();
            });

            checks.forEach(c => c.addEventListener('change', updateBulkState));

            bulkForm?.addEventListener('submit', (e) => {
                const selected = [...checks].filter(c => c.checked).map(c => c.value);
                if (selected.length === 0) {
                    e.preventDefault();
                    alert('Seleccioná al menos una tarea.');
                    return;
                }
                if (!confirm(`¿Eliminar ${selected.length} tarea(s) seleccionada(s)?`)) {
                    e.preventDefault();
                    return;
                }
                bulkIdsInput.value = JSON.stringify(selected);
            });
        });
    </script>
    @endpush

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-lg">

        {{-- MAIN --}}
        <div class="space-y-lg">

            <a href="{{ route('proyectos.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Proyectos
            </a>

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
                        <button type="button"
                            onclick="document.getElementById('form-eliminar').submit()"
                            class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-error text-error font-label-md text-label-md hover:bg-error-container transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Eliminar
                        </button>
                        <form id="form-eliminar" method="POST" action="{{ route('proyectos.destroy', $proyecto) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
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
                    <div class="px-lg py-md bg-surface-container border-b border-outline-variant flex items-center justify-between">
                        <label class="flex items-center gap-sm cursor-pointer">
                            <input type="checkbox" id="select-all"
                                class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">
                            <span class="font-label-md text-label-md text-on-surface">Seleccionar todas</span>
                        </label>
                        <form id="bulk-form" method="POST" action="{{ route('proyectos.tareas.bulk-destroy', $proyecto) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tarea_ids" id="bulk-ids-input" value="">
                            <button type="submit" id="bulk-delete-btn"
                                class="hidden inline-flex items-center gap-sm px-md py-sm rounded-lg bg-error text-on-error-container font-label-md text-label-md hover:bg-error/90 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                Eliminar seleccionadas (<span id="bulk-count">0</span>)
                            </button>
                        </form>
                    </div>
                @endif

                <ul class="divide-y divide-outline-variant">
                    @forelse ($proyecto->tareas as $tarea)
                        <li class="flex items-center gap-md p-lg {{ $tarea->completada ? 'opacity-60' : '' }}">
                            {{-- Checkbox de selección --}}
                            <input type="checkbox" value="{{ $tarea->id }}" class="tarea-check w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer">

                            {{-- Toggle completada (form separado) --}}
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
                            <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="inline" onsubmit="return confirm('¿Eliminar tarea?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-on-surface-variant hover:text-error p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="p-lg text-center">
                            <p class="font-body-md text-body-md text-on-surface-variant">No hay tareas todavía.</p>
                            <a href="{{ route('proyectos.tareas.create', $proyecto) }}" class="inline-block mt-sm font-label-md text-label-md text-primary hover:underline">
                                Crear la primera
                            </a>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>

        {{-- RIGHT SIDEBAR: Archivos Adjuntos (mock) --}}
        <aside>
            @include('partials.proyecto-archivos')
        </aside>

    </div>
</x-app-layout>
