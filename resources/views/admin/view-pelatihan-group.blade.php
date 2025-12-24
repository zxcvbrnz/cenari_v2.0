<x-app-layout>
    <main class="py-14 md:py-20">
        <div class="mb-6">
            <livewire:components.admin.view-pelatihan-group 
                :id_group="request()->id_group" 
                :id_instruktur="request()->id_instruktur" 
                :waktu_mulai="request()->waktu_mulai" 
                :keterangan="request()->keterangan" 
            />
        </div>
    </main>
</x-app-layout>
<script>
    function tableIni() {
        $(document).ready(function() {
            var table = $('.dat-table-jadwal-pelatihan-view').DataTable({
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
