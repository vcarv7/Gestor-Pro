<x-app-layout>
    <div class="space-y-lg">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-md">
            <div>
                <h1 class="font-headline-lg text-headline-lg text-on-surface">Clientes</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                    Manage your professional network and contact directory.
                </p>
            </div>
            <a href="{{ route('clientes.create') }}"
                class="inline-flex items-center gap-sm px-lg py-md rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-black transition-colors">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                <span>+ Nuevo Cliente</span>
            </a>
        </div>

        {{-- Stats + Validation hint --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <x-stat-card label="Total Clients" :value="124" icon="group" iconBg="primary" />
            <x-stat-card label="Active Leads" :value="32" icon="contact_page" iconBg="primary" />
            <div class="login-card rounded-xl p-lg flex items-center gap-md bg-secondary-container border-secondary-fixed">
                <span class="material-symbols-outlined text-on-secondary-container text-[28px]">info</span>
                <p class="font-body-sm text-body-sm text-on-secondary-container">
                    <strong>Validation hint:</strong> Nombre y Email son obligatorios para crear nuevos registros.
                </p>
            </div>
        </div>

        {{-- Tabla de clientes --}}
        <div class="login-card rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-surface-container border-b border-outline-variant">
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Name</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Email</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Phone</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Company</th>
                            <th class="px-lg py-md text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Notes</th>
                            <th class="px-lg py-md text-right font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $c)
                            <tr class="border-b border-outline-variant hover:bg-surface-container transition-colors">
                                <td class="px-lg py-md">
                                    <a href="{{ route('clientes.show', $c['id']) }}" class="flex items-center gap-sm group">
                                        <x-avatar :name="$c['name']" size="sm" />
                                        <span class="font-body-md text-body-md text-on-surface group-hover:text-primary font-semibold">{{ $c['name'] }}</span>
                                    </a>
                                </td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">{{ $c['email'] }}</td>
                                <td class="px-lg py-md font-body-md text-body-md text-on-surface-variant">{{ $c['phone'] }}</td>
                                <td class="px-lg py-md">
                                    <x-status-badge variant="info">{{ $c['company'] }}</x-status-badge>
                                </td>
                                <td class="px-lg py-md font-body-sm text-body-sm italic text-on-surface-variant max-w-xs truncate">{{ $c['notes'] }}</td>
                                <td class="px-lg py-md text-right">
                                    <button class="text-on-surface-variant hover:text-on-surface p-sm rounded-md hover:bg-surface-container-high transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-pagination :current="1" :last="13" :total="124" :perPage="10" label="clients" />
        </div>

    </div>
</x-app-layout>
