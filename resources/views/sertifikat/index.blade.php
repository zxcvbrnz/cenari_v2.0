<x-app-layout>
    <livewire:sertifikat.sertifikat-index />
</x-app-layout>
<script>
    function initializeDataTableSertifikat() {
        $(document).ready(function() {
            var table = $('#tableSertifikat').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    }
    initializeDataTableSertifikat();
    window.addEventListener('reload-table-sertifikat', (event) => {
        initializeDataTableSertifikat();
    });
</script>
