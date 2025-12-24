<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Edit Materi Pembelajaran
    </div>
    <hr />
    <form wire:submit="update">
        <div class="p-4 grid lg:grid-cols-2 gap-4"
            x-data="{ uploading: false, progress: 0 }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false; progress = 0;"
            x-on:livewire-upload-error="uploading = false; progress = 0;"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="id_mapel" :value="__('Program')" />
                    <select name="id_mapel" id="id_mapel" wire:model="id_mapel"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                        <option value="">Pilih Program
                        </option>
                        @foreach ($mapels as $mapel)
                            @if (auth()->user()->role === 'admin')
                                <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                            @else
                                <option value="{{ $mapel->mapel->id }}">{{ $mapel->mapel->nama }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('id_mapel')" />
                </div>
                <div>
                    <x-input-label class="required" for="judul" :value="__('Judul')" />
                    <x-text-input wire:model="judul" id="judul" name="judul" type="text"
                        class="mt-1 block w-full" required autofocus autocomplete="judul" />
                    <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                </div>
                <div>
                    <x-input-label class="required" for="deskripsi" :value="__('Deskripsi')" />
                    <x-text-input wire:model="deskripsi" id="deskripsi" name="deskripsi" type="text"
                        class="mt-1 block w-full" required autofocus autocomplete="deskripsi" />
                    <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                </div>
                <div>
                    <x-input-label for="link" :value="__('Link Youtube (Opsional)')" />
                    <div class="flex items-center">
                        <div class="text-sm text-slate-600 font-bold" style="text-wrap: nowrap;">https://www.youtube.com/watch?v=</div>
                        <x-text-input wire:model="link" id="link" name="link" type="text"
                            class="mt-1 block w-full" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('link')" />
                </div>
                <div>
                    <x-input-label for="file" :value="__('File (Opsional) ~ ' . ($file ? $file->getClientOriginalName() : $fileOld))" />
                    <p class="text-xs text-slate-600 mt-5">Max file size : 10MB</p>
                    <input
                        class="block w-full text-xs mb-2 text-gray-900 border border-gray-300 rounded-sm cursor-pointer bg-gray-50 focus:outline-none"
                        wire:model="file" id="file" name="file" type="file">
                        <div class="w-full bg-gray-200 rounded-sm">
                          <div x-text="progress + '%'" class="rounded-sm text-center text-white" style="font-size: 10px; padding-top: 1px; padding-bottom: 1px; background:#7c3aed;" :style="{ width: progress + '%' }"></div>
                        </div>
                    <div x-show="uploading" class="text-slate-600">
                        <div class="text-sm">Uploading....</div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('file')" />
                </div>
            </div>
            <div>
                <div>
                    <x-input-label class="required" for="artikel" :value="__('Artikel')" />
                    <textarea name="" id="" rows="15" required wire:model="artikel"
                        class="w-full mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm"></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('artikel')" />
                </div>
            </div>
        </div>
        <div class="p-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
        </div>
    </form>
</div>
