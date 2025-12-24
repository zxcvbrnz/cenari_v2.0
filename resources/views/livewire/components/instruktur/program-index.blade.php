<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Program Kursus</div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th class="text-start">No</th>
                    <th class="text-start">Program</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $dat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dat->mapel->nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@script
    <script>
        $(document).ready(function() {
            var table = $('.dat-table').DataTable({
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>
@endscript
