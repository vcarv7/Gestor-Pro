<x-app-layout>
    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endpush

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-lg">

        {{-- MAIN CONTENT --}}
        <div class="space-y-lg">

            {{-- Header --}}
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Panel de Control</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                    Bienvenido de nuevo, {{ Auth::user()->name }}. Aquí tienes el resumen de tu actividad.
                </p>
            </div>

            {{-- 3 Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                <x-stat-card label="Total Clientes" :value="$totalClientes" icon="group" iconBg="primary" />
                <x-stat-card label="Proyectos Activos" :value="$proyectosActivos" icon="folder_open" iconBg="primary" />
                <x-stat-card label="Tareas Pendientes" :value="$tareasPendientes" icon="task_alt" iconBg="primary" />
            </div>

            {{-- Chart: Proyectos creados --}}
            <div class="login-card rounded-xl p-lg">
                <div class="flex items-center justify-between mb-md">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Proyectos creados</h2>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Últimos 6 meses</span>
                </div>
                <div class="h-[280px]">
                    <canvas id="proyectosChart"></canvas>
                </div>
            </div>

            {{-- Tareas Urgentes --}}
            <div class="login-card rounded-xl overflow-hidden">
                <div class="p-lg flex items-center justify-between border-b border-outline-variant">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Tareas Urgentes</h2>
                    <a href="{{ route('proyectos.index') }}" class="font-label-md text-label-md text-primary hover:underline flex items-center gap-xs">
                        Ver todas
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-surface-container border-b border-outline-variant">
                                <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nombre de Tarea</th>
                                <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Proyecto</th>
                                <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Fecha Límite</th>
                                <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Prioridad</th>
                                <th class="px-lg py-md text-right font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tareasUrgentes as $tarea)
                                <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                    <td class="px-lg py-md font-body-md text-body-md text-on-surface">{{ $tarea->nombre }}</td>
                                    <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">
                                        @if ($tarea->proyecto)
                                            <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="hover:text-primary">
                                                {{ $tarea->proyecto->titulo }}
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">{{ $tarea->fechaHumana() }}</td>
                                    <td class="px-lg py-md">
                                        <x-status-badge :variant="$tarea->prioridadBadgeVariant()">{{ $tarea->prioridadLabel() }}</x-status-badge>
                                    </td>
                                    <td class="px-lg py-md text-right">
                                        <a href="{{ route('tareas.edit', $tarea) }}" class="text-on-surface-variant hover:text-primary p-sm rounded-md hover:bg-surface-container-high transition-colors inline-block" title="Ver/editar">
                                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-lg py-xl text-center">
                                        <span class="material-symbols-outlined text-on-surface-variant text-4xl">task_alt</span>
                                        <p class="font-body-md text-body-md text-on-surface-variant mt-md">No hay tareas urgentes pendientes.</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant">Cuando tengas tareas con prioridad Alta, aparecerán acá.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- RIGHT SIDEBAR --}}
        <aside class="space-y-lg">
            @include('partials.dashboard-right-sidebar', [
                'progresoSemanal' => $progresoSemanal,
                'tareasCompletadasSemana' => $tareasCompletadasSemana,
                'tareasTotales' => $tareasTotales,
                'actividadReciente' => $actividadReciente,
            ])
        </aside>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('proyectosChart');
            if (!ctx || typeof Chart === 'undefined') return;

            const labels = @json($proyectosPorMes->pluck('label'));
            const data = @json($proyectosPorMes->pluck('count'));
            const maxValue = Math.max(...data, 1);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Proyectos',
                        data: data,
                        backgroundColor: '#0f172a',
                        borderRadius: 6,
                        barThickness: 32,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: maxValue + 2,
                            ticks: { stepSize: 1, color: '#76777d', font: { family: 'Inter', size: 12 } },
                            grid: { color: '#e2e8f0', drawBorder: false },
                        },
                        x: {
                            ticks: { color: '#76777d', font: { family: 'Inter', size: 12 } },
                            grid: { display: false },
                        }
                    }
                }
            });
        });
    </script>
    @endpush

</x-app-layout>
