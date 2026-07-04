<x-app-layout>
    <x-slot:title>Nueva Tarea</x-slot:title>

    <div class="max-w-2xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('proyectos.show', $proyecto) }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver al proyecto
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Nueva Tarea</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Agregar una tarea al proyecto: <strong class="text-on-surface">{{ $proyecto->titulo }}</strong>
            </p>
        </div>

        @if ($errors->any())
            <div class="login-card rounded-xl p-md bg-error-container border-error">
                <p class="font-label-md text-label-md text-on-error-container mb-xs">Hay errores en el formulario:</p>
                <ul class="list-disc list-inside font-body-sm text-body-sm text-on-error-container">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('proyectos.tareas.store', $proyecto) }}" class="login-card rounded-xl p-lg space-y-lg">
            @csrf
            <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">

            <div class="space-y-xs">
                <label for="nombre" class="block font-label-md text-label-md text-on-surface-variant">Nombre de la tarea <span class="text-error">*</span></label>
                <input id="nombre" name="nombre" type="text" required value="{{ old('nombre') }}" placeholder="Ej: Definir styleguide y paleta de colores"
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('nombre') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
            </div>

            <div class="space-y-xs">
                <label for="descripcion" class="block font-label-md text-label-md text-on-surface-variant">Descripción <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional)</span></label>
                <textarea id="descripcion" name="descripcion" rows="3" placeholder="Detalles, contexto, criterios de aceptación..."
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('descripcion') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none">{{ old('descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label for="fecha_limite" class="block font-label-md text-label-md text-on-surface-variant">Fecha límite <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional)</span></label>
                    <input id="fecha_limite" name="fecha_limite" type="date" value="{{ old('fecha_limite') }}"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('fecha_limite') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="prioridad" class="block font-label-md text-label-md text-on-surface-variant">Prioridad <span class="text-error">*</span></label>
                    <select id="prioridad" name="prioridad" required
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('prioridad') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="baja" {{ old('prioridad') === 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ old('prioridad', 'media') === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ old('prioridad') === 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-sm pt-md border-t border-outline-variant">
                <a href="{{ route('proyectos.show', $proyecto) }}" class="px-lg py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">Cancelar</a>
                <button type="submit" class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    Crear Tarea
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
