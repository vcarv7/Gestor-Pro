<div class="bg-surface-container-low rounded-xl p-lg border border-outline-variant">
    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Preferencias de Notificaciones</h2>

    <form method="POST" action="{{ route('settings.update-notifications') }}" data-loading class="space-y-md max-w-xl">
        @csrf
        @method('PUT')

        <div class="space-y-md">
            <label class="flex items-center gap-md p-md rounded-lg border border-outline-variant bg-surface-container-lowest cursor-pointer hover:bg-surface-container transition-colors">
                <input type="checkbox" name="notify_password_change" value="1" {{ $setting->notify_password_change ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" />
                <div>
                    <div class="font-label-md text-label-md text-on-surface">Cambio de contraseña</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant">Cuando cambies tu contraseña</div>
                </div>
            </label>

            <label class="flex items-center gap-md p-md rounded-lg border border-outline-variant bg-surface-container-lowest cursor-pointer hover:bg-surface-container transition-colors">
                <input type="checkbox" name="notify_cliente_delete" value="1" {{ $setting->notify_cliente_delete ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" />
                <div>
                    <div class="font-label-md text-label-md text-on-surface">Eliminación de clientes</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant">Cuando elimines un cliente</div>
                </div>
            </label>

            <label class="flex items-center gap-md p-md rounded-lg border border-outline-variant bg-surface-container-lowest cursor-pointer hover:bg-surface-container transition-colors">
                <input type="checkbox" name="notify_proyecto_delete" value="1" {{ $setting->notify_proyecto_delete ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" />
                <div>
                    <div class="font-label-md text-label-md text-on-surface">Eliminación de proyectos</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant">Cuando elimines un proyecto</div>
                </div>
            </label>

            <label class="flex items-center gap-md p-md rounded-lg border border-outline-variant bg-surface-container-lowest cursor-pointer hover:bg-surface-container transition-colors">
                <input type="checkbox" name="notify_tarea_bulk_delete" value="1" {{ $setting->notify_tarea_bulk_delete ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" />
                <div>
                    <div class="font-label-md text-label-md text-on-surface">Eliminación masiva de tareas</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant">Cuando elimines varias tareas a la vez</div>
                </div>
            </label>
        </div>

        <div class="pt-sm">
            <button type="submit"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                <span class="material-symbols-outlined text-[18px]">notifications</span>
                <span>Guardar Preferencias</span>
            </button>
        </div>
    </form>
</div>
