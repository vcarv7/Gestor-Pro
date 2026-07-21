<div class="login-card rounded-xl p-lg">
    {{-- Acciones del Proyecto --}}
    <div class="mb-lg space-y-sm">
        <a href="{{ route('proyectos.pdf', $proyecto) }}"
            class="w-full inline-flex items-center justify-center gap-sm px-md py-sm rounded-lg border border-primary text-primary font-label-md text-label-md hover:bg-primary-container transition-colors">
            <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
            Exportar a PDF
        </a>
        <button type="button"
            onclick="if (confirm('¿Eliminar este proyecto? Se eliminarán también todas sus tareas. Esta acción no se puede deshacer.')) document.getElementById('form-eliminar-proyecto').submit()"
            class="w-full inline-flex items-center justify-center gap-sm px-md py-sm rounded-lg border border-error text-error font-label-md text-label-md hover:bg-error-container transition-colors">
            <span class="material-symbols-outlined text-[18px]">delete</span>
            Eliminar proyecto
        </button>
        <form id="form-eliminar-proyecto" method="POST" action="{{ route('proyectos.destroy', $proyecto) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <div class="border-t border-outline-variant mb-lg"></div>

    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-md">Archivos Adjuntos</h3>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="mb-md p-sm rounded-lg bg-error-container border border-error">
            <ul class="space-y-xs">
                @foreach ($errors->all() as $error)
                    <li class="font-body-sm text-body-sm text-on-error-container">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Upload zone --}}
    <form method="POST" action="{{ route('proyectos.archivos.store', $proyecto) }}" enctype="multipart/form-data" class="mb-md">
        @csrf
        <label class="border-2 border-dashed border-outline-variant rounded-xl p-lg text-center hover:border-primary hover:bg-surface-container transition-colors cursor-pointer block">
            <span class="material-symbols-outlined text-on-surface-variant text-4xl">upload</span>
            <p class="font-body-md text-body-md text-on-surface mt-sm">Haz clic para subir</p>
            <p class="font-body-sm text-body-sm text-on-surface-variant">o arrastra tus archivos aquí</p>
            <p class="font-body-xs text-body-xs text-outline mt-xs">PDF, imágenes, Office, ZIP (máx. 10 MB)</p>
            <input type="file" name="archivo" required class="hidden" onchange="this.form.submit()">
        </label>
    </form>

    @php
        $archivosActivos = $proyecto->archivos->filter(fn($a) => !$a->trashed());
        $archivosPapelera = $proyecto->archivos->filter(fn($a) => $a->trashed());
    @endphp

    {{-- Lista de archivos activos --}}
    <ul class="space-y-sm">
        @forelse ($archivosActivos as $archivo)
            <li class="flex items-center gap-sm p-sm border border-outline-variant rounded-lg hover:bg-surface-container transition-colors group">
                <span class="material-symbols-outlined text-primary text-2xl">{{ $archivo->icono }}</span>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('archivos.download', $archivo) }}"
                        class="font-label-md text-label-md text-on-surface truncate hover:text-primary block"
                        title="{{ $archivo->nombre_original }}">
                        {{ $archivo->nombre_original }}
                    </a>
                    <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $archivo->tamano_humano }}</p>
                </div>
                <a href="{{ route('archivos.download', $archivo) }}"
                    class="text-on-surface-variant hover:text-primary p-sm rounded-md hover:bg-surface-container-high transition-colors"
                    title="Descargar">
                    <span class="material-symbols-outlined text-[20px]">download</span>
                </a>
                <form method="POST" action="{{ route('archivos.destroy', $archivo) }}" onsubmit="return confirm('¿Mover archivo a la papelera?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-on-surface-variant hover:text-error p-sm rounded-md hover:bg-surface-container-high transition-colors"
                        title="Eliminar">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </form>
            </li>
        @empty
            <li class="text-center py-md">
                <p class="font-body-sm text-body-sm text-on-surface-variant">No hay archivos adjuntos.</p>
            </li>
        @endforelse
    </ul>

    {{-- Archivos en papelera --}}
    @if ($archivosPapelera->isNotEmpty())
        <div class="mt-md pt-md border-t border-outline-variant">
            <details class="group">
                <summary class="flex items-center gap-sm cursor-pointer font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface">
                    <span class="material-symbols-outlined text-[16px] group-open:rotate-90 transition-transform">chevron_right</span>
                    Archivos eliminados ({{ $archivosPapelera->count() }})
                </summary>
                <ul class="mt-sm space-y-sm">
                    @foreach ($archivosPapelera as $archivo)
                        <li class="flex items-center gap-sm p-sm rounded-md bg-surface-container">
                            <span class="material-symbols-outlined text-on-surface-variant text-[18px]">delete</span>
                            <span class="flex-1 font-body-sm text-body-sm text-on-surface-variant line-through truncate">{{ $archivo->nombre_original }}</span>
                            <form method="POST" action="{{ route('archivos.restore', $archivo->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-primary hover:text-on-primary-container font-label-sm text-label-sm p-xs">Restaurar</button>
                            </form>
                            <form method="POST" action="{{ route('archivos.force-delete', $archivo->id) }}" class="inline" onsubmit="return confirm('¿Eliminar permanentemente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error hover:text-error font-label-sm text-label-sm p-xs">Eliminar</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </details>
        </div>
    @endif
</div>
