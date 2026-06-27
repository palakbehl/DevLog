<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white border border-transparent rounded-lg font-bold text-xs uppercase tracking-wider shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out cursor-pointer']) }}>
    {{ $slot }}
</button>
