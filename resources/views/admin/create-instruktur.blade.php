<x-app-layout>
    <main class="py-14 md:py-20">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="text-slate-700 py-4 px-4">
                Instruktur baru
            </div>
            <hr />
            <form action="" method="post">
                @csrf
                <div class="p-4 grid lg:grid-cols-2 gap-4">
                    <div class="grid gap-4">
                        <div>
                            <x-input-label class="required" for="name" :value="__('Nama')" />
                            <x-text-input type="text" name="name" id="name" class="mt-1 block w-full"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="nik" :value="__('NIK')" />
                            <x-text-input type="number" name="nik" id="nik" class="mt-1 block w-full"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="alamat" :value="__('Alamat')" />
                            <x-text-input type="text" name="alamat" id="alamat" class="mt-1 block w-full"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="kota" :value="__('Kota Domisili')" />
                            <x-text-input type="text" name="kota" id="kota" class="mt-1 block w-full"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('kota')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="provinsi" :value="__('Provinsi')" />
                            <x-text-input type="text" name="provinsi" id="provinsi" class="mt-1 block w-full"
                                required />
                            <x-input-error class="mt-2" :messages="$errors->get('provinsi')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="nomor_telepon" :value="__('Whatsapp')" />
                            <x-text-input type="number" name="nomor_telepon" id="nomor_telepon"
                                class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="email" :value="__('Email')" />
                            <x-text-input type="email" name="email" id="email" class="mt-1 block w-full"
                                required placeholder='example@email.com' />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <x-input-label class="required" for="ttl" :value="__('Tempat, Tanggal Lahir')" />
                            <x-text-input type="text" name="ttl" id="ttl" class="mt-1 block w-full"
                                required placeholder='Banjarmasin, 04 April 2000' />
                            <x-input-error class="mt-2" :messages="$errors->get('ttl')" />
                        </div>
                    </div>
                    <div>
                        <div class="grid gap-4">
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
                                <x-input-label class="required" for="tanggal_menjadi" :value="__('Tanggal Menjadi Pendidik')" />
                                <x-text-input type="date" name="tanggal_menjadi" id="tanggal_menjadi"
                                    class="mt-1 block w-full" required />
                                <x-input-error class="mt-2" :messages="$errors->get('tanggal_menjadi')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="NUPWK" :value="__('NUPWK')" />
                                <x-text-input type="number" name="NUPWK" id="NUPWK" class="mt-1 block w-full"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('NUPWK')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="rekening" :value="__('Nomor Rekening')" />
                                <x-text-input type="text" name="rekening" id="rekening"
                                    class="mt-1 block w-full" placeholder="xxxx-xxxx-xxxx (Bank)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('rekening')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="status" :value="__('Status Keluarga')" />
                                <select name="status" id="status"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="status_kerja" :value="__('Status Kerja')" />
                                <select name="status_kerja" id="status_kerja"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                    required>
                                    <option selected value="">Pilihan
                                    </option>
                                    <option value="Tidak Tetap">Tidak Tetap</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status_kerja')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="pekerjaan" :value="__('Pekerjaan Lainnya')" />
                                <div class="relative">
                                    <select name="pekerjaan" id="pekerjaan"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                        required>
                                        <option selected value="">Pilihan</option>
                                        <option value="Guru Swasta">Guru Swasta</option>
                                        <option value="Dosen">Dosen</option>
                                        <option value="Wirausahawan">Wirausahawan</option>
                                        <option value="Karyawan">Karyawan</option>
                                        <option value="PNS/TNI/Polri">PNS/TNI/Polri</option>
                                        <option value="Profesional Suatu Bidang">Profesional Suatu Bidang</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>

                                    <input type="text" name="pekerjaan_lainnya" id="pekerjaan_lainnya"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full"
                                        placeholder="Sebutkan pekerjaan lainnya"
                                        style="display: none; position: absolute; top: 2.5rem; left: 0; z-index: 10;">
                                </div>

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
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pekerjaanSelect = document.getElementById('pekerjaan');
            const pekerjaanLainnyaInput = document.getElementById('pekerjaan_lainnya');

            pekerjaanSelect.addEventListener('change', function() {
                if (pekerjaanSelect.value === 'Lainnya') {
                    pekerjaanLainnyaInput.style.display = 'block';
                } else {
                    pekerjaanLainnyaInput.style.display = 'none';
                    pekerjaanLainnyaInput.value = ''; // Clear the input field if not 'Lainnya'
                }
            });
        });
    </script>
</x-app-layout>
