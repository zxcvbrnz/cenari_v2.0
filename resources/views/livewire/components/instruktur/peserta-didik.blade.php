<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Peserta Didik Kamu</div>
    </div>
    <hr>
    <div class="p-6">
        <table class="dat-table stripe hover text-sm text-left text-gray-500"
            style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th class="text-start">No</th>
                    <th class="text-start">Peserta didik</th>
                    <th class="text-start">Program</th>
                    <th class="text-start">Whatsapp</th>
                    <th class="text-start">Nilai</th>
                    <th class="text-start">status</th>
                    <th class="text-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peserta as $dat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="flex items-center space-x-2">
                            <img class="w-10 h-10 rounded-full object-cover cursor-pointer"
                                src="{{ $dat->user->image ? asset('storage/image/' . $dat->user->image) : asset('image/default.png') }}"
                                alt="profile" />
                            <span>{{ $dat->user->name }}</span>
                        </td>
                        <td>{{ $dat->mapel->nama }}</td>
                        <td>
                            <a target="_blank"
                                href="{{ 'https://wa.me/' . $dat->nomor_telepon . '?text=' . urlencode('Hallo ' . $dat->user->name) }}"
                                class="text-blue-800 hover:text-blue-600 underline font-thin">{{ $dat->nomor_telepon }}</a>
                                
                                @php
                                    $nomor = $dat->nomor_telepon;
                                    if (Str::startsWith($nomor, '08')) {
                                        $nomor = '62' . substr($nomor, 1);
                                    }
                                @endphp
                                
                                <a target="_blank"
                                href="{{ 'https://wa.me/' . $nomor . '?text=' . urlencode('Hallo ' . $dat->user->name) }}"
                                class="text-blue-800 hover:text-blue-600 underline font-thin">{{ $dat->nomor_telepon }}</a>
                        </td>
                        <td>
                            @if ($dat->nilai)
                                <span class="text-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M229.66,77.66l-128,128a8,8,0,0,1-11.32,0l-56-56a8,8,0,0,1,11.32-11.32L96,188.69,218.34,66.34a8,8,0,0,1,11.32,11.32Z">
                                        </path>
                                    </svg>
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($dat->status === 'aktif')
                                <span
                                    class="text-green-800 bg-green-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status }}</span>
                            @else
                                <span
                                    class="text-red-800 bg-red-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('instruktur.peserta.didik.detail', ['id' => $dat->id]) }}" wire:navigate
                                class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">View</a>
                        </td>
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
