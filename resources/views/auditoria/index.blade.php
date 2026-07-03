<x-app-layout>
    <div class="space-y-lg">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-md">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Registro de Actividad</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                    Seguimiento detallado de todas las acciones del sistema y cambios en proyectos.
                </p>
            </div>
            <div class="flex items-center gap-sm">
                <button class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Filtrar
                </button>
                <button class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    Exportar
                </button>
            </div>
        </div>

        {{-- 3 Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <x-stat-card label="Acciones Hoy" :value="142" icon="touch_app" iconBg="primary" />
            <x-stat-card label="Usuarios Activos" :value="12" icon="group" iconBg="primary" />
            <div class="login-card rounded-xl p-lg flex items-start justify-between gap-md">
                <div class="min-w-0">
                    <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Acciones Críticas</p>
                    <p class="font-display-lg text-display-lg text-error leading-none mt-md">3</p>
                </div>
                <div class="w-14 h-14 shrink-0 rounded-xl bg-error-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-error text-[28px]">warning</span>
                </div>
            </div>
        </div>

        {{-- Tabla de actividad --}}
        <div class="login-card rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-surface-container border-b border-outline-variant">
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Usuario</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Acción</th>
                            <th class="px-lg py-md text-right font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actividades as $a)
                            <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                <td class="px-lg py-md">
                                    <div class="flex items-center gap-sm">
                                        <x-avatar :name="$a['user']" size="sm" :color="$a['critica'] ? 'secondary' : 'primary'" />
                                        <div>
                                            <p class="font-body-md text-body-md text-on-surface font-semibold">{{ $a['user'] }}</p>
                                            <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $a['rol'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-lg py-md">
                                    <p class="font-body-md text-body-md text-on-surface">
                                        @if ($a['critica'])
                                            <x-status-badge variant="danger" class="mr-xs">Eliminación</x-status-badge>
                                        @endif
                                        {{ $a['accion'] }} <strong class="font-semibold">{{ $a['proyecto'] }}</strong>
                                    </p>
                                    @if ($a['detalle'])
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">{{ $a['detalle'] }}</p>
                                    @endif
                                </td>
                                <td class="px-lg py-md text-right font-body-sm text-body-sm text-on-surface-variant whitespace-nowrap">{{ $a['timestamp'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-pagination :current="1" :last="248" :total="1240" :perPage="5" label="registros" />
        </div>

        {{-- Banner de ayuda --}}
        <div class="border border-outline-variant border-dashed rounded-xl p-lg flex items-center gap-md">
            <div class="w-10 h-10 rounded-lg bg-primary-container text-on-primary-container flex items-center justify-center font-headline-sm text-headline-sm shrink-0">?</div>
            <div class="flex-1 min-w-0">
                <p class="font-headline-sm text-headline-sm text-on-surface">¿Necesitas ayuda con las auditorías?</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">Puedes configurar alertas automáticas para acciones críticas o exportar reportes mensuales para cumplimiento legal.</p>
            </div>
            <a href="#" class="font-label-md text-label-md text-primary hover:underline shrink-0">Ver Guía de Auditoría</a>
        </div>

    </div>
</x-app-layout>
