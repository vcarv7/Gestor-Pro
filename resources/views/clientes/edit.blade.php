<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('clientes.show', $cliente['id']) }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver al cliente
            </a>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Editar Cliente</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Actualiza la información de {{ $cliente['name'] }}.
            </p>
        </div>

        <form method="POST" action="#" class="login-card rounded-xl p-lg space-y-lg">
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="md:col-span-2 space-y-xs">
                    <label for="name" class="block font-label-md text-label-md text-on-surface-variant">Nombre completo <span class="text-error">*</span></label>
                    <input id="name" name="name" type="text" required :value="$cliente['name']"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="email" class="block font-label-md text-label-md text-on-surface-variant">Email <span class="text-error">*</span></label>
                    <input id="email" name="email" type="email" required :value="$cliente['email']"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="phone" class="block font-label-md text-label-md text-on-surface-variant">Teléfono</label>
                    <input id="phone" name="phone" type="tel" :value="$cliente['phone']"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="md:col-span-2 space-y-xs">
                    <label for="company" class="block font-label-md text-label-md text-on-surface-variant">Empresa</label>
                    <input id="company" name="company" type="text" :value="$cliente['company']"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="md:col-span-2 space-y-xs">
                    <label for="notes" class="block font-label-md text-label-md text-on-surface-variant">Notas</label>
                    <textarea id="notes" name="notes" rows="4"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none">{{ $cliente['notes'] }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-sm pt-md border-t border-outline-variant">
                <a href="{{ route('clientes.show', $cliente['id']) }}" class="px-lg py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">Cancelar</a>
                <button type="submit" class="px-lg py-sm rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                    Guardar cambios
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
