<x-app-layout>
    <x-slot:title>Editar Proyecto</x-slot:title>

    <div class="max-w-3xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('proyectos.show', $proyecto) }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver al proyecto
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Editar Proyecto</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Actualiza los datos de {{ $proyecto->titulo }}.
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

        <form method="POST" action="{{ route('proyectos.update', $proyecto) }}" class="login-card rounded-xl p-lg space-y-lg">
            @csrf
            @method('PUT')

            <div class="space-y-xs">
                <label for="titulo" class="block font-label-md text-label-md text-on-surface-variant">Título <span class="text-error">*</span></label>
                <input id="titulo" name="titulo" type="text" required value="{{ old('titulo', $proyecto->titulo) }}" placeholder="Ej: Rediseño web para Clínica Dental"
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('titulo') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
            </div>

            <div class="space-y-xs">
                <label for="descripcion" class="block font-label-md text-label-md text-on-surface-variant">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Explicación larga del alcance del proyecto..."
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('descripcion') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none">{{ old('descripcion', $proyecto->descripcion) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label for="fecha_inicio" class="block font-label-md text-label-md text-on-surface-variant">Fecha de inicio</label>
                    <input id="fecha_inicio" name="fecha_inicio" type="date" value="{{ old('fecha_inicio', $proyecto->fecha_inicio?->format('Y-m-d')) }}"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('fecha_inicio') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="fecha_entrega" class="block font-label-md text-label-md text-on-surface-variant">Fecha de entrega</label>
                    <input id="fecha_entrega" name="fecha_entrega" type="date" value="{{ old('fecha_entrega', $proyecto->fecha_entrega?->format('Y-m-d')) }}"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('fecha_entrega') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label for="estado" class="block font-label-md text-label-md text-on-surface-variant">Estado <span class="text-error">*</span></label>
                    <select id="estado" name="estado" required
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('estado') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        @foreach (['pendiente' => 'Pendiente', 'en_progreso' => 'En Progreso', 'completado' => 'Completado', 'cancelado' => 'Cancelado'] as $value => $label)
                            <option value="{{ $value }}" {{ old('estado', $proyecto->estado) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-xs">
                    <label for="cliente_id" class="block font-label-md text-label-md text-on-surface-variant">Cliente <span class="text-error">*</span></label>
                    <select id="cliente_id" name="cliente_id" required
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('cliente_id') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="">— Seleccionar cliente —</option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}" {{ (string) old('cliente_id', $proyecto->cliente_id) === (string) $c->id ? 'selected' : '' }}>
                                {{ $c->nombre }}{{ $c->empresa ? ' (' . $c->empresa . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-sm pt-md border-t border-outline-variant">
                <a href="{{ route('proyectos.show', $proyecto) }}" class="px-lg py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">Cancelar</a>
                <button type="submit" class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    Guardar cambios
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
