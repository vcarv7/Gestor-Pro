<div class="login-card rounded-xl p-lg">
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
