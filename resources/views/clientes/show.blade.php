<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-lg">

        <div>
            <a href="{{ route('clientes.index') }}" class="inline-flex items-center gap-xs font-label-md text-label-md text-on-surface-variant hover:text-primary mb-md">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver a Clientes
            </a>
        </div>

        {{-- Hero --}}
        <div class="login-card rounded-xl p-lg flex items-start gap-lg">
            <x-avatar :name="$cliente['name']" size="lg" />
            <div class="flex-1 min-w-0">
                <h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $cliente['name'] }}</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-xs">{{ $cliente['email'] }}</p>
                <div class="mt-md">
                    <x-status-badge variant="info">{{ $cliente['company'] }}</x-status-badge>
                </div>
            </div>
            <a href="{{ route('clientes.edit', $cliente['id']) }}"
                class="inline-flex items-center gap-sm px-md py-sm rounded-lg border border-outline-variant font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Editar
            </a>
        </div>

        {{-- Info grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            <div class="login-card rounded-xl p-lg">
                <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Contacto</h3>
                <dl class="space-y-md">
                    <div>
                        <dt class="font-label-sm text-label-sm text-on-surface-variant">Email</dt>
                        <dd class="font-body-md text-body-md text-on-surface mt-xs">{{ $cliente['email'] }}</dd>
                    </div>
                    <div>
                        <dt class="font-label-sm text-label-sm text-on-surface-variant">Teléfono</dt>
                        <dd class="font-body-md text-body-md text-on-surface mt-xs">{{ $cliente['phone'] }}</dd>
                    </div>
                </dl>
            </div>

            <div class="login-card rounded-xl p-lg">
                <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Empresa</h3>
                <p class="font-body-md text-body-md text-on-surface">{{ $cliente['company'] }}</p>
            </div>
        </div>

        {{-- Notas --}}
        <div class="login-card rounded-xl p-lg">
            <h3 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-md">Notas</h3>
            <p class="font-body-md text-body-md text-on-surface italic">{{ $cliente['notes'] }}</p>
        </div>

    </div>
</x-app-layout>
