{{-- Resumen Semanal (dark card) --}}
<div class="login-card rounded-xl bg-primary text-on-primary p-lg">
    <h3 class="font-headline-sm text-headline-sm mb-sm">Resumen Semanal</h3>
    <p class="font-body-sm text-body-sm opacity-90 mb-md leading-relaxed">
        Has completado el <strong>75%</strong> de tus objetivos esta semana. ¡Sigue así!
    </p>
    <div class="w-full h-2 bg-on-primary/20 rounded-full overflow-hidden mb-md">
        <div class="h-full bg-on-primary rounded-full" style="width: 75%"></div>
    </div>
    <button class="w-full px-md py-sm bg-on-primary text-primary rounded-lg font-label-md text-label-md hover:bg-on-primary/90 transition-colors">
        Ver Reporte
    </button>
</div>

{{-- Actividad Reciente --}}
<div class="login-card rounded-xl p-lg">
    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-md">Actividad Reciente</h3>
    <ul class="space-y-md">
        <li class="flex items-start gap-sm">
            <span class="material-symbols-outlined text-primary text-[18px] mt-1">circle</span>
            <div>
                <p class="font-body-sm text-body-sm text-on-surface leading-snug">
                    Contrato firmado por <strong>Cliente A</strong>
                </p>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-xs">Hace 2 horas</p>
            </div>
        </li>
        <li class="flex items-start gap-sm">
            <span class="material-symbols-outlined text-primary text-[18px] mt-1">circle</span>
            <div>
                <p class="font-body-sm text-body-sm text-on-surface leading-snug">
                    Proyecto <strong>"Branding Global"</strong> actualizado
                </p>
                <p class="font-label-sm text-label-sm text-on-surface-variant mt-xs">Hace 5 horas</p>
            </div>
        </li>
    </ul>
</div>
