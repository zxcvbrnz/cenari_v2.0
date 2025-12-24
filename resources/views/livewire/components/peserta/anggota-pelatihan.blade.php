<div>
    <div class="p-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <table class="dat-table stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th class="text-start">No</th>
                    <th class="text-start">Nama Peserta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota->sortBy('user.name') as $dat)
                    <tr>
                        <td><span class="font-bold">{{ $loop->iteration . '. ' }}</span></td>
                        <td class="flex items-center space-x-2">
                            <img class="w-10 h-10 rounded-full object-cover cursor-pointer"
                                        src="{{ $dat->user->image ? asset('storage/image/' . $dat->user->image) : asset('image/default.png') }}"
                                        alt="profile" />
                            <span>{{ $dat->user->name }}</span></td>
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
