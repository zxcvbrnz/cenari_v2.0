<div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="flex justify-between items-center text-slate-700 py-4 px-4">
        <div class="flex items-center space-x-4">
            <span>Detail</span>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('export.peserta.pdf', ['id' => $peserta->id]) }}"
                    class="space-x-2 inline-flex items-center px-4 py-2 bg-violet-300 border border-transparent rounded-md font-semibold text-xs text-violet-800 hover:text-violet-300 uppercase tracking-widest hover:bg-violet-700 focus:bg-violet-700 active:bg-violet-900 focus:text-violet-300 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M216,112v96a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V112A16,16,0,0,1,56,96H80a8,8,0,0,1,0,16H56v96H200V112H176a8,8,0,0,1,0-16h24A16,16,0,0,1,216,112ZM93.66,69.66,120,43.31V136a8,8,0,0,0,16,0V43.31l26.34,26.35a8,8,0,0,0,11.32-11.32l-40-40a8,8,0,0,0-11.32,0l-40,40A8,8,0,0,0,93.66,69.66Z">
                        </path>
                    </svg>
                    <span>PDF</span>
                </a>
            @endif
        </div>
        <div class="flex items-center space-x-4">
            @if ($role === 'admin')
                <button wire:click="resetPassword" class="flex items-center hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M224,128a96,96,0,0,1-94.71,96H128A95.38,95.38,0,0,1,62.1,197.8a8,8,0,0,1,11-11.63A80,80,0,1,0,71.43,71.39a3.07,3.07,0,0,1-.26.25L44.59,96H72a8,8,0,0,1,0,16H24a8,8,0,0,1-8-8V56a8,8,0,0,1,16,0V85.8L60.25,60A96,96,0,0,1,224,128Z">
                        </path>
                    </svg>
                    <span class="text-xs ms-1">Reset password</span>
                </button>
            @endif
            <div class="w-10 h-10" x-data="{ images: '{{ $peserta->user->image ? asset('storage/image/' . $peserta->user->image) : asset('image/default.png') }}', showModal: false }">
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
    <hr />
    @if ($role === 'admin')
        <form wire:submit="update">
            <div class="grid lg:grid-cols-2 gap-4 p-4">
                <div class="grid gap-4">
                    <div class="grid lg:grid-cols-2">
                        <div class="lg:flex lg:items-center">
                            <x-input-label for="name" :value="__('Nama')" />
                        </div>
                        <div>
                            <x-text-input type="text" wire:model="name" id="name" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.name')" />
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2">
                        <div class="lg:flex lg:items-center">
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                        </div>
                        <div>
                            <x-text-input type="text" wire:model="data_peserta.tempat_lahir" id="tempat_lahir"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.tempat_lahir')" />
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2">
                        <div class="lg:flex lg:items-center">
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                        </div>
                        <div>
                            <x-text-input type="date" wire:model="data_peserta.tanggal_lahir" id="tanggal_lahir"
                                class="mt-1 block w-full" />
                            <div class="mt-2 text-slate-400 text-xs">Usia : {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->age }} Tahun</div>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.tanggal_lahir')" />
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2">
                        <div class="lg:flex lg:items-center">
                            <x-input-label for="nama_ibu" :value="__('Nama Ibu Kandung')" />
                        </div>
                        <div>
                            <x-text-input type="text" wire:model="data_peserta.nama_ibu" id="nama_ibu"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.nama_ibu')" />
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2">
                        <div class="lg:flex lg:items-center">
                            <x-input-label for="nama_ayah" :value="__('Nama Ayah')" />
                        </div>
                        <div>
                            <x-text-input type="text" wire:model="data_peserta.nama_ayah" id="nama_ayah"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.nama_ayah')" />
                        </div>
                    </div>
                    <hr>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="nisn" :value="__('NISN')" />
                            <x-text-input type="number" wire:model="data_peserta.nisn" id="nisn"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.nisn')" />
                        </div>
                        <div>
                            <x-input-label for="nik" :value="__('NIK')" />
                            <x-text-input type="number" wire:model="data_peserta.nik" id="nik"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.nik')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                            <select wire:model="data_peserta.jenis_kelamin" id="jenis_kelamin"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                <option selected value="">Pilih Jenis Kelamin
                                </option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.jenis_kelamin')" />
                        </div>
                        <div>
                            <x-input-label for="agama" :value="__('Agama')" />
                            <select wire:model="data_peserta.agama" id="agama"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                <option selected value="">Pilih Agama
                                </option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Kong Hu Chu">Kong Hu Chu</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.agama')" />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="kewarganegaraan" :value="__('Kewarganegaraan')" />
                        <select wire:model="data_peserta.kewarganegaraan" id="kewarganegaraan"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                            <option selected value="">Pilih Kewarganegaraan
                            </option>
                            <option value="WNI">WNI</option>
                            <option value="WNA">WNA</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('data_peserta.kewarganegaraan')" />
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="penerima_kps" :value="__('Penerima KPS')" />
                            <select wire:model="data_peserta.penerima_kps" id="penerima_kps"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                <option selected value="">Pilihan
                                </option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.penerima_kps')" />
                        </div>
                        <div>
                            <x-input-label for="no_kps" :value="__('No KPS')" />
                            <x-text-input type="number" wire:model="data_peserta.no_kps" id="no_kps"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.no_kps')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="layak_pip" :value="__('Layak PIP')" />
                            <select wire:model="data_peserta.layak_pip" id="layak_pip"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                <option selected value="">Pilihan
                                </option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.layak_pip')" />
                        </div>
                        <div>
                            <x-input-label for="alasan_pip" :value="__('Alasan Layak PIP')" />
                            <select wire:model="data_peserta.alasan_pip" id="alasan_pip"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">Pilihan
                                </option>
                                <option value="Pemegang PKH/KPS/KKS/KIP">Pemegang PKH/KPS/KKS/KIP</option>
                                <option value="Penerima BSM 2014">Penerima BSM 2014</option>
                                <option value="Yatim Piatu/Panti Asuhan/Panti Sosial">Yatim Piatu/Panti
                                    Asuhan/Panti
                                    Sosial</option>
                                <option value="Dampak Bencana Alam">Dampak Bencana Alam</option>
                                <option value="Pernah Drop Out">Pernah Drop Out</option>
                                <option value="Siswa Miskin/Rentan Miskin">Siswa Miskin/Rentan Miskin</option>
                                <option value="Daerah Konflik">Daerah Konflik</option>
                                <option value="Keluarga Terpidana / Berada di LAPAS">Keluarga Terpidana / Berada di
                                    LAPAS</option>
                                <option value="Kelainan Fisik">Kelainan Fisik</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.alasan_pip')" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <x-input-label for="penerima_kip" :value="__('Penerima KIP')" />
                            <select wire:model="data_peserta.penerima_kip" id="penerima_kip"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                <option selected value="">Pilihan
                                </option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.penerima_kip')" />
                        </div>
                        <div>
                            <x-input-label for="no_kip" :value="__('No KIP')" />
                            <x-text-input type="number" wire:model="data_peserta.no_kip" id="no_kip"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.no_kip')" />
                        </div>
                    </div>
                </div>
                <div>
                    <div class="border p-4 grid gap-4">
                        <div>
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input type="text" wire:model="data_peserta.alamat" id="alamat"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.alamat')" />
                        </div>
                        <div class="grid grid-cols-3 gap-8">
                            <div>
                                <x-input-label for="rt" :value="__('RT')" />
                                <x-text-input type="number" wire:model="data_peserta.rt" id="rt"
                                    class="mt-1 block w-full" value="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.rt')" />
                            </div>
                            <div>
                                <x-input-label for="rw" :value="__('RW')" />
                                <x-text-input type="number" wire:model="data_peserta.rw" id="rw"
                                    class="mt-1 block w-full" value="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.rw')" />
                            </div>
                            <div>
                                <x-input-label for="kode_pos" :value="__('Kode POS')" />
                                <x-text-input type="number" wire:model="data_peserta.kode_pos" id="kode_pos"
                                    class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.kode_pos')" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="nama_desa_kelurahan" :value="__('Nama Desa/Kelurahan')" />
                            <x-text-input type="text" wire:model="data_peserta.nama_desa_kelurahan"
                                id="nama_desa_kelurahan" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.nama_desa_kelurahan')" />
                        </div>
                        <div>
                            <x-input-label for="provinsi" :value="__('Provinsi')" />
                            <select id="provinsi"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">Pilih Provinsi
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.provinsi')" />
                        </div>
                        <div>
                            <x-input-label for="kab_kota" :value="__('Kab/Kota')" />
                            <select id="kab_kota"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">{{ $peserta->kab_kota }}
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.kab_kota')" />
                        </div>
                        <div>
                            <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                            <select id="kecamatan"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">{{ $peserta->kecamatan }}
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.kecamatan')" />
                        </div>
                        <div>
                            <x-input-label for="kelurahan" :value="__('Kelurahan')" />
                            <select id="kelurahan"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">{{ $peserta->kelurahan }}
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.kelurahan')" />
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <x-input-label for="jenis_tinggal" :value="__('Jenis Tinggal')" />
                                <select wire:model="data_peserta.jenis_tinggal" id="jenis_tinggal"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Jenis Tinggal
                                    </option>
                                    <option value="Asrama">Asrama</option>
                                    <option value="Bersama orang tua">Bersama orang tua</option>
                                    <option value="Kost">Kost</option>
                                    <option value="Lainnya">Lainnya</option>
                                    <option value="Panti asuhan">Panti asuhan</option>
                                    <option value="Pesantren">Pesantren</option>
                                    <option value="Wali">Wali</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.jenis_tinggal')" />
                            </div>
                            <div>
                                <x-input-label for="alat_transportasi" :value="__('Alat Transportasi')" />
                                <select wire:model="data_peserta.alat_transportasi" id="alat_transportasi"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    <option selected value="">Pilih Transportasi
                                    </option>
                                    <option value="Andong/bendi/sado/dokar/delman/becak">
                                        Andong/bendi/sado/dokar/delman/becak</option>
                                    <option value="Angkutan umum/bus/pete-pete">Angkutan umum/bus/pete-pete
                                    </option>
                                    <option value="Jalan kaki">Jalan kaki</option>
                                    <option value="Kereta api">Kereta api</option>
                                    <option value="Kuda">Kuda</option>
                                    <option value="Lainnya">Lainnya</option>
                                    <option value="Mobil pribadi">Mobil pribadi</option>
                                    <option value="Mobil/bus antar jemput">Mobil/bus antar jemput</option>
                                    <option value="Ojek">Ojek</option>
                                    <option value="Perahu penyeberangan/rakit/getek">Perahu
                                        penyeberangan/rakit/getek
                                    </option>
                                    <option value="Sepeda">Sepeda</option>
                                    <option value="Sepeda motor">Sepeda motor</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.alat_transportasi')" />
                            </div>
                        </div>
                    </div>
                    <div class="p-4 grid gap-4">
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="data_peserta.nomor_telepon" :value="__('Whatsapp')" />
                                <x-text-input type="number" wire:model="data_peserta.nomor_telepon"
                                    id="data_peserta.nomor_telepon" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.nomor_telepon')" />
                            </div>
                            <div>
                                <x-input-label for="data_peserta.email" :value="__('Email')" />
                                <x-text-input type="email" wire:model="data_peserta.email" id="data_peserta.email"
                                    class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.email')" />
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="pendidikan" :value="__('Pendidikan Terakhir')" />
                                <select name="pendidikan" id="pendidikan" wire:model="data_peserta.pendidikan"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
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
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.pendidikan')" />
                            </div>
                            <div>
                                <x-input-label for="status_saat_ini" :value="__('Status Saat Ini')" />
                                <select name="status_saat_ini" id="status_saat_ini"
                                    wire:model="data_peserta.status_saat_ini"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Pelajar">Pelajar</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Bekerja">Bekerja</option>
                                    <option value="Pengusaha">Pengusaha</option>
                                    <option value="Belum Bekerja">Belum Bekerja</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.status_saat_ini')" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select name="status" id="status" wire:model="data_peserta.status"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">Pilih Status
                                </option>
                                <option value="aktif">aktif</option>
                                <option value="nonaktif">nonaktif</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('data_peserta.status')" />
                        </div>
                        @if (!$peserta->id_group)
                            <div>
                                <x-input-label for="status_pembayaran" :value="__('Status Pembayaran')" />
                                <select name="status_pembayaran" id="status_pembayaran"
                                    wire:model="data_peserta.status_pembayaran"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Status Pembayaran
                                    </option>
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.status_pembayaran')" />
                            </div>
                            <div>
                                <x-input-label for="honor_instruktur" :value="__('Honor Instruktur')" />
                                <select name="honor_instruktur" id="honor_instruktur"
                                    wire:model="data_peserta.honor_instruktur"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Honor Instruktur
                                    </option>
                                    <option value="1">Dibayar</option>
                                    <option value="0">Belum Dibayar</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.honor_instruktur')" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (!$peserta->id_group)
                <div class="p-4 grid lg:grid-cols-2 gap-4">
                    <div class="p-4">
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="instruktur" :value="__('Instruktur')" />
                                <select wire:model="instruktur" id="instruktur"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Instruktur
                                    </option>
                                    @foreach ($ins as $in)
                                        <option value="{{ $in->id_instruktur }}-{{ $in->id_mapel }}">
                                            {{ $in->instruktur->user->name }} ~ {{ $in->mapel->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('data_peserta.instruktur')" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <input type="hidden" id="inputProvince" wire:model="data_peserta.provinsi">
            <input type="hidden" id="inputKabkota" wire:model="data_peserta.kab_kota">
            <input type="hidden" id="inputKecamatan" wire:model="data_peserta.kecamatan">
            <input type="hidden" id="inputKelurahan" wire:model="data_peserta.kelurahan">
            <div class="p-4">
                <x-primary-button>Simpan</x-primary-button>
            </div>
        </form>
    @elseif($role === 'instruktur')
        <div class="mt-6 text-sm px-4 text-slate-700">
            <div class="flex justify-between py-3">
                <div>Nama</div>
                <div class="text-end text-base text-slate-700">{{ $peserta->user->name }}</div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Jenis Kelamin</div>
                <div class="text-end text-base text-slate-700">{{ $peserta->jenis_kelamin }}</div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Usia</div>
                <div class="text-end text-base text-slate-700">{{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->age }} Tahun</div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Alamat</div>
                <div class="text-end text-base text-slate-700">{{ $peserta->alamat }}</div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Whatsapp</div>
                <div class="text-end text-base text-slate-700">
                    <td>
                        <a target="_blank"
                            href="{{ 'https://wa.me/' . $peserta->nomor_telepon . '?text=' . urlencode('Hallo ' . $peserta->user->name) }}"
                            class="text-blue-800 hover:text-blue-600 underline font-thin">
                            {{ $peserta->nomor_telepon }}
                        </a>
                    </td>
                </div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Program</div>
                <div class="text-end text-base text-slate-700">
                    {{ $peserta->id_mapel ? $peserta->mapel->nama : $peserta->group->nama . ' - ' . $peserta->group->mapel->nama }}
                </div>
            </div>
            <hr>
        </div>
    @endif
</div>
<script>
    const selectedProvince = document.getElementById('provinsi');
    const selectedRegencie = document.getElementById('kab_kota');
    const selectedDistrict = document.getElementById('kecamatan');
    const selectedvillage = document.getElementById('kelurahan');

    const pesertaProvinsi = "{{ $peserta->provinsi }}";
    console.log(pesertaProvinsi);

    function readProvince() {
        fetch(`https://alamat.thecloudalert.com/api/provinsi/get/`)
            .then(response => response.json())
            .then(data => {
                let provinces = data.result;
                let options = '<option value="">Pilih Provinsi</option>';
                provinces.forEach(province => {
                    options +=
                        `<option ${ pesertaProvinsi == province.text ? 'selected' : '' } value="${province.id}~${province.text}">${province.text}</option>`;
                });
                selectedProvince.innerHTML = options;
            });
    }
    readProvince();
    window.addEventListener('reload-province', (event) => {
        readProvince();
    })
    selectedProvince.addEventListener('change', (event) => {
        const selectedValue = event.target.value;
        const selectedId = selectedValue.split("~")[0];
        const selectedName = selectedValue.split("~")[1];
        document.getElementById('inputProvince').value = selectedName;
        fetch(`\https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=${selectedId}`)
            .then(response => response.json())
            .then(data => {
                let regencies = data.result;
                let options = '<option selected value="">Pilih Kab/kota</option>';
                regencies.forEach(regencie => {
                    options +=
                        `<option value="${regencie.id}~${regencie.text}">${regencie.text}</option>`;
                });
                selectedRegencie.innerHTML = options;
            });
    });

    selectedRegencie.addEventListener('change', (event) => {
        const selectedValue = event.target.value;
        const selectedId = selectedValue.split("~")[0];
        const selectedName = selectedValue.split("~")[1];
        document.getElementById('inputKabkota').value = selectedName;
        fetch(`https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=${selectedValue}`)
            .then(response => response.json())
            .then(data => {
                let districts = data.result;
                let options = '<option selected value="">Pilih Kecamatan</option>';
                districts.forEach(district => {
                    options +=
                        `<option value="${district.id}~${district.text}">${district.text}</option>`;
                });
                selectedDistrict.innerHTML = options;
            });
    });

    selectedDistrict.addEventListener('change', (event) => {
        const selectedValue = event.target.value;
        const selectedId = selectedValue.split("~")[0];
        const selectedName = selectedValue.split("~")[1];
        document.getElementById('inputKecamatan').value = selectedName;
        fetch(`https://alamat.thecloudalert.com/api/kelurahan/get/?d_kecamatan_id=${selectedValue}`)
            .then(response => response.json())
            .then(data => {
                let villages = data.result;
                let options = '<option selected value="">Pilih Kelurahan</option>';
                villages.forEach(village => {
                    options +=
                        `<option value="${village.id}~${village.text}">${village.text}</option>`;
                });
                selectedvillage.innerHTML = options;
            });
    });

    selectedvillage.addEventListener('change', (event) => {
        const selectedValue = event.target.value;
        const selectedId = selectedValue.split("~")[0];
        const selectedName = selectedValue.split("~")[1];
        document.getElementById('inputKelurahan').value = selectedName;
    });

    const tanggal_dibayar = document.getElementById('tanggal_dibayar');
    const d = new Date();
    const formattedDate = d.toISOString().slice(0, 16);
    tanggal_dibayar.value = formattedDate;
</script>
