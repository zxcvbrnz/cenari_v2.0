<main class="py-14 md:py-20">
    <div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Detail
        </div>
        <hr>
        <div class="p-4">
            <livewire:components.admin.update-pelatihan :data="$data" />
        </div>
    </div>
    <div class="mb-6 bg-white border border-slate-200 shadow-lg rounded-sm">
        <div class="text-slate-700 p-4">
            Daftar Peserta Didik
        </div>
        <hr>
        <div class="p-4">
            <table id="tableDetailPelatihan" class="stripe hover text-sm text-left text-gray-500"
                style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th data-priority="1" class="text-start">No</th>
                        <th data-priority="2" class="text-start">Peserta didik</th>
                        @if (auth()->user()->role === 'admin')
                            <th data-priority="3" class="text-start">Username</th>
                        @endif
                        <th data-priority="4" class="text-start">Whatsapp</th>
                        <th data-priority="4" class="text-start">Nilai</th>
                        <th data-priority="5" class="text-start">Sertifikat</th>
                        <th data-priority="6" class="text-start">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesertas as $peserta)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="flex items-center space-x-2">
                                <img class="w-10 h-10 rounded-full object-cover cursor-pointer"
                                    src="{{ $peserta->user->image ? asset('storage/image/' . $peserta->user->image) : asset('image/default.png') }}"
                                    alt="profile" />
                                <span>{{ $peserta->user->name }}</span>
                            </td>
                            @if (auth()->user()->role === 'admin')
                                <td>{{ $peserta->user->username }}</td>
                            @endif
                            <td>
                                <a href="{{ 'https://wa.me/' . $peserta->nomor_telepon . '?text=' . urlencode('Hallo ' . $peserta->user->name) }}"
                                    class="text-blue-800 hover:text-blue-600 underline font-thin">{{ $peserta->nomor_telepon }}</a>
                            </td>
                            <td>
                                @if ($peserta->nilai)
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
                                @if ($peserta->sertifikat->link)
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
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.data.peserta.detail', ['id' => $peserta->id]) }}"
                                        wire:navigate
                                        class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">View</a>
                                @else
                                    <a href="{{ route('instruktur.peserta.didik.detail', ['id' => $peserta->id]) }}"
                                        wire:navigate
                                        class="px-3 py-1 rounded text-violet-600 text-xs border border-violet-600 hover:bg-violet-800 hover:text-white transition duration-300 ease-linear">View</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if (auth()->user()->role === 'admin')
        <div class="p-4 bg-white border border-slate-200 shadow-lg rounded-sm">
            <section class="space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Hapus Pelatihan') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Pelatihan akan terhapus dan seluruh data pada peserta dan seluruh absensi akan ikut terhapus.') }}
                    </p>
                </header>

                <x-danger-button onclick="hapusPelatihanJs()">{{ __('Hapus Pelatihan') }}</x-danger-button>
            </section>
        </div>
    @endif
</main>
<script>
    function hapusPelatihanJs() {
        Swal.fire({
            title: 'Apakah Kamu yakin?',
            text: "Kamu akan menghapus Pelatihan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`hapusPelatihan`);
            }
        });
    }
</script>
