    <main class="py-14 md:py-20 ">
        <div class="max-w-xl mx-auto p-6 bg-white rounded-xl shadow-md border border-gray-100 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Pengaturan Jam Digital ESP8266</h2>

            @if (session()->has('message'))
                <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Running</label>
                    <input type="text" wire:model="runningText"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('runningText')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Teks Baris Bawah (Maks. 15
                        Karakter)</label>
                    <input type="text" wire:model="subText" maxlength="15"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('subText')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecepatan (ms)</label>
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
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                    Simpan Pengaturan
                </button>
            </form>
        </div>
    </main>
