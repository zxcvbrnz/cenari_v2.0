<x-app-layout>
    <main class="py-14 md:py-20">
        <div class="mb-6">
            <livewire:components.admin.pelatihan-jadwal-berlangsung />
        </div>
        <div class="mb-6">
            <livewire:components.admin.pelatihan-riwayat-jadwal />
        </div>
        <div class="mb-6">
            <livewire:components.admin.pelatihan-jadwal-ditolak />
        </div>
    </main>
</x-app-layout>
<script>
    function tableIni() {
        $(document).ready(function() {
            var table = $('.dat-table-jadwal-pelatihan').DataTable({
                    destroy: true,
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    }
    tableIni();
    window.addEventListener('reload-table', (event) => {
        tableIni();
    })
</script>
