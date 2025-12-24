@props(['disabled' => false, 'value' => ''])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm',
    'oninput' => 'this.style.height = ""; this.style.height = this.scrollHeight + "px"',
    'style' => 'overflow:hidden; min-height: 40px; resize: none;',
]) !!}>{{ $value }}</textarea>
