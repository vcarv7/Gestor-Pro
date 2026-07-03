@props([
    'name' => 'U',
    'size' => 'md',
    'color' => 'primary',
])

@php
    $parts = explode(' ', trim($name));
    $initials = strtoupper(mb_substr($parts[0] ?? 'U', 0, 1));
    if (count($parts) > 1) {
        $initials .= strtoupper(mb_substr($parts[count($parts) - 1], 0, 1));
    }

    $sizes = [
        'xs' => 'w-6 h-6 text-[10px]',
        'sm' => 'w-8 h-8 text-label-sm',
        'md' => 'w-10 h-10 text-label-md',
        'lg' => 'w-12 h-12 text-label-lg',
    ];
    $colors = [
        'primary' => 'bg-primary text-on-primary',
        'secondary' => 'bg-secondary-container text-on-secondary-container',
        'neutral' => 'bg-surface-container-high text-on-surface-variant',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $colorClass = $colors[$color] ?? $colors['primary'];
@endphp

<div {{ $attributes->merge(['class' => "shrink-0 rounded-full flex items-center justify-center font-label-md {$sizeClass} {$colorClass}"]) }}>
    {{ $initials ?: 'U' }}
</div>
