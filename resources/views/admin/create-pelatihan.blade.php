<x-app-layout>
    <main class="py-14 md:py-20">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="text-slate-700 py-4 px-4">
                Pelatihan baru
            </div>
            <hr />
            <form class="p-4 grid lg:grid-cols-2 gap-4" action="" method="post">
                @csrf
                <div class="grid gap-4">
                    <div>
                        <div class="grid gap-4">
                            <div>
                                <x-input-label class="required" for="nama" :value="__('Nama')" />
                                <x-text-input type="text" name="nama" id="nama" class="mt-1 block w-full"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="instruktur" :value="__('Instruktur')" />
                                <select name="instruktur" id="instruktur" required
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                                    <option selected value="">Pilih Instruktur
                                    </option>
                                    @foreach ($ins as $in)
                                        <option value="{{ $in->id_instruktur }}-{{ $in->id_mapel }}">
                                            {{ $in->instruktur->user->name }} ~ {{ $in->mapel->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('instruktur')" />
                            </div>
                            <div>
                                <x-input-label class="required" for="harga" :value="__('Harga')" />
                                <x-text-input id="input-harga" type="text" class="mt-1 block w-full" type-currency="IDR"
                                    required autocomplete="harga" placeholder="Rp." autocomplete="off"/>
                                <input id="harga" name="harga" type="hidden">
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <x-input-label class="required" for="jumlah_dibayar" :value="__('Jumlah Dibayar')" />
                        <x-text-input type="text" id="input-jumlah-dibayar" class="mt-1 block w-full" type-currency="IDR1"
                            placeholder="Rp. 0" autocomplete="off"/>
                        <input id="jumlah-dibayar" name="jumlah_dibayar" type="hidden">
                        <x-input-error class="mt-2" :messages="$errors->get('jumlah_dibayar')" />
                    </div>
                    <div>
                        <x-input-label class="required" for="tanggal_dibayar" :value="__('Tanggal Dibayar')" />
                        <x-text-input type="datetime-local" name="tanggal_dibayar" id="tanggal_dibayar"
                            class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('tanggal_dibayar')" />
                    </div>
                    <div>
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
                    <div>
                        <x-input-label class="required" for="deskripsi" :value="__('Deskripsi')" />
                        <x-text-input type="text" name="deskripsi" id="deskripsi" class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                    </div>
                </div>
                <div class="p-4">
                    <x-primary-button>Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </main>
    <script>
        document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
                element.addEventListener('keyup', function(e) {
                    let cursorPosition = this.selectionStart;
                    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                    let originalLength = this.value.length;
                    if (isNaN(value)) {
                        this.value = "";
                    } else {    
                        this.value = value.toLocaleString('id-ID', {
                            currency: 'IDR',
                            style: 'currency',
                            minimumFractionDigits: 0
                        });
                        cursorPosition = this.value.length - originalLength + cursorPosition;
                        this.setSelectionRange(cursorPosition, cursorPosition);
                    }
                    let priceInput = document.getElementById('input-harga').value;
                    let priceValue = parseInt(priceInput.replace(/[^,\d]/g, ''));
                    document.getElementById('harga').value = priceValue;
                });
            });
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
    </script>
</x-app-layout>
