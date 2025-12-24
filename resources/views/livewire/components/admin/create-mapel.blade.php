<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 py-4 px-4">
        Mata Pelajaran baru
    </div>
    <hr />
    <form wire:submit="create">
        <div class="p-4 grid lg:grid-cols-2 gap-4">
            <div>
                <x-input-label class="required" for="nama" :value="__('Nama')" />
                <x-text-input wire:model="nama" id="nama" name="nama" type="text" class="mt-1 block w-full"
                    required autofocus autocomplete="nama" />
                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
            </div>
            <div>
                <x-input-label class="required" for="harga" :value="__('Harga')" />
                <x-text-input id="input-harga" type="text" class="mt-1 block w-full" type-currency="IDR"
                    required autocomplete="harga" placeholder="Rp." autocomplete="off"/>
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
                        name="{{ $key }}" type="text" class="mt-1 block w-full"
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
<script>
    document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
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
            let priceInput = document.getElementById('input-harga').value;
            let priceValue = parseInt(priceInput.replace(/[^,\d]/g, ''));
            document.getElementById('harga').value = priceValue;
             @this.set('harga', priceValue);
        });
    });
</script>
