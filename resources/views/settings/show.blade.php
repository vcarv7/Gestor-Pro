<x-app-layout>
    <x-slot:title>Ajustes</x-slot:title>

    @php
        $tabs = [
            'profile' => ['label' => 'Perfil', 'icon' => 'person'],
            'security' => ['label' => 'Seguridad', 'icon' => 'lock'],
            'notifications' => ['label' => 'Notificaciones', 'icon' => 'notifications'],
            'appearance' => ['label' => 'Apariencia', 'icon' => 'palette'],
            'account' => ['label' => 'Cuenta', 'icon' => 'delete'],
        ];
        $activeTab = request('tab', 'profile');
    @endphp

    <div class="space-y-lg" x-data="{ tab: '{{ $activeTab }}' }">

        {{-- Header --}}
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface">Ajustes</h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-xs">
                Configura tu perfil, seguridad y preferencias.
            </p>
        </div>

        {{-- Flash message --}}
        @if (session('status'))
            <div class="rounded-xl p-md bg-secondary-container border border-secondary-fixed">
                <p class="font-body-md text-body-md text-on-secondary-container">{{ session('status') }}</p>
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-xl p-md bg-error-container border border-error">
                <ul class="space-y-xs">
                    @foreach ($errors->all() as $error)
                        <li class="font-body-md text-body-md text-on-error-container">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-lg">

            {{-- Tabs --}}
            <nav class="lg:w-56 shrink-0 flex lg:flex-col gap-xs">
                @foreach ($tabs as $key => $tab)
                    <button @click="tab = '{{ $key }}'"
                        class="flex items-center gap-md px-md py-sm rounded-lg font-body-md text-body-md transition-colors text-left"
                        :class="tab === '{{ $key }}' ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface'">
                        <span class="material-symbols-outlined text-[20px]">{{ $tab['icon'] }}</span>
                        <span>{{ $tab['label'] }}</span>
                    </button>
                @endforeach
            </nav>

            {{-- Content --}}
            <div class="flex-1 min-w-0 w-full">
                <div x-show="tab === 'profile'">
                    @include('settings.partials.profile-tab')
                </div>
                <div x-show="tab === 'security'">
                    @include('settings.partials.security-tab')
                </div>
                <div x-show="tab === 'notifications'">
                    @include('settings.partials.notifications-tab')
                </div>
                <div x-show="tab === 'appearance'">
                    @include('settings.partials.appearance-tab')
                </div>
                <div x-show="tab === 'account'">
                    @include('settings.partials.account-tab')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
