@props([])

@php
    $user = Auth::user();
    $name = $user->name ?? 'Admin';
    $initials = '';
    foreach (explode(' ', $name) as $part) {
        $initials .= strtoupper(mb_substr($part, 0, 1));
        if (strlen($initials) >= 2) break;
    }
@endphp

<header class="sticky top-0 z-10 bg-surface-container-lowest border-b border-outline-variant px-lg py-md flex items-center gap-md">

    {{-- Search --}}
    <div class="flex-1 max-w-2xl relative">
        <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline pointer-events-none text-[20px]">search</span>
        <input type="text" placeholder="Buscar proyectos, clientes o tareas..."
            class="w-full pl-[44px] pr-md py-sm bg-surface-container-low border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface placeholder:text-outline focus:ring-2 focus:ring-primary focus:border-primary focus:bg-surface-container-lowest transition-all outline-none" />
    </div>

    {{-- Actions --}}
    <div class="flex items-center gap-xs">

        {{-- Notificaciones --}}
        <button class="relative p-sm rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[22px]">notifications</span>
            <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-error"></span>
        </button>

        {{-- Mensajes --}}
        <button class="p-sm rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-[22px]">chat_bubble</span>
        </button>

        {{-- User info (avatar + name + role) --}}
        <div class="flex items-center gap-sm ml-md pl-md border-l border-outline-variant">
            <div class="text-right hidden sm:block">
                <div class="font-label-md text-label-md text-on-surface leading-tight">{{ $name }}</div>
                <div class="font-label-sm text-label-sm text-on-surface-variant">Plan Pro</div>
            </div>
            <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md text-label-md">
                {{ $initials ?: 'AD' }}
            </div>
        </div>

    </div>

</header>
