<x-app-layout>
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

        <form method="POST" action="#" class="login-card rounded-xl p-lg space-y-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                <div class="md:col-span-2 space-y-xs">
                    <label for="name" class="block font-label-md text-label-md text-on-surface-variant">Nombre completo <span class="text-error">*</span></label>
                    <input id="name" name="name" type="text" required placeholder="Ej: María García"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="email" class="block font-label-md text-label-md text-on-surface-variant">Email <span class="text-error">*</span></label>
                    <input id="email" name="email" type="email" required placeholder="email@empresa.com"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="space-y-xs">
                    <label for="phone" class="block font-label-md text-label-md text-on-surface-variant">Teléfono</label>
                    <input id="phone" name="phone" type="tel" placeholder="+1 (555) 000-0000"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="md:col-span-2 space-y-xs">
                    <label for="company" class="block font-label-md text-label-md text-on-surface-variant">Empresa</label>
                    <input id="company" name="company" type="text" placeholder="Ej: Acme Corp"
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
                </div>

                <div class="md:col-span-2 space-y-xs">
                    <label for="notes" class="block font-label-md text-label-md text-on-surface-variant">Notas</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Información adicional, contexto, etc."
                        class="w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none"></textarea>
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
