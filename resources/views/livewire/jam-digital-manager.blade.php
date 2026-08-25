<main class="py-14 md:py-20">
    <div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow-md border border-gray-100 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pengaturan Jam Digital ESP8266</h2>

        {{-- ALERT SUCCESS --}}
        @if (session()->has('message'))
            <div wire:key="alert-{{ microtime() }}" x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-center justify-between p-3.5 mb-4 text-sm text-green-800 bg-green-50 border border-green-200 rounded-lg shadow-sm">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-green-600 fill-current shrink-0" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 8 0 100-16 8 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
                <button type="button" @click="show = false"
                    class="text-green-600 hover:text-green-800 font-bold text-lg leading-none ml-2">&times;</button>
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-5">

            <!-- SECTION 1: HARDWARE & CONTROL POWER -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-3">
                <h3 class="text-sm font-semibold text-gray-700">Power & Operasional Panel</h3>

                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" wire:model="matrixPower"
                        class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                    <span class="text-sm text-gray-700 font-medium">Power Matrix Panel (ON / OFF)</span>
                </label>
            </div>

            <!-- SECTION 2: MODE TAMPILAN AKTIF -->
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
                        <span class="text-sm text-gray-700 font-medium">Tampilkan Animasi Jeda</span>
                    </label>

                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" wire:model="enableInfo"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 font-medium">Tampilkan Static Info (Web & Kontak)</span>
                    </label>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Animasi Full Screen</label>
                    <select wire:model="animType"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">1. Matrix Rain</option>
                        <option value="2">2. Wave & Scanner</option>
                        <option value="3">3. Sparkles & Strobe</option>
                        <option value="4">4. Laser Sweep Pass</option>
                        <option value="5">5. Digital Heartbeat Pulse</option>
                        <option value="6">6. Bouncing Balls Physics</option>
                        <option value="7">7. Starfield Warp 3D</option>
                        <option value="8">8. Spiral Curtain In/Out</option>
                        <option value="9">9. Center Ripple Effect</option>
                        <option value="10">10. Checkerboard Blend</option>
                    </select>
                    @error('animType')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- SECTION 3: JADWAL OPERASIONAL (SCHEDULE ARRAY) -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4">
                <h3 class="text-sm font-semibold text-gray-700">Jadwal Operasional Automatic Standby</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Nyala / Mulai</label>
                        <input type="time" wire:model="onTime"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('onTime')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mati / Standby</label>
                        <input type="time" wire:model="offTime"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('offTime')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" wire:model="enableSchedule"
                            class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm text-gray-700 font-medium">Aktifkan Auto Sleep/Standby Berdasarkan
                            Jadwal</span>
                    </label>
                </div>
            </div>

            <!-- SECTION 4: TEKS RUNNING & LAYAR JAM -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4">
                <h3 class="text-sm font-semibold text-gray-700">Teks Running & Layar Jam</h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Running</label>
                    <input type="text" wire:model="running_text"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('running_text')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Baris Bawah Jam (Maks. 15
                        Karakter)</label>
                    <input type="text" wire:model="sub_text" maxlength="15"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('sub_text')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Font Jam</label>
                        <select wire:model="clockSize"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1">Normal (5x7 + Subtext)</option>
                            <option value="2">Besar (Full Height)</option>
                        </select>
                        @error('clockSize')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran Teks Running</label>
                        <select wire:model="size"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1">Normal (1 Baris)</option>
                            <option value="2">Besar (2 Baris)</option>
                        </select>
                        @error('size')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecepatan Jalan (ms)</label>
                        <input type="number" wire:model="speed" min="10" max="150"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('speed')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- SECTION 5: KONFIGURASI STATIC INFO (WEB & KONTAK) -->
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 space-y-4">
                <h3 class="text-sm font-semibold text-gray-700">Informasi Static (Web & Kontak)</h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Website Info (`web_url`)</label>
                    <input type="text" wire:model="web_url" placeholder="cenari.sch.id"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('web_url')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kontak / WhatsApp Info
                        (`contact_info`)</label>
                    <input type="text" wire:model="contact_info" placeholder="081234567890"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contact_info')
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
