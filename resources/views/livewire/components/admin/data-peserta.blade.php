<main class="py-14 md:py-20">
    <div class="mb-6">
        <div class="bg-white border border-slate-200 shadow-lg rounded-sm">
            <div class="p-4 flex justify-between items-center">
                <div class="text-xl text-slate-600">Data Peserta Didik</div>
                <form action="/export" method="post" class="space-x-1">
                    @csrf
                    <div class="inline-block">
                        <x-text-input id="tanggal" name="tanggal" type="month" class="mt-1 block w-full text-xs" />
                    </div>
                    <x-primary-button>Export</x-primary-button>
                </form>
            </div>
            <hr>
            <div class="p-6">
                <table class="dat-table stripe hover text-sm text-left text-gray-500"
                    style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th data-priority="1" class="text-start">#</th>
                            <th data-priority="2" class="text-start">Peserta didik</th>
                            <!--<th data-priority="2" class="text-start">NIK</th>-->
                            <th data-priority="3" class="text-start">Instruktur</th>
                            <th data-priority="4" class="text-start">Program</th>
                            <th data-priority="5" class="text-start">Username</th>
                            <th data-priority="6" class="text-start">Tanggal Daftar</th>
                            <th data-priority="7" class="text-start">Status</th>
                            <th data-priority="8" class="text-start">Pembayaran</th>
                            <th data-priority="9" class="text-start">Sertifikat</th>
                            <th data-priority="10" class="text-start">Honor Instruktur</th>
                            <th data-priority="11" class="text-start">Aksi</th>
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
                                <!--<td>{{ $dat->nik }}</td>-->
                                <td>
                                    {{ $dat->instruktur ? $dat->instruktur->user->name : $dat->group->instruktur->user->name }}
                                </td>
                                <td>
                                    <div>{{ $dat->mapel ? $dat->mapel->nama : $dat->group->mapel->nama }}</div>
                                    <div class="text-slate-600 text-xs font-bold">{{ $dat->mapel ? '' : $dat->group->nama }}</div>
                                </td>
                                <td>{{ $dat->user->username }}</td>
                                <td>{{ $dat->created_at ? $dat->created_at->format('d F Y') : '' }}</td>
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
                                    @if ($dat->id_group)
                                        <span class="text-sm ">Pelatihan</span>
                                    @else
                                        @if ($dat->status_pembayaran === 'Lunas')
                                            <span
                                                class="text-green-800 bg-green-300 text-sm py-0.5 rounded-full px-3">{{ $dat->status_pembayaran }}</span>
                                        @elseif($dat->status_pembayaran === 'Belum Lunas')
                                            <span
                                                class="text-orange-800 bg-orange-300 text-sm py-0.5 rounded-full px-3">B-Lunas</span>
                                        @elseif($dat->status_pembayaran === 'Belum Bayar')
                                            <span
                                                class="text-red-800 bg-red-300 text-sm py-0.5 rounded-full px-3">B-Bayar</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($dat->sertifikat->link)
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
                                    @if ($dat->honor_instruktur === 1)
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
                                    <a href="{{ route('admin.data.peserta.detail', ['id' => $dat->id]) }}"
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
