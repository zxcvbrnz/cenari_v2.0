<x-app-layout>
    <main class="py-14 md:py-20">
        <div class="mb-6">
            <livewire:components.admin.private-permohonan />
        </div>
        <div class="mb-6">
            <livewire:components.admin.group-permohonan />
        </div>
</x-app-layout>
<script>
    function tableIni() {
        $(document).ready(function() {
            var table = $('.dat-table-permohonan').DataTable({
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
