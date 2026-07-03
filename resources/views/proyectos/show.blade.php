<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-lg">

        {{-- MAIN --}}
        <div class="space-y-lg">

            {{-- Back --}}
            <a href="{{ route('proyectos.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Proyectos
            </a>

            {{-- Hero --}}
            <div class="login-card rounded-xl p-lg">
                <div class="flex items-start justify-between gap-md flex-wrap">
                    <div class="min-w-0 flex-1">
                        <h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $proyecto['name'] }}</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-xs leading-relaxed max-w-3xl">
                            Actualización integral de la presencia digital de la clínica, optimizando la experiencia del paciente y el sistema de citas online.
                        </p>
                    </div>
                    <div class="flex items-center gap-sm shrink-0">
                        <button class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            Editar
                        </button>
                        <button class="inline-flex items-center gap-sm px-md py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                            <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                            Exportar a PDF
                        </button>
                    </div>
                </div>
            </div>

            {{-- 3 Info cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                {{-- Cliente --}}
                <div class="login-card rounded-xl p-lg">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Cliente</p>
                    <div class="flex items-center gap-sm">
                        <div class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-md text-label-md">CP</div>
                        <div>
                            <p class="font-body-md text-body-md text-on-surface font-semibold">Clínica Dental</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">Juan Pérez</p>
                        </div>
                    </div>
                </div>

                {{-- Cronograma --}}
                <div class="login-card rounded-xl p-lg">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Cronograma</p>
                    <dl class="space-y-sm">
                        <div class="flex items-center justify-between">
                            <dt class="font-body-sm text-body-sm text-on-surface-variant">Inicio:</dt>
                            <dd class="font-body-md text-body-md text-on-surface font-semibold">{{ $proyecto['fecha_inicio'] }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="font-body-sm text-body-sm text-on-surface-variant">Entrega:</dt>
                            <dd class="font-body-md text-body-md text-on-surface font-semibold">{{ $proyecto['fecha_entrega'] }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Estado --}}
                <div class="login-card rounded-xl p-lg">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Estado</p>
                    <x-status-badge variant="info">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        En Progreso
                    </x-status-badge>
                </div>
            </div>

            {{-- Alcance --}}
            <div class="login-card rounded-xl p-lg">
                <h2 class="font-headline-sm text-headline-sm text-on-surface mb-md">Alcance del Proyecto</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mb-md leading-relaxed">
                    El objetivo principal es modernizar la interfaz de usuario para reflejar una imagen de profesionalidad, limpieza y confianza. Se requiere una arquitectura de información que priorice la reserva de citas y la visualización de servicios especializados.
                </p>
                <ul class="space-y-sm list-disc list-inside marker:text-on-surface-variant">
                    <li class="font-body-md text-body-md text-on-surface">Diseño UI responsivo (Desktop, Tablet, Mobile).</li>
                    <li class="font-body-md text-body-md text-on-surface">Integración de sistema de reservas API.</li>
                    <li class="font-body-md text-body-md text-on-surface">Panel de administración para gestión de contenidos médicos.</li>
                    <li class="font-body-md text-body-md text-on-surface">Optimización de velocidad de carga (LCP &lt; 2.5s).</li>
                </ul>
            </div>

            {{-- Tareas del Proyecto --}}
            <div class="login-card rounded-xl overflow-hidden">
                <div class="p-lg flex items-center justify-between border-b border-outline-variant">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Tareas del Proyecto</h2>
                    <button class="inline-flex items-center gap-sm font-label-md text-label-md text-primary hover:underline">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Nueva Tarea
                    </button>
                </div>
                <ul class="divide-y divide-outline-variant">
                    <li class="flex items-center gap-md p-lg">
                        <input type="checkbox" checked disabled
                            class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary cursor-not-allowed" />
                        <span class="flex-1 font-body-md text-body-md text-on-surface-variant line-through">Definición de Styleguide y paleta de colores</span>
                        <x-status-badge variant="success">Completada</x-status-badge>
                    </li>
                    <li class="flex items-center gap-md p-lg">
                        <input type="checkbox" disabled
                            class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary cursor-not-allowed" />
                        <span class="flex-1 font-body-md text-body-md text-on-surface">Wireframes de la página de servicios</span>
                        <x-status-badge variant="danger">Alta</x-status-badge>
                    </li>
                    <li class="flex items-center gap-md p-lg">
                        <input type="checkbox" disabled
                            class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary cursor-not-allowed" />
                        <span class="flex-1 font-body-md text-body-md text-on-surface">Prototipo interactivo en Figma</span>
                        <x-status-badge variant="info">Media</x-status-badge>
                    </li>
                    <li class="flex items-center gap-md p-lg">
                        <input type="checkbox" disabled
                            class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary cursor-not-allowed" />
                        <span class="flex-1 font-body-md text-body-md text-on-surface">Ajustes finales de SEO técnico</span>
                        <x-status-badge variant="neutral">Baja</x-status-badge>
                    </li>
                </ul>
            </div>

        </div>

        {{-- RIGHT SIDEBAR: Archivos Adjuntos --}}
        <aside>
            @include('partials.proyecto-archivos')
        </aside>

    </div>
</x-app-layout>
