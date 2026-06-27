@props([
    'title',
    'value',
    'icon' => null
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-800 rounded-xl shadow-xs p-6 flex items-center justify-between transition-all duration-300 hover:shadow-md hover:border-gray-300 dark:hover:border-zinc-700']) }}>
    <div>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-zinc-500">
            {{ $title }}
        </p>
        <p class="text-3xl font-extrabold text-gray-900 mt-2 dark:text-zinc-50 tracking-tight">
            {{ $value }}
        </p>
    </div>
    @if($icon)
        <div class="p-3.5 bg-indigo-50 dark:bg-indigo-950/40 rounded-xl text-indigo-600 dark:text-indigo-400">
            {!! $icon !!}
        </div>
    @endif
</div>
