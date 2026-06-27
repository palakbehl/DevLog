@props([
    'name',
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'rows' => 5,
    'required' => false
])

<div class="space-y-1.5 w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'block w-full px-3.5 py-2.5 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg shadow-xs text-sm text-gray-900 dark:text-zinc-100 placeholder-gray-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 resize-y']) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-xs font-medium text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
