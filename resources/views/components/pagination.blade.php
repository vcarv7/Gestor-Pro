@props(['paginator'])

@php
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();
    $total = $paginator->total();
    $perPage = $paginator->perPage();
    $label = 'registros';

    $showingFrom = $total > 0 ? (($current - 1) * $perPage) + 1 : 0;
    $showingTo = min($current * $perPage, $total);

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

        @if ($current > 1)
            <a href="{{ $paginator->url($current - 1) }}"
                class="w-9 h-9 flex items-center justify-center rounded-md border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center rounded-md border border-outline-variant text-on-surface-variant opacity-30 cursor-not-allowed">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </span>
        @endif

        @foreach ($pages as $page)
            @if ($page === '...')
                <span class="w-9 h-9 flex items-center justify-center font-body-sm text-on-surface-variant">…</span>
            @else
                <a href="{{ $paginator->url($page) }}"
                    class="min-w-9 h-9 px-sm flex items-center justify-center rounded-md font-body-sm transition-colors
                    {{ $page === $current ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container' }}">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        @if ($current < $last)
            <a href="{{ $paginator->url($current + 1) }}"
                class="w-9 h-9 flex items-center justify-center rounded-md border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>
        @else
            <span class="w-9 h-9 flex items-center justify-center rounded-md border border-outline-variant text-on-surface-variant opacity-30 cursor-not-allowed">
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </span>
        @endif

    </div>
</div>
