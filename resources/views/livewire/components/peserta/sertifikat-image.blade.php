<div class="p-6 bg-white rounded-lg shadow-md" x-data="{ isUploading: false }">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Pengaturan Foto Sertifikat</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6"
        x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false">

        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">Upload Foto Peserta</label>

            <div
                class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center min-h-[250px] relative">

                <div x-show="isUploading" x-cloak
                    class="absolute inset-0 bg-white/80 flex flex-col items-center justify-center z-10 rounded-lg">
                    <svg class="animate-spin h-8 w-8 text-blue-600 mb-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-xs text-gray-500 font-medium">Mengunggah gambar...</span>
                </div>

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="max-h-56 object-contain rounded-md shadow-sm">
                @elseif ($existingImage)
                    <img src="{{ asset('storage/' . $existingImage) }}"
                        class="max-h-56 object-contain rounded-md shadow-sm">
                    <span class="text-xs text-gray-400 mt-2">Gambar saat ini</span>
                @else
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                        viewBox="0 0 48 48" aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="text-xs text-gray-500 mt-2">Belum ada foto yang dipilih</p>
                @endif
            </div>

            <div>
                <input type="file" wire:model="image" id="image-input" class="hidden" accept="image/*">
                <label for="image-input"
                    class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md border border-gray-300 shadow-sm transition">
                    Pilih File Foto
                </label>
                @error('image')
                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="save" {{ !$image ? 'disabled' : '' }}
                class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed">

                <span wire:loading.remove wire:target="save">Simpan Foto</span>

                <span wire:loading wire:target="save" class="inline-flex items-center justify-center gap-2" x-cloak>
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Menyimpan...</span>
                </span>
            </button>
        </div>

        <div
            class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col items-center justify-center text-center">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Contoh Komposisi Foto</span>

            <div
                class="w-40 h-52 bg-gradient-to-b from-blue-100 to-blue-200 rounded-md shadow-inner flex items-end justify-center overflow-hidden border border-blue-300 relative">
                <div class="absolute inset-0 bg-red-600 opacity-80"></div>

                <svg class="w-32 h-32 text-slate-800 z-10 drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M12 14c-4.42 0-8 3.58-8 8v1h16v-1c0-4.42-3.58-8-8-8z" />
                    <path d="M12 14l2 3-2 3-2-3z" fill="#ffffff" />
                </svg>
            </div>

            <div class="mt-4 max-w-xs">
                <p class="text-sm font-medium text-gray-700">Ketentuan Foto:</p>
                <ul class="text-xs text-gray-500 text-left list-disc list-inside mt-1 space-y-1">
                    <li>Posisi badan tegap menghadap depan</li>
                    <li>Menggunakan pakaian formal/rapi</li>
                    <li>Latar belakang berwarna polos (Rekomendasi Merah/Biru)</li>
                    <li>Ukuran file maksimal 2 MB</li>
                </ul>
            </div>
        </div>

    </form>
</div>
