<div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant">
    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Información Personal</h2>

    <form method="POST" action="{{ route('settings.update-profile') }}" data-loading class="space-y-md w-full">
        @csrf
        @method('PUT')

        <div class="space-y-xs">
            <label for="name" class="block font-label-md text-label-md text-on-surface-variant">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                class="block w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
        </div>

        <div class="space-y-xs">
            <label for="email" class="block font-label-md text-label-md text-on-surface-variant">Correo Electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}"
                class="block w-full px-md py-sm rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" />
        </div>

        <div class="pt-sm">
            <button type="submit"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Guardar Cambios</span>
            </button>
        </div>
    </form>
</div>
