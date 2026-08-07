<main class="py-14 md:py-20">
    <div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow-md border border-gray-100 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pengaturan Jam Digital ESP8266</h2>

        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms
                class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-5">

            <!-- SECTION 1: MODE TAMPILAN AKTIF -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Mode Tampilan Aktif</h3>

                <div class="space-y-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" wire:model="enableClock"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 font-medium">Tampilkan Jam Digital</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" wire:model="enableText"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 font-medium">Tampilkan Running Text</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" wire:model="enableAnim"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 font-medium">Tampilkan Animasi CENARI</span>
                    </label>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Animasi</label>
                    <select wire:model="animType"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Detak Jantung (Heartbeat)</option>
                        <option value="2">Radar / Sonar Scan</option>
                        <option value="3">Equalizer Bar</option>
                    </select>
                    @error('animType')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- SECTION 2: TEKS & KONFIGURASI DISPLAY -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Running</label>
                <input type="text" wire:model="runningText"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('runningText')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teks Baris Bawah (Maks. 15 Karakter)</label>
                <input type="text" wire:model="subText" maxlength="15"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('subText')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecepatan Jalan (ms)</label>
                    <input type="number" wire:model="speed" min="10" max="150"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('speed')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Teks</label>
                    <select wire:model="size"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Normal (1 Baris)</option>
                        <option value="2">Besar (2 Baris)</option>
                    </select>
                    @error('size')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-md transition duration-200">
                Simpan Pengaturan
            </button>
        </form>
    </div>
</main>
