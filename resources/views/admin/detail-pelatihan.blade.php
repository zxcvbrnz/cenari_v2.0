<x-app-layout>
    <livewire:components.admin.detail-pelatihan :data="$data" />
</x-app-layout>
<script>
    function tableIni() {
        $(document).ready(function() {
            var table = $('#tableDetailPelatihan').DataTable({
                    destroy: true,
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    }
    tableIni();
    window.addEventListener('reload-table-detail-pelatihan', (event) => {
        tableIni();
    })
</script>
