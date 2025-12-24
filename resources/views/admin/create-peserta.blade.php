<x-app-layout>
    <main class="py-14 lg:py-20">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="text-slate-700 py-4 px-4">
                Peserta didik baru
            </div>
            <hr />
            <form action="" method="post">
                @csrf
                <div class="grid lg:grid-cols-2 gap-4 p-4">
                    <div class="grid gap-4">
                        <div class="grid lg:grid-cols-2">
                            <div class="lg:flex lg:items-center">
                                <x-input-label class="required" for="name" :value="__('Nama')" />
                            </div>
                            <div>
                                <x-text-input type="text" name="name" id="name" class="mt-1 block w-full"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2">
                            <div class="lg:flex lg:items-center">
                                <x-input-label class="required" for="tempat_lahir" :value="__('Tempat Lahir')" />
                            </div>
                            <div>
                                <x-text-input type="text" name="tempat_lahir" id="tempat_lahir"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2">
                            <div class="lg:flex lg:items-center">
                                <x-input-label class="required" for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            </div>
                            <div>
                                <x-text-input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2">
                            <div class="lg:flex lg:items-center">
                                <x-input-label class="required" for="nama_ibu" :value="__('Nama Ibu Kandung')" />
                            </div>
                            <div>
                                <x-text-input type="text" name="nama_ibu" id="nama_ibu" class="mt-1 block w-full"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_ibu')" />
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2">
                            <div class="lg:flex lg:items-center">
                                <x-input-label class="required" for="nama_ayah" :value="__('Nama Ayah')" />
                            </div>
                            <div>
                                <x-text-input type="text" name="nama_ayah" id="nama_ayah" class="mt-1 block w-full"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_ayah')" />
                            </div>
                        </div>
                        <hr>
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <x-input-label for="nisn" :value="__('NISN')" />
                                <x-text-input type="number" name="nisn" id="nisn" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('nisn')" />
                            </div>
                            <div>
                                <x-input-label for="nik" :value="__('NIK')" />
                                <x-text-input type="number" name="nik" id="nik" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <x-input-label class="required" for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilih Jenis Kelamin
                                    </option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="agama" :value="__('Agama')" />
                                <select name="agama" id="agama"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilih Agama
                                    </option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Kong Hu Chu">Kong Hu Chu</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('agama')" />
                            </div>
                        </div>
                        <div>
                            <x-input-label class="required" for="kewarganegaraan" :value="__('Kewarganegaraan')" />
                            <select name="kewarganegaraan" id="kewarganegaraan"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                required>
                                <option selected value="">Pilih Kewarganegaraan
                                </option>
                                <option value="WNI">WNI</option>
                                <option value="WNA">WNA</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('kewarganegaraan')" />
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <x-input-label class="required" for="penerima_kps" :value="__('Penerima KPS')" />
                                <select name="penerima_kps" id="penerima_kps"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('penerima_kps')" />
                            </div>
                            <div>
                                <x-input-label for="no_kps" :value="__('No KPS')" />
                                <x-text-input type="number" name="no_kps" id="no_kps"
                                    class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_kps')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <x-input-label class="required" for="layak_pip" :value="__('Layak PIP')" />
                                <select name="layak_pip" id="layak_pip"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('layak_pip')" />
                            </div>
                            <div>
                                <x-input-label for="alasan_pip" :value="__('Alasan Layak PIP')" />
                                <select name="alasan_pip" id="alasan_pip"
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
                                <x-input-error class="mt-2" :messages="$errors->get('alasan_pip')" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <x-input-label class="required" for="penerima_kip" :value="__('Penerima KIP')" />
                                <select name="penerima_kip" id="penerima_kip"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('penerima_kip')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="no_kip" :value="__('No KIP')" />
                                <x-text-input type="number" name="no_kip" id="no_kip"
                                    class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('no_kip')" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="border p-4 grid gap-4">
                            <div>
                                <x-input-label class="required" for="alamat" :value="__('Alamat')" />
                                <x-text-input type="text" name="alamat" id="alamat" class="mt-1 block w-full"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                            </div>
                            <div class="grid grid-cols-3 gap-8">
                                <div>
                                    <x-input-label for="rt" :value="__('RT')" />
                                    <x-text-input type="number" name="rt" id="rt"
                                        class="mt-1 block w-full" value="0" />
                                    <x-input-error class="mt-2" :messages="$errors->get('rt')" />
                                </div>
                                <div>
                                    <x-input-label for="rw" :value="__('RW')" />
                                    <x-text-input type="number" name="rw" id="rw"
                                        class="mt-1 block w-full" value="0" />
                                    <x-input-error class="mt-2" :messages="$errors->get('rw')" />
                                </div>
                                <div>
                                    <x-input-label for="kode_pos" :value="__('Kode POS')" />
                                    <x-text-input type="number" name="kode_pos" id="kode_pos"
                                        class="mt-1 block w-full" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kode_pos')" />
                                </div>
                            </div>
                            <div>
                                <x-input-label class="required" for="nama_desa_kelurahan" :value="__('Nama Desa/Kelurahan')" />
                                <x-text-input type="text" name="nama_desa_kelurahan" id="nama_desa_kelurahan"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_desa_kelurahan')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="provinsi" :value="__('Provinsi')" />
                                <select id="provinsi"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilih Provinsi
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('provinsi')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="kab_kota" :value="__('Kab/Kota')" />
                                <select id="kab_kota"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilih Kab/kota
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kab_kota')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="kecamatan" :value="__('Kecamatan')" />
                                <select id="kecamatan"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilih Kecamatan
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kecamatan')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="kelurahan" :value="__('Kelurahan')" />
                                <select id="kelurahan"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilih Kelurahan
                                    </option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kelurahan')" />
                            </div>
                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <x-input-label for="jenis_tinggal" :value="__('Jenis Tinggal')" />
                                    <select name="jenis_tinggal" id="jenis_tinggal"
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
                                    <x-input-error class="mt-2" :messages="$errors->get('jenis_tinggal')" />
                                </div>
                                <div>
                                    <x-input-label class="required" for="alat_transportasi" :value="__('Alat Transportasi')" />
                                    <select name="alat_transportasi" id="alat_transportasi"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                        required>
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
                                    <x-input-error class="mt-2" :messages="$errors->get('alat_transportasi')" />
                                </div>
                            </div>
                        </div>
                        <div class="p-4 grid gap-4">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label class="required" for="nomor_telepon" :value="__('Whatsapp')" />
                                    <x-text-input type="number" name="nomor_telepon" id="nomor_telepon"
                                        class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
                                </div>
                                <div>
                                    <x-input-label class="required" for="email" :value="__('Email')" />
                                    <x-text-input type="email" name="email" id="email"
                                        class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <x-input-label class="required" for="pendidikan" :value="__('Pendidikan Terakhir')" />
                                    <select name="pendidikan" id="pendidikan"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                        required>
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
                                    <x-input-label class="required" for="status_saat_ini" :value="__('Status Saat Ini')" />
                                    <select name="status_saat_ini" id="status_saat_ini"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                        required>
                                        <option selected value="">Pilihan
                                        </option>
                                        <option value="Pelajar">Pelajar</option>
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Bekerja">Bekerja</option>
                                        <option value="Pengusaha">Pengusaha</option>
                                        <option value="Belum Bekerja">Belum Bekerja</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('status_saat_ini')" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ jenisKursus: 'private' }" class="p-4 grid lg:grid-cols-2 gap-4">
                    <div class="p-4">
                        <x-input-label class="required" for="alat_transportasi" :value="__('Kelas')" />
                        <div class="flex space-x-6 my-2">
                            <div class="flex items-center">
                                <input type="radio" id="private" name="jenis" value="private"
                                    x-model="jenisKursus" @click="jenisKursus = 'private'">
                                <x-input-label class="ms-1" for="private" :value="__('Private')" />
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="pelatihan" name="jenis" value="pelatihan"
                                    x-model="jenisKursus" @click="jenisKursus = 'pelatihan'">
                                <x-input-label class="ms-1" for="pelatihan" :value="__('Pelatihan')" />
                            </div>
                        </div>
                        <div class="space-y-4" x-show="jenisKursus === 'private'">
                            <div>
                                <x-input-label class="required" for="instruktur" :value="__('Instruktur')" />
                                <select name="instruktur" id="instruktur"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Instruktur
                                    </option>
                                    @foreach ($ins as $in)
                                        <option value="{{ $in->id_instruktur }}-{{ $in->id_mapel }}">
                                            {{ $in->instruktur->user->name }} ~ {{ $in->mapel->nama }} <span
                                                class="text-sm">Rp.
                                                {{ number_format($in->mapel->harga, 0, ',', '.') }}</span></option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('instruktur')" />
                            </div>
                        </div>
                        <div x-show="jenisKursus === 'pelatihan'">
                            <div>
                                <x-input-label class="required" for="id_group" :value="__('Pelatihan')" />
                                <select name="id_group" id="id_group"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Pelatihan
                                    </option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->nama . ' ~ ' . $group->mapel->nama . ' ~ ' . $group->instruktur->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('id_group')" />
                            </div>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div x-show="jenisKursus === 'private'">
                            <x-input-label class="required" for="jumlah_dibayar" :value="__('Jumlah Dibayar')" />
                            <x-text-input type="text" id="input-jumlah-dibayar" class="mt-1 block w-full" type-currency="IDR1"
                            placeholder="Rp. 0" autocomplete="off"/>
                            <input id="jumlah-dibayar" name="jumlah_dibayar" type="hidden">
                            <x-input-error class="mt-2" :messages="$errors->get('jumlah_dibayar')" />
                        </div>
                        <div x-show="jenisKursus === 'private'">
                            <x-input-label class="required" for="tanggal_dibayar" :value="__('Tanggal Dibayar')" />
                            <x-text-input type="datetime-local" name="tanggal_dibayar" id="tanggal_dibayar"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_dibayar')" />
                        </div>
                        <div x-show="jenisKursus === 'private'">
                            <x-input-label class="required" for="status_pembayaran" :value="__('Status Pembayaran')" />
                            <select name="status_pembayaran" id="status_pembayaran"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                <option selected value="">Pilih Status Pembayaran
                                </option>
                                <option value="Belum Bayar">Belum Bayar</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status_pembayaran')" />
                        </div>
                        <div x-show="jenisKursus === 'private'">
                            <x-input-label class="required" for="deskripsi" :value="__('Deskripsi')" />
                            <x-text-input type="text" name="deskripsi" id="deskripsi"
                                class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>
                    </div>
                </div>
                <input type="hidden" id="inputProvince" name="provinsi">
                <input type="hidden" id="inputKabkota" name="kab_kota">
                <input type="hidden" id="inputKecamatan" name="kecamatan">
                <input type="hidden" id="inputKelurahan" name="kelurahan">
                <div class="p-4">
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
        <script>
            document.getElementById('jumlah-dibayar').value = 0;
            document.querySelectorAll('input[type-currency="IDR1"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPosition = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLength = this.value.length;
                    if (isNaN(value)) {
                        this.value = "0";
                    } else {    
                        this.value = value.toLocaleString('id-ID', {
                            currency: 'IDR',
                            style: 'currency',
                            minimumFractionDigits: 0
                        });
                        cursorPosition = this.value.length - originalLength + cursorPosition;
                        this.setSelectionRange(cursorPosition, cursorPosition);
                    }
                    let priceInput = document.getElementById('input-jumlah-dibayar').value;
                    let priceValue = parseInt(priceInput.replace(/[^,\d]/g, ''));
                    document.getElementById('jumlah-dibayar').value = priceValue;
                });
            });
            
        
            const selectedProvince = document.getElementById('provinsi');
            const selectedRegencie = document.getElementById('kab_kota');
            const selectedDistrict = document.getElementById('kecamatan');
            const selectedvillage = document.getElementById('kelurahan');

            fetch(`https://alamat.thecloudalert.com/api/provinsi/get/`)
                .then(response => response.json())
                .then(data => {
                    let provinces = data.result;
                    let options = '<option selected value="">Pilih Provinsi</option>';
                    provinces.forEach(province => {
                        options += `<option value="${province.id}~${province.text}">${province.text}</option>`;
                    });
                    selectedProvince.innerHTML = options;
                });

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
    </main>
</x-app-layout>
