<div class="bg-error-container/20 rounded-xl p-lg border border-error">
    <h2 class="font-headline-sm text-headline-sm text-error mb-lg">Eliminar Cuenta</h2>

    <p class="font-body-md text-body-md text-on-surface mb-md max-w-xl">
        Esta acción es irreversible. Se eliminarán permanentemente todos tus datos:
        clientes, proyectos, tareas y registros de actividad.
    </p>

    <form method="POST" action="{{ route('settings.destroy-account') }}" data-loading
        onsubmit="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.');"
        class="space-y-md max-w-xl">
        @csrf
        @method('DELETE')

        <div>
            <label for="password" class="block font-label-md text-label-md text-on-surface mb-sm">Confirma tu contraseña para eliminar la cuenta</label>
            <input id="password" name="password" type="password"
                class="w-full px-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-error focus:border-error focus:bg-surface-container-lowest transition-all outline-none" />
        </div>

        <div class="pt-sm">
            <button type="submit"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-error text-on-error font-label-md text-label-md hover:bg-red-800 transition-colors">
                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                <span>Eliminar mi cuenta</span>
            </button>
        </div>
    </form>
</div>
