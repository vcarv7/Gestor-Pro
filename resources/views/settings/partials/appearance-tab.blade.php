<div class="bg-surface-container-lowest rounded-xl p-lg border border-outline-variant">
    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Apariencia</h2>

    <form method="POST" action="{{ route('settings.update-appearance') }}" data-loading class="space-y-md w-full">
        @csrf
        @method('PUT')

        <label class="flex items-center gap-md p-md rounded-lg border border-outline-variant bg-surface-container-lowest cursor-pointer hover:bg-surface-container transition-colors">
            <input type="checkbox" name="dark_mode" value="1" {{ $setting->dark_mode ? 'checked' : '' }}
                class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" />
            <div>
                <div class="font-label-md text-label-md text-on-surface-variant">Modo Oscuro</div>
                <div class="font-body-sm text-body-sm text-on-surface-variant">Activa el tema oscuro (próximamente)</div>
            </div>
        </label>

        <div class="pt-sm">
            <button type="submit"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                <span class="material-symbols-outlined text-[18px]">palette</span>
                <span>Guardar</span>
            </button>
        </div>
    </form>
</div>
