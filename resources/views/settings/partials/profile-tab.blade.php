<div class="bg-surface-container-low rounded-xl p-lg border border-outline-variant">
    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Información Personal</h2>

    <form method="POST" action="{{ route('settings.update-profile') }}" data-loading class="space-y-md max-w-xl">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-label-md text-label-md text-on-surface mb-sm">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                class="w-full px-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />
        </div>

        <div>
            <label for="email" class="block font-label-md text-label-md text-on-surface mb-sm">Correo Electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}"
                class="w-full px-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />
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
