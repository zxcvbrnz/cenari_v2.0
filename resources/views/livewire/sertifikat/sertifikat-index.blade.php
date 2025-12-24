<main class="py-14 md:py-20">
    <div class="mb-6">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="p-4 flex justify-between items-center">
                <div class="text-slate-600">Tambah</div>
            </div>
            <hr>
            <div class="p-6">
                <form wire:submit="tambahSertifikat" class="grid lg:grid-cols-2 gap-4">
                    <div class="grid gap-4"
                        x-data="{ uploading: false, progress: 0 }"
                        x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false; progress = 0; $dispatch('reload-table-sertifikat')"
                        x-on:livewire-upload-error="uploading = false; progress = 0;"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div>
                            <x-input-label class="required" for="id_peserta" :value="__('Peserta Didik')" />
                            <select wire:model="id_peserta" name="id_peserta" id="id_peserta"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">Pilih Peserta
                                </option>
                                @foreach ($pesertas as $peserta)
                                    <option value="{{ $peserta->peserta->id }}">
                                        {{ $peserta->peserta->user->name }} ~ 
                                        @if ($peserta->peserta->id_group)
                                            {{ $peserta->peserta->group->nama }} ~ {{ $peserta->peserta->group->mapel->nama }}
                                        @else
                                            {{ $peserta->peserta->mapel->nama }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('id_peserta')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="nomor_sertifikat" :value="__('Nomor Sertifikat')" />
                            <x-text-input wire:model="nomor_sertifikat" id="nomor_sertifikat" name="nomor_sertifikat"
                                type="text" class="mt-1 block w-full" required autocomplete="nomor_sertifikat" />
                            <x-input-error class="mt-2" :messages="$errors->get('nomor_sertifikat')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="sertifikat" :value="__('Sertifikat')" />
                            <p class="text-xs text-slate-600">Max file size : 1MB</p>
                            <input
                                class="block w-full mb-2 text-xs text-gray-900 border border-gray-300 rounded-sm cursor-pointer bg-gray-50 focus:outline-none"
                                wire:model="sertifikat" id="sertifikat" name="sertifikat" type="file">
                            @if ($sertifikat)
                                <p class="text-sm text-slate-600">{{ $sertifikat->getClientOriginalName() }}</p>
                            @endif
                            <div class="w-full bg-gray-200 rounded-sm">
                                <div x-text="progress + '%'" class="rounded-sm text-center text-white" style="font-size: 10px; padding-top: 1px; padding-bottom: 1px; background:#7c3aed;" :style="{ width: progress + '%' }"></div>
                            </div>
                            <div x-show="uploading" class="text-slate-600">
                                <div class="text-sm">Uploading....</div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('sertifikat')" />
                        </div>
                        <div class="">
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <div class="p-4 flex justify-between items-center">
                <div class="text-xl text-slate-600">Data Sertifikat</div>
            </div>
            <hr>
            <div class="p-6">
                <table id="tableSertifikat" class="stripe hover text-sm text-left text-gray-500"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th data-priority="1" class="text-start">No</th>
                            <th data-priority="3" class="text-start">file</th>
                            <th data-priority="4" class="text-start">Peserta didik / Sertifikat</th>
                            <th data-priority="6" class="text-start">Nomor Serifikat</th>
                            <th data-priority="7" class="text-start">Tanggal diupload</th>
                            <th data-priority="8" class="text-start">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesertaSertifikats as $sertifikat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sertifikat->link }}</td>
                                <td>
                                    <div>{{ $sertifikat->peserta->user->name . ' /' }}</div>
                                    <div class="text-xs font-bold">{{ $sertifikat->peserta->id_group ? $sertifikat->peserta->group->nama . ' ~ ' . $sertifikat->peserta->group->mapel->nama : $sertifikat->peserta->mapel->nama }}</div>
                                </td>
                                <td>{{ $sertifikat->nomor_sertifikat }}</td>
                                <td>{{ $sertifikat->updated_at->format('d F Y') }}</td>
                                <td class="flex space-x-1">
                                    <button onclick="hapusSertifikatJs({{ $sertifikat->id }})"
                                        class="px-3 py-1 rounded text-red-600 text-xs border border-red-600 hover:bg-red-800 hover:text-white transition duration-300 ease-linear">Hapus</button>
                                    <a href="{{ $sertifikat->link ? asset('storage/sertifikat/' . $sertifikat->link) : '#' }}"
                                        {{ $sertifikat->link ? 'download' : '' }}
                                        class="px-3 py-1 rounded text-teal-600 text-xs border border-teal-600 hover:bg-teal-800 hover:text-white transition duration-300 ease-linear">
                                        Unduh
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
    function hapusSertifikatJs(id) {
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Kamu akan menghapus sertifikat ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya , Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('hapusSertifikat', id);
            }
        });
    }
</script>
