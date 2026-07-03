@props([
    'current' => 1,
    'last' => 1,
    'total' => 0,
    'perPage' => 10,
    'label' => 'registros',
])

@php
    $showingFrom = $total > 0 ? (($current - 1) * $perPage) + 1 : 0;
    $showingTo = min($current * $perPage, $total);

    // Generar páginas visibles: primera, ..., actual-1, actual, actual+1, ..., última
    $pages = [];
    if ($last <= 7) {
        $pages = range(1, $last);
    } else {
        $pages[] = 1;
        if ($current > 4) $pages[] = '...';
        for ($i = max(2, $current - 1); $i <= min($last - 1, $current + 1); $i++) {
            $pages[] = $i;
        }
        if ($current < $last - 3) $pages[] = '...';
        $pages[] = $last;
    }
@endphp

<div class="flex items-center justify-between px-md py-md border-t border-outline-variant">
    <p class="font-body-sm text-body-sm text-on-surface-variant">
        Mostrando {{ $showingFrom }} a {{ $showingTo }} de {{ $total }} {{ $label }}
    </p>

    <div class="flex items-center gap-xs">

        {{-- Previous --}}
        <button @disabled($current <= 1)
            class="w-9 h-9 flex items-center justify-center rounded-md border border-outline-variant text-on-surface-variant hover:bg-surface-container disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
        </button>

        {{-- Page numbers --}}
        @foreach ($pages as $page)
            @if ($page === '...')
                <span class="w-9 h-9 flex items-center justify-center font-body-sm text-on-surface-variant">…</span>
            @else
                <button
                    class="min-w-9 h-9 px-sm flex items-center justify-center rounded-md font-body-sm transition-colors
                    {{ $page === $current ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container' }}">
                    {{ $page }}
                </button>
            @endif
        @endforeach

        {{-- Next --}}
        <button @disabled($current >= $last)
            class="w-9 h-9 flex items-center justify-center rounded-md border border-outline-variant text-on-surface-variant hover:bg-surface-container disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
        </button>

    </div>
</div>
