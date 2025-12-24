<div class="p-4 bg-white border border-slate-200 shadow-lg rounded-sm">
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Hapus Peserta Didik') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Peserta akan terhapus dan seluruh data pada peserta dan seluruh absensi akan ikut terhapus.') }}
            </p>
        </header>

        <x-danger-button onclick="hapusPesertaJs()">{{ __('Hapus Peserta Didik') }}</x-danger-button>
    </section>
</div>
<script>
    function hapusPesertaJs() {
        Swal.fire({
            title: 'Apakah Kamu yakin?',
            text: "Kamu akan menghapus peserta ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`hapusPeserta`);
            }
        });
    }
</script>
