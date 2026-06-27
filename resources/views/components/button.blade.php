@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'submit'
])

@php
    $baseClasses = 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 active:scale-98 disabled:opacity-50 disabled:pointer-events-none';
    
    $variants = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm focus:ring-indigo-500',
        'secondary' => 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 shadow-xs focus:ring-indigo-500 dark:bg-zinc-900 dark:hover:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm focus:ring-emerald-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm focus:ring-red-500',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
