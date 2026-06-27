<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-white hover:bg-gray-50 dark:bg-zinc-900 dark:hover:bg-zinc-800 text-gray-700 dark:text-zinc-300 border border-gray-300 dark:border-zinc-700 rounded-lg font-bold text-xs uppercase tracking-wider shadow-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out cursor-pointer']) }}>
    {{ $slot }}
</button>
