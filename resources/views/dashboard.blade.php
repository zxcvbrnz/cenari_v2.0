@php
    $role = Auth::user()->role;
@endphp
<x-app-layout>
    <main class="py-14 md:py-20 md:px-6 grid grid-cols-1 gap-8">
        @if ($role == 'instruktur')
            <livewire:components.instruktur.data-card />
            <livewire:components.instruktur.chart />
        @endif
        @if ($role == 'peserta')
            <livewire:components.peserta.data-card />
            <livewire:components.peserta.chart />
        @endif
        @if ($role == 'admin')
            <livewire:components.admin.data-card />
            <livewire:components.admin.chart />
            <livewire:components.admin.chart-2 />
        @endif
    </main>
</x-app-layout>
