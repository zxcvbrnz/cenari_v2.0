<div>
    @if (auth()->user()->role === 'admin')
        <form wire:submit="update" class="grid lg:grid-cols-2">
            <div class="grid gap-4">
                <div>
                    <x-input-label class="required" for="nama" :value="__('Nama')" />
                    <x-text-input wire:model="nama" id="nama" name="nama" type="text" class="mt-1 block w-full"
                        required autofocus autocomplete="nama" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>
                <div>
                    <x-input-label class="required" for="instruktur" :value="__('Instruktur')" />
                    <select name="instruktur" id="instruktur" wire:model="instruktur"
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
                    <x-text-input id="input-harga" type="text" type-currency="IDR" autocomplete="off"
                        class="mt-1 block w-full" placeholder="Rp{{ number_format($harga, 0, ',', '.') }}" />
                    <input id="harga" name="harga" wire:model="harga" type="hidden">
                    <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                </div>
                <div>
                    <x-input-label class="required" for="status" :value="__('Status')" />
                    <select name="status" id="status" wire:model="status"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                        <option selected value="">Pilih Status
                        </option>
                        <option value="aktif">aktif</option>
                        <option value="nonaktif">nonaktif</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
                <div>
                    <x-input-label class="required" for="status_pembayaran" :value="__('Status Pembayaran')" />
                    <select name="status_pembayaran" id="status_pembayaran" wire:model="status_pembayaran"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm block mt-1 w-full">
                        <option selected value="">Pilih Status Pembayaran
                        </option>
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('data_peserta.status_pembayaran')" />
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                </div>
            </div>
        </form>
    @elseif(auth()->user()->role === 'instruktur')
        <div class="mt-6 text-sm px-4">
            <div class="flex justify-between py-3">
                <div>Nama</div>
                <div class="text-end text-base text-slate-700">{{ $data->nama }}</div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Program</div>
                <div class="text-end text-base text-slate-700">
                    {{ $data->mapel->nama }}</div>
            </div>
            <hr>
            <div class="flex justify-between py-3">
                <div>Status</div>
                <div class="text-end text-base text-slate-700">{{ $data->status }}</div>
            </div>
            <hr>
        </div>
    @endif
</div>

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
            @this.set('harga', priceValue);
        });
    });
</script>
