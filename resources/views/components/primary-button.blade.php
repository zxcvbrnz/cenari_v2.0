@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-violet-300 border border-transparent rounded-md font-semibold text-xs text-violet-800 hover:text-violet-300 uppercase tracking-widest hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:text-violet-300 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
