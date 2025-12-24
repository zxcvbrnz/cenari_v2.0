<main class="py-14 md:py-20">
    <div class="mb-6">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="p-4 flex justify-between items-center">
                <div class="text-xl text-slate-600">Data Instruktur</div>
            </div>
            <hr>
            <div class="p-6">
                <table class="dat-table stripe hover text-sm text-left text-gray-500"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th data-priority="1" class="text-start">No</th>
                            <th data-priority="2" class="text-start">Nama</th>
                            <th data-priority="3" class="text-start">Whatsapp</th>
                            <th data-priority="4" class="text-start">Rekening</th>
                            <th data-priority="5" class="text-start">Username</th>
                            <th data-priority="6" class="text-start">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($instruktur as $dat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="flex items-center space-x-2">
                                    <img class="w-10 h-10 rounded-full object-cover cursor-pointer"
                                        src="{{ $dat->user->image ? asset('storage/image/' . $dat->user->image) : asset('image/default.png') }}"
                                        alt="profile" />
                                    <span>{{ $dat->user->name }}</span>
                                </td>
                                <td>
                                    <a href="{{ 'https://wa.me/' . $dat->nomor_telepon . '?text=' . urlencode('Hallo ' . $dat->user->name) }}"
                                        class="text-blue-800 hover:text-blue-600 underline font-thin">{{ $dat->nomor_telepon }}</a>
                                </td>
                                <td>{{ $dat->rekening }}</td>
                                <td>{{ $dat->user->username }}</td>
                                <td>
                                    <a href="{{ route('admin.data.instruktur.update', ['id' => $dat->id]) }}"
                                        wire:navigate
                                        class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
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
