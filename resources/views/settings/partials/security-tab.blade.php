<div class="bg-surface-container-low rounded-xl p-lg border border-outline-variant">
    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Cambiar Contraseña</h2>

    <form method="POST" action="{{ route('settings.update-password') }}" data-loading class="space-y-md max-w-xl">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password" class="block font-label-md text-label-md text-on-surface mb-sm">Contraseña Actual</label>
            <input id="current_password" name="current_password" type="password"
                class="w-full px-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />
        </div>

        <div>
            <label for="password" class="block font-label-md text-label-md text-on-surface mb-sm">Nueva Contraseña</label>
            <input id="password" name="password" type="password"
                class="w-full px-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />
        </div>

        <div>
            <label for="password_confirmation" class="block font-label-md text-label-md text-on-surface mb-sm">Confirmar Nueva Contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="w-full px-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />
        </div>

        <div class="pt-sm">
            <button type="submit"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                <span>Actualizar Contraseña</span>
            </button>
        </div>
    </form>
</div>
