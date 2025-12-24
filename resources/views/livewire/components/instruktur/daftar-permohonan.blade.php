<div class="grid lg:grid-cols-5 gap-8">
    <div class="py-4 lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                <path
                    d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                </path>
            </svg>
            <span>Buat Pemohonan</span>
        </div>
        <hr>
        <div class="px-4 md:px-6 py-6">
            <form x-data="{ inputType: 'private' }" wire:submit="create_permohonan">
                <div class="flex space-x-6">
                    <div class="flex items-center">
                        <input type="radio" id="private" name="jenis" value="private" x-model="inputType"
                            @click="inputType = 'private'">
                        <x-input-label class="ms-1" for="private" :value="__('Private')" />
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="pelatihan" name="jenis" value="pelatihan" x-model="inputType"
                            @click="inputType = 'pelatihan'">
                        <x-input-label class="ms-1" for="pelatihan" :value="__('Pelatihan')" />
                    </div>
                </div>

                <!-- Input for Nama Peserta -->
                <div id="namaPesertaInput" x-show="inputType === 'private'" class="mt-4">
                    <x-input-label for="namaPeserta" :value="__('Nama Peserta')" />
                    <select name="id_peserta" id="id_peserta" wire:model="id_peserta"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                        required>
                        <option selected>Pilih Peserta
                        </option>
                        @foreach ($peserta as $item)
                            <option value="{{ $item->id }}">{{ $item->user->name }} ~ {{ $item->mapel->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input for Nama Group -->
                <div id="namaGroupInput" x-show="inputType === 'pelatihan'" class="mt-4">
                    <x-input-label for="namaGroup" :value="__('Nama Group')" />
                    <select name="id_group" id="id_group" wire:model="id_group"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                        required>
                        <option selected>Pilih Pelatihan
                        </option>
                        @foreach ($pelatihan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} ~ {{ $item->mapel->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <x-input-label class="required" for="keterangan" :value="__('Keterangan')" />
                    <x-text-input id="keterangan" wire:model="keterangan" name="keterangan" type="text" placeholder="Pertemuan ke- , Bertempat di-"
                        class="mt-1 block w-full" required />
                </div>
                <div class="mt-4">
                    <x-input-label class="required" for="tanggal" :value="__('Tanggal/Waktu')" />
                    <x-text-input id="tanggal" wire:model="waktu_mulai" name="tanggal" type="datetime-local"
                        class="mt-1 block w-full" required />
                </div>
                <div class="flex items-center mt-6">
                    <x-primary-button>{{ __('Submit') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <div class="grid gap-8 lg:col-span-3">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="flex items-center space-x-2 py-4 px-4 sm:px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                    </path>
                </svg>
                <span>Daftar Pemohonan Private</span>
            </div>
            <hr>
            <div class="grid py-4 h-48">
                <div class="px-6 lg:px-10 overflow-y-auto">
                    @if ($permohonanPrivate->count() > 0)
                        <ul class="list-disc">
                            @foreach ($permohonanPrivate as $dat)
                                <li class="text-sm">
                                    <span class="text-orange-600 font-bold">Pending</span> Jadwal
                                    <span class="font-bold text-slate-800"><span class="text-teal-600">Private</span>
                                        {{ $dat->nama_peserta }}</span>
                                    pada
                                    <span
                                        class="font-bold text-violet-600">{{ $dat->waktu_mulai->format('d M Y H:i') }}</span>
                                    ~ {{ $dat->keterangan }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex justify-center py-6 px-4 text-slate-600"><span>Kamu tidak memiliki permohonan
                                kursus private</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="flex items-center space-x-2 py-4 px-4 sm:px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                    </path>
                </svg>
                <span>Daftar Pemohonan Pelatihan</span>
            </div>
            <hr>
            <div class="grid py-4 h-48">
                <div class="px-6 lg:px-10 overflow-y-auto">
                    @if ($permohonanGroup->count() > 0)
                        <ul class="list-disc">
                            @foreach ($permohonanGroup as $dat)
                                <li class="text-sm">
                                    <span class="text-orange-600 font-bold">Pending</span> Jadwal
                                    <span class="font-bold text-slate-800"><span class="text-sky-600">Pelatihan</span>
                                        {{ $dat->nama_group }}</span>
                                    pada
                                    <span
                                        class="font-bold text-violet-600">{{ $dat->waktu_mulai->format('d M Y H:i') }}</span>
                                    ~ {{ $dat->keterangan }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex justify-center py-6 px-4 text-slate-600"><span>Kamu tidak memiliki permohonan
                                pelatihan</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="lg:col-span-5">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="flex items-center space-x-2 py-4 px-4 sm:px-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                    </path>
                </svg>
                <span>Daftar Pemohonan Ditolak</span>
            </div>
            <hr>
            <div class="grid py-4 h-60">
                <div class="px-6 lg:px-10 overflow-y-auto">
                    @if ($permohonanDitolak->count() > 0)
                        <ul class="list-disc">
                            @foreach ($permohonanDitolak as $dat)
                                <li class="text-sm">
                                    <span class="text-red-600 font-bold">Ditolak</span> Jadwal
                                    <span class="font-bold text-slate-800"><span class="text-teal-600">Private</span>
                                        {{ $dat->nama_peserta }}</span>
                                    pada
                                    <span
                                        class="font-bold text-violet-600">{{ $dat->waktu_mulai->format('d M Y H:i') }}</span>
                                    ~ {{ $dat->keterangan }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex justify-center py-6 px-4 text-slate-600"><span>Kamu tidak memiliki permohonan
                                ditolak</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
