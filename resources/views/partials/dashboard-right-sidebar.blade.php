{{-- Resumen Semanal (dark card) --}}
<div class="login-card rounded-xl bg-primary text-on-primary p-lg">
    <h3 class="font-headline-sm text-headline-sm mb-sm">Resumen Semanal</h3>
    <p class="font-body-sm text-body-sm opacity-90 mb-md leading-relaxed">
        @if ($tareasTotales === 0)
            Empezá creando tu primera tarea para ver tu progreso.
        @else
            Has completado el <strong>{{ $progresoSemanal }}%</strong> de tus tareas esta semana. ¡Sigue así!
        @endif
    </p>
    <div class="w-full h-2 bg-on-primary/20 rounded-full overflow-hidden mb-md">
        <div class="h-full bg-on-primary rounded-full transition-all" style="width: {{ $progresoSemanal }}%"></div>
    </div>
    <a href="{{ route('proyectos.index') }}" class="block w-full text-center px-md py-sm bg-on-primary text-primary rounded-lg font-label-md text-label-md hover:bg-on-primary/90 transition-colors">
        Ver Reporte
    </a>
</div>

{{-- Actividad Reciente --}}
<div class="login-card rounded-xl p-lg">
    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-md">Actividad Reciente</h3>
    @forelse ($actividadReciente as $act)
        <a href="{{ $act['url'] }}" class="flex items-start gap-sm py-sm first:pt-0 last:pb-0 border-b last:border-b-0 border-outline-variant hover:bg-surface-container rounded-md px-sm -mx-sm transition-colors">
            <span class="material-symbols-outlined text-primary text-[18px] mt-1 shrink-0">{{ $act['icon'] }}</span>
            <div class="min-w-0 flex-1">
                <p class="font-body-sm text-body-sm text-on-surface leading-snug truncate">
                    {{ $act['titulo'] }}
                    @if ($act['detalle'])
                        <span class="text-on-surface-variant">— {{ $act['detalle'] }}</span>
                    @endif
                </p>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-xs">{{ $act['fecha']->diffForHumans() }}</p>
            </div>
        </a>
    @empty
        <div class="text-center py-md">
            <span class="material-symbols-outlined text-on-surface-variant text-3xl">inbox</span>
            <p class="font-body-sm text-body-sm text-on-surface-variant mt-sm">Sin actividad reciente</p>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Creá tu primer proyecto para empezar.</p>
        </div>
    @endforelse
</div>
