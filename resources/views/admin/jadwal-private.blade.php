<x-app-layout>
    <main class="py-14 md:py-20">
        <div class="mb-6">
            <livewire:components.admin.private-jadwal-berlangsung />
        </div>
        <div class="mb-6">
            <livewire:components.admin.private-riwayat-jadwal />
        </div>
        <div class="mb-6">
            <livewire:components.admin.private-jadwal-ditolak />
        </div>
    </main>
</x-app-layout>
<script>
    function tableIni() {
        $(document).ready(function() {
            var table = $('.dat-table-jadwal-private').DataTable({
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
