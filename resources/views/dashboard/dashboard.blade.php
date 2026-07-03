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
                <x-stat-card label="Total Clientes" :value="15" icon="group" iconBg="primary" />
                <x-stat-card label="Proyectos Activos" :value="8" icon="folder_open" iconBg="primary" />
                <x-stat-card label="Tareas Pendientes" :value="12" icon="task_alt" iconBg="primary" />
            </div>

            {{-- Chart: Proyectos creados --}}
            <div class="login-card rounded-xl p-lg">
                <div class="flex items-center justify-between mb-md">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Proyectos creados</h2>
                    <select class="px-md py-xs rounded-lg border border-outline-variant bg-surface-container-lowest font-label-md text-label-md text-on-surface focus:ring-2 focus:ring-primary focus:border-primary outline-none cursor-pointer">
                        <option>Últimos 6 meses</option>
                        <option>Último año</option>
                        <option>Todo</option>
                    </select>
                </div>
                <div class="h-[280px]">
                    <canvas id="proyectosChart"></canvas>
                </div>
            </div>

            {{-- Tareas Urgentes --}}
            <div class="login-card rounded-xl overflow-hidden">
                <div class="p-lg flex items-center justify-between border-b border-outline-variant">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Tareas Urgentes</h2>
                    <a href="#" class="font-label-md text-label-md text-primary hover:underline flex items-center gap-xs">
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
                            <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface">Revisión de Prototipo V2</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">Rediseño Web UX</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">Hoy, 18:00</td>
                                <td class="px-lg py-md">
                                    <x-status-badge variant="danger">Alta</x-status-badge>
                                </td>
                                <td class="px-lg py-md text-right">
                                    <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface">Envío de Factura Final</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">Consultoría IT</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">Mañana, 09:00</td>
                                <td class="px-lg py-md">
                                    <x-status-badge variant="danger">Alta</x-status-badge>
                                </td>
                                <td class="px-lg py-md text-right">
                                    <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface line-through opacity-60">Definición de Styleguide y paleta de colores</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">Branding</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">Ayer</td>
                                <td class="px-lg py-md">
                                    <x-status-badge variant="success">Completada</x-status-badge>
                                </td>
                                <td class="px-lg py-md text-right">
                                    <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- RIGHT SIDEBAR --}}
        <aside class="space-y-lg">
            @include('partials.dashboard-right-sidebar')
        </aside>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('proyectosChart');
            if (!ctx || typeof Chart === 'undefined') return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct'],
                    datasets: [{
                        label: 'Proyectos',
                        data: [4, 7, 5, 9, 6, 8],
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
                            max: 9,
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
