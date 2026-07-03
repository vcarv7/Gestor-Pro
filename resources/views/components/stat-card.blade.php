@props(['label' => '', 'value' => 0, 'icon' => null, 'iconBg' => 'primary'])

@php
    $iconBgs = [
        'primary' => 'bg-primary-container',
        'secondary' => 'bg-secondary-container',
        'neutral' => 'bg-surface-container-high',
    ];
    $bg = $iconBgs[$iconBg] ?? $iconBgs['primary'];
@endphp

<div class="login-card rounded-xl p-lg flex items-start justify-between gap-md">
    <div class="min-w-0">
        <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider truncate">{{ $label }}</p>
        <p class="font-display-lg text-display-lg text-on-surface leading-none mt-md">{{ $value }}</p>
    </div>
    @if ($icon)
        <div class="w-14 h-14 shrink-0 rounded-xl {{ $bg }} flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-[28px]">{{ $icon }}</span>
        </div>
    @endif
</div>
