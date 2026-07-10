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

    {{-- Upload zone --}}
    <div class="border-2 border-dashed border-outline-variant rounded-xl p-lg text-center hover:border-primary hover:bg-surface-container transition-colors cursor-pointer mb-md">
        <span class="material-symbols-outlined text-on-surface-variant text-4xl">upload</span>
        <p class="font-body-md text-body-md text-on-surface mt-sm">Haz clic para subir</p>
        <p class="font-body-sm text-body-sm text-on-surface-variant">o arrastra tus archivos aquí</p>
    </div>

    {{-- Lista de archivos --}}
    <ul class="space-y-sm">
        <li class="flex items-center gap-sm p-sm border border-outline-variant rounded-lg hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-error text-2xl">picture_as_pdf</span>
            <div class="flex-1 min-w-0">
                <p class="font-label-md text-label-md text-on-surface truncate">briefing_dental.pdf</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">1.2 MB</p>
            </div>
            <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[20px]">download</span>
            </button>
        </li>
        <li class="flex items-center gap-sm p-sm border border-outline-variant rounded-lg hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-primary text-2xl">image</span>
            <div class="flex-1 min-w-0">
                <p class="font-label-md text-label-md text-on-surface truncate">referencias.png</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">4.5 MB</p>
            </div>
            <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[20px]">download</span>
            </button>
        </li>
        <li class="flex items-center gap-sm p-sm border border-outline-variant rounded-lg hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-primary text-2xl">description</span>
            <div class="flex-1 min-w-0">
                <p class="font-label-md text-label-md text-on-surface truncate">copywriting_v1.docx</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">450 KB</p>
            </div>
            <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[20px]">download</span>
            </button>
        </li>
    </ul>
</div>
