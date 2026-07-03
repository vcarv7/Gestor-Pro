@props([
    'variant' => 'neutral',
    'size' => 'sm',
])

@php
    $variants = [
        'success'  => 'bg-secondary-container text-on-secondary-container',
        'warning'  => 'bg-yellow-100 text-yellow-900',
        'danger'   => 'bg-error-container text-on-error-container',
        'info'     => 'bg-primary-container text-on-primary-container',
        'neutral'  => 'bg-surface-container-high text-on-surface-variant',
        'primary'  => 'bg-primary text-on-primary',
    ];
    $sizes = [
        'sm' => 'px-sm py-xs text-label-sm',
        'md' => 'px-md py-xs text-label-md',
    ];
    $classes = ($variants[$variant] ?? $variants['neutral']) . ' ' . ($sizes[$size] ?? $sizes['sm']);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-xs rounded-lg font-label-md {$classes}"]) }}>
    {{ $slot }}
</span>
