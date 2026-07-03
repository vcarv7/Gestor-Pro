@props([])

@php
    $navItems = [
        ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'dashboard'],
        ['name' => 'Clientes', 'route' => 'clientes.index', 'icon' => 'group'],
        ['name' => 'Proyectos', 'route' => 'proyectos.index', 'icon' => 'folder'],
        ['name' => 'Actividad', 'route' => 'auditoria.index', 'icon' => 'history'],
        ['name' => 'Ajustes', 'route' => '#', 'icon' => 'settings'],
    ];
@endphp

<aside class="w-64 shrink-0 bg-surface-container-lowest border-r border-outline-variant flex flex-col h-screen sticky top-0">

    {{-- Logo --}}
    <div class="px-md py-lg border-b border-outline-variant">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-start gap-xs">
            <x-logo class="w-10 h-10" />
            <div>
                <h1 class="font-headline-sm text-headline-sm text-primary leading-tight">Mi Gestor Pro</h1>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Freelance Workspace</p>
            </div>
        </a>
    </div>

    {{-- Nav items --}}
    <nav class="flex-1 px-sm py-md overflow-y-auto">
        <ul class="space-y-xs">
            @foreach ($navItems as $item)
                @php
                    $isActive = $item['route'] !== '#' && request()->routeIs($item['route']);
                @endphp
                <li>
                    <a href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}"
                        class="flex items-center gap-md px-md py-sm rounded-lg font-body-md text-body-md transition-colors
                        {{ $isActive ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">{{ $item['icon'] }}</span>
                        <span>{{ $item['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- Footer: New Project + Help + Logout --}}
    <div class="px-sm py-md border-t border-outline-variant space-y-sm">

        {{-- + New Project --}}
        <a href="{{ route('proyectos.index') }}"
            class="flex items-center justify-center gap-sm w-full px-md py-sm rounded-lg font-label-md text-label-md bg-primary text-on-primary hover:bg-black transition-colors">
            <span class="material-symbols-outlined text-[18px]">add</span>
            <span>New Project</span>
        </a>

        {{-- Help --}}
        <a href="#" class="flex items-center gap-md px-md py-sm rounded-lg font-body-sm text-body-sm text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[18px]">help</span>
            <span>Help</span>
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-md w-full px-md py-sm rounded-lg font-body-sm text-body-sm text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>
