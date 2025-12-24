<main class="py-14 md:py-20">
    <div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="flex justify-between items-center text-slate-700 p-4">
            <span>Detail {{ $instruktur->id }}</span>
            <div class="flex items-center space-x-4">
                <button wire:click="resetPassword" class="flex items-center hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M224,128a96,96,0,0,1-94.71,96H128A95.38,95.38,0,0,1,62.1,197.8a8,8,0,0,1,11-11.63A80,80,0,1,0,71.43,71.39a3.07,3.07,0,0,1-.26.25L44.59,96H72a8,8,0,0,1,0,16H24a8,8,0,0,1-8-8V56a8,8,0,0,1,16,0V85.8L60.25,60A96,96,0,0,1,224,128Z">
                        </path>
                    </svg>
                    <span class="text-xs ms-1">Reset password</span>
                </button>
                <div class="w-10 h-10" x-data="{ images: '{{ $instruktur->user->image ? asset('storage/image/' . $instruktur->user->image) : asset('image/default.png') }}', showModal: false }">
                    <img class="w-full h-full rounded-full object-cover cursor-pointer" :src="images"
                        alt="profile" @click="showModal = true" />

                    <!-- Fullscreen Modal -->
                    <div x-show="showModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50"
                        @click="showModal = false">

                        <div class="relative">
                            <img :src="images" class="w-60 h-60 rounded-full" alt="profile" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="p-4">
            <form wire:submit="update">
                <div class="p-4 grid lg:grid-cols-2 gap-4">
                    <div class="grid gap-4">
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input type="text" name="name" id="name" wire:model="name"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input type="number" name="nik" id="nik" wire:model="data_instruktur.nik"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                        </div>
                        <div>
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input type="text" name="alamat" id="alamat"
                                wire:model="data_instruktur.alamat" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                        </div>
                        <div>
                            <x-input-label for="kota" :value="__('Kota Domisili')" />
                            <x-text-input type="text" name="kota" id="kota" wire:model="data_instruktur.kota"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('kota')" />
                        </div>
                        <div>
                            <x-input-label for="provinsi" :value="__('Provinsi')" />
                            <x-text-input type="text" name="provinsi" id="provinsi"
                                wire:model="data_instruktur.provinsi" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('provinsi')" />
                        </div>
                        <div>
                            <x-input-label for="nomor_telepon" :value="__('Whatsapp')" />
                            <x-text-input type="number" name="nomor_telepon" id="nomor_telepon"
                                wire:model="data_instruktur.nomor_telepon" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input type="email" name="email" id="email"
                                wire:model="data_instruktur.email" class="mt-1 block w-full"
                                placeholder='example@email.com' />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label for="ttl" :value="__('Tempat, Tanggal Lahir')" />
                            <x-text-input type="text" name="ttl" id="ttl" wire:model="data_instruktur.ttl"
                                class="mt-1 block w-full" placeholder='Banjarmasin, 04 April 2000' />
                            <x-input-error class="mt-2" :messages="$errors->get('ttl')" />
                        </div>
                    </div>
                    <div>
                        <div class="grid gap-4">
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    wire:model="data_instruktur.jenis_kelamin"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Jenis Kelamin
                                    </option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                            </div>
                            <div>
                                <x-input-label for="pendidikan" :value="__('Pendidikan Terakhir')" />
                                <select name="pendidikan" id="pendidikan" wire:model="data_instruktur.pendidikan"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="DIPLOMAT I-IV">DIPLOMAT I-IV</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('pendidikan')" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_menjadi" :value="__('Tanggal Menjadi Pendidik')" />
                                <x-text-input type="date" name="tanggal_menjadi" id="tanggal_menjadi"
                                    wire:model="data_instruktur.tanggal_menjadi" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_menjadi')" />
                            </div>
                            <div>
                                <x-input-label for="NUPWK" :value="__('NUPWK')" />
                                <x-text-input type="number" name="NUPWK" id="NUPWK"
                                    wire:model="data_instruktur.NUPWK" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('NUPWK')" />
                            </div>
                            <div>
                                <x-input-label for="rekening" :value="__('Nomor Rekening')" />
                                <x-text-input type="text" name="rekening" id="rekening"
                                    wire:model="data_instruktur.rekening" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('rekening')" />
                            </div>
                            <div>
                                <x-input-label for="status" :value="__('Status Keluarga')" />
                                <select name="status" id="status" wire:model="data_instruktur.status"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                            <div>
                                <x-input-label for="status_kerja" :value="__('Status Kerja')" />
                                <select name="status_kerja" id="status_kerja"
                                    wire:model="data_instruktur.status_kerja"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Tidak Tetap">Tidak Tetap</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status_kerja')" />
                            </div>
                            <div>
                                <x-input-label for="pekerjaan" :value="__('Pekerjaan Lainnya')" />
                                <select name="pekerjaan" id="pekerjaan" wire:model="data_instruktur.pekerjaan"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Guru Swasta">Guru Swasta</option>
                                    <option value="Dosen">Dosen</option>
                                    <option value="Wirausahawan">Wirausahawan</option>
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="PNS/TNI/Polri">PNS/TNI/Polri</option>
                                    <option value="Profesional Suatu Bidang">Profesional Suatu Bidang</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('pekerjaan')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Program
        </div>
        <hr>
        <form wire:submit="updateMapels">
            <div class="p-4 grid lg:grid-cols-2 gap-4">
                @foreach ($mapels as $mapel)
                    <div class="flex items-center">
                        <input type="checkbox" id="{{ $mapel->id }}" value="{{ $mapel->id }}"
                            wire:model="selectedMapels" />
                        <x-input-label class="ms-1" for="{{ $mapel->id }}" value="{{ $mapel->nama }}" />
                    </div>
                @endforeach
            </div>
            <div class="p-4">
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            </div>
        </form>
    </div>
    <div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="p-4 flex justify-between items-center">
            <div class="text-xl text-slate-600">Peserta Didik</div>
        </div>
        <hr>
        <div class="p-6">
            <table class="dat-table stripe hover text-sm text-left text-gray-500"
                style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th class="text-start">No</th>
                        <th class="text-start">Peserta didik</th>
                        <th class="text-start">Program</th>
                        <th class="text-start">Whatsapp</th>
                        <th class="text-start">Nilai</th>
                        <th class="text-start">Sertifikat</th>
                        <th class="text-start">status</th>
                        <th class="text-start">honor Instruktur</th>
                        <th class="text-start">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesertadik as $dat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="flex items-center space-x-2">
                                <img class="w-10 h-10 rounded-full object-cover cursor-pointer"
                                    src="{{ $dat->user->image ? asset('storage/image/' . $dat->user->image) : asset('image/default.png') }}"
                                    alt="profile" />
                                <span>{{ $dat->user->name }}</span>
                            </td>
                            <td>{{ $dat->mapel->nama }}</td>
                            <td>
                                <a target="_blank"
                                    href="{{ 'https://wa.me/' . $dat->nomor_telepon . '?text=' . urlencode('Hallo ' . $dat->user->name) }}"
                                    class="text-blue-800 hover:text-blue-600 underline font-thin">{{ $dat->nomor_telepon }}</a>
                            </td>
                            <td>
                                @if ($dat->nilai)
                                    <span class="text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                            </path>
                                        </svg>
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($dat->sertifikat->link)
                                        <span class="text-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                                viewBox="0 0 256 256">
                                                <path
                                                    d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                                </path>
                                            </svg>
                                        </span>
                                    @endif
                                </td>
                            <td>
                                @if ($dat->status === 'aktif')
                                    <span
                                        class="text-green-800 bg-green-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status }}</span>
                                @else
                                    <span
                                        class="text-red-800 bg-red-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($dat->honor_instruktur)
                                    <span class="text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                            viewBox="0 0 256 256">
                                            <path
                                                d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                            </path>
                                        </svg>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.data.peserta.detail', ['id' => $dat->id]) }}" wire:navigate
                                    class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-4 bg-white border border-slate-200 shadow-lg rounded-sm">
        <section class="space-y-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Hapus Instruktur') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Instruktur akan terhapus dan seluruh data dan seluruh absensi akan ikut terhapus.') }}
                </p>
            </header>

            <x-danger-button onclick="hapusInstrukturJs()">{{ __('Hapus Instruktur') }}</x-danger-button>
        </section>
    </div>
</main>
 @script
        <script>
            $(document).ready(function() {
                var table = $('.dat-table').DataTable({
                        responsive: true
                    })
                    .columns.adjust()
                    .responsive.recalc();
            });
        </script>
    @endscript
<script>
    function hapusInstrukturJs() {
        Swal.fire({
            title: 'Apakah Kamu yakin?',
            text: "Kamu akan menghapus instruktur ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`hapusInstruktur`);
            }
        });
    }
</script>
