<x-app-layout>
    <x-slot:title>Nuevo Cliente</x-slot:title>

    <div class="max-w-2xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('clientes.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Clientes
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Nuevo Cliente</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Completa los datos para registrar un nuevo cliente en tu directorio.
            </p>
        </div>

        {{-- Errores de validación --}}
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

        <form method="POST" action="{{ route('clientes.store') }}" class="login-card rounded-xl p-lg space-y-lg">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="md:col-span-2 space-y-xs">
                    <label for="nombre" class="block font-label-md text-label-md text-on-surface-variant">Nombre completo <span class="text-error">*</span></label>
                    <input id="nombre" name="nombre" type="text" required value="{{ old('nombre') }}" placeholder="Ej: María García"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('nombre') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="email" class="block font-label-md text-label-md text-on-surface-variant">Email <span class="text-error">*</span></label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="email@empresa.com"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('email') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="telefono" class="block font-label-md text-label-md text-on-surface-variant">Teléfono</label>
                    <input id="telefono" name="telefono" type="tel" value="{{ old('telefono') }}" placeholder="+1 (555) 000-0000"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('telefono') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="md:col-span-2 space-y-xs">
                    <label for="empresa" class="block font-label-md text-label-md text-on-surface-variant">Empresa <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional)</span></label>
                    <input id="empresa" name="empresa" type="text" value="{{ old('empresa') }}" placeholder="Ej: Acme Corp"
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('empresa') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="md:col-span-2 space-y-xs">
                    <label for="notas" class="block font-label-md text-label-md text-on-surface-variant">Notas <span class="font-body-sm text-body-sm text-on-surface-variant">(opcional, ej: prefiere colores fríos)</span></label>
                    <textarea id="notas" name="notas" rows="4" placeholder="Información adicional, contexto, preferencias, etc."
                        class="w-full px-md py-sm rounded-lg border {{ $errors->has('notas') ? 'border-error' : 'border-outline-variant' }} bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none">{{ old('notas') }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-sm pt-md border-t border-outline-variant">
                <a href="{{ route('clientes.index') }}" class="px-lg py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">Cancelar</a>
                <button type="submit" class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    Crear Cliente
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
