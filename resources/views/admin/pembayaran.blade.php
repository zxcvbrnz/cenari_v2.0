<x-app-layout>
    <livewire:components.admin.pembayaran />
</x-app-layout>

<script>
    function initializeDataTablePembayaran() {
        $(document).ready(function() {
            var table = $('#tablePembayaran').DataTable({
                    destroy: true,
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    }
    initializeDataTablePembayaran();
    window.addEventListener('reload-table-pembayaran', (event) => {
        initializeDataTablePembayaran();
        const pembayaranSection = document.getElementById('pembayaran');
        if (pembayaranSection) {
            pembayaranSection.scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>
