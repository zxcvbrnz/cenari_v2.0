<main class="py-14 md:py-20">
    <div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 py-4 px-4">
            Edit {{ $mapel->nama }}
        </div>
        <hr />
        <form wire:submit="update">
            <div class="p-4 grid lg:grid-cols-2 gap-4">
                <div>
                    <x-input-label class="required" for="nama" :value="__('Nama')" />
                    <x-text-input wire:model="nama" id="nama" name="nama" type="text" class="mt-1 block w-full"
                        required autofocus autocomplete="nama" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>
                <div>
                    <x-input-label class="required" for="harga" :value="__('Harga')" />
                    <x-text-input id="input-harga" type="text" type-currency="IDR" autocomplete="off"
                        class="mt-1 block w-full" required placeholder="Rp{{ number_format($harga, 0, ',', '.') }}"/>
                    <input id="harga" name="harga" wire:model="harga" type="hidden">
                    <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                </div>
            </div>
            <hr>
            <div class="p-4 grid lg:grid-cols-2 gap-4">
                @foreach ($materi as $key => $value)
                    <div>
                        <x-input-label for="{{ $key }}" :value="ucfirst(str_replace('_', ' ', $key))" />
                        <x-text-input wire:model="materi.{{ $key }}" id="{{ $key }}"
                            name="{{ $key }}" type="text" class="mt-1 block w-full" autofocus
                            autocomplete="{{ $key }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('{{ $key }}')" />
                    </div>
                @endforeach
            </div>
            <div class="p-4">
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            </div>
        </form>
    </div>
    <div class="p-4 bg-white border border-slate-200 shadow-lg rounded-sm">
        <section class="space-y-6">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Hapus Program') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Program akan terhapus seluruhnya.') }}
                </p>
            </header>

            <x-danger-button onclick="hapusMapelJs()">{{ __('Hapus Program') }}</x-danger-button>
        </section>
    </div>
</main>
<script>
    function hapusMapelJs() {
        Swal.fire({
            title: 'Apakah Kamu yakin?',
            text: "Kamu akan menghapus Program ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`hapusMapel`);
            }
        });
    }
    
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