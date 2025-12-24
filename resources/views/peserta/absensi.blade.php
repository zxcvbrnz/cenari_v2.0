<x-app-layout>
    <main class="py-14 md:py-20 md:px-6 grid lg:grid-cols-3 gap-8">
        @if (auth()->user()->peserta->status === 'aktif')
            <div class="py-4 bg-white border border-slate-200 shadow-lg rounded-sm">
                <livewire:components.peserta.scan />
            </div>
        @endif
        <div class="py-4 lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm min-h-80">
            <livewire:components.peserta.riwayat-absensi />
        </div>
    </main>
</x-app-layout>
