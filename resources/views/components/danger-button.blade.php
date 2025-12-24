<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-red-300 border border-transparent rounded-md font-semibold text-xs text-red-800 uppercase tracking-widest hover:bg-red-700 hover:text-red-300 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
