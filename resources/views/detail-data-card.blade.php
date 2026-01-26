<x-app-layout>
    <main class="py-14 md:py-20 md:px-6">
        <livewire:detail-data-card :status="request()->query('status')" />
    </main>
</x-app-layout>
