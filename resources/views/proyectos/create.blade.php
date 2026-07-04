<x-app-layout>
    <x-slot:title>Nuevo Proyecto</x-slot:title>

    <div class="max-w-3xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('proyectos.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Proyectos
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Nuevo Proyecto</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Completá los datos del proyecto. La asignación a un cliente es obligatoria.
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

        <form method="POST" action="{{ route('proyectos.store') }}" class="login-card rounded-xl p-lg space-y-lg">
            @csrf

            <div class="space-y-xs">
                <label for="titulo" class="block font-label-md text-label-md text-on-surface-variant">Título <span class="text-error">*</span></label>
                <input id="titulo" name="titulo" type="text" required value="{{ old('titulo') }}" placeholder="Ej: Rediseño web para Clínica Dental"
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('titulo') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
            </div>

            <div class="space-y-xs">
                <label for="descripcion" class="block font-label-md text-label-md text-on-surface-variant">Descripción <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional)</span></label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Explicación larga del alcance del proyecto..."
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('descripcion') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none">{{ old('descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label for="fecha_inicio" class="block font-label-md text-label-md text-on-surface-variant">Fecha de inicio <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional)</span></label>
                    <input id="fecha_inicio" name="fecha_inicio" type="date" value="{{ old('fecha_inicio') }}"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('fecha_inicio') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="fecha_entrega" class="block font-label-md text-label-md text-on-surface-variant">Fecha de entrega <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional)</span></label>
                    <input id="fecha_entrega" name="fecha_entrega" type="date" value="{{ old('fecha_entrega') }}"
                    class="w-full px-md py-sm rounded-lg border {{ $errors->has('fecha_entrega') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="space-y-xs">
                    <label for="estado" class="block font-label-md text-label-md text-on-surface-variant">Estado <span class="text-error">*</span></label>
                    <select id="estado" name="estado" required
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('estado') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="pendiente" {{ old('estado', 'pendiente') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ old('estado') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completado" {{ old('estado') === 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelado" {{ old('estado') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div class="space-y-xs">
                    <label for="cliente_id" class="block font-label-md text-label-md text-on-surface-variant">Cliente <span class="text-error">*</span></label>
                    @if ($clientes->isEmpty())
                        <p class="text-sm text-error">No tenés clientes. <a href="{{ route('clientes.create') }}" class="underline">Creá uno primero</a>.</p>
                    @else
                        <select id="cliente_id" name="cliente_id" required
                            class="w-full px-md py-sm rounded-lg border {{ $errors->has('cliente_id') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                            <option value="">— Seleccionar cliente —</option>
                            @foreach ($clientes as $c)
                                <option value="{{ $c->id }}" {{ (string) old('cliente_id') === (string) $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}{{ $c->empresa ? ' (' . $c->empresa . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-sm pt-md border-t border-outline-variant">
                <a href="{{ route('proyectos.index') }}" class="px-lg py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">Cancelar</a>
                <button type="submit" class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    Crear Proyecto
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
