@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'block mt-6 text-xs text-slate-500 
        file:bg-red-200
        ',
    // file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-sky-100 file:text-violet-700 hover:file:bg-violet-100
]) !!}>
