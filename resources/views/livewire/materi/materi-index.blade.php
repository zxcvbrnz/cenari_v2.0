<div>
    <div class="pb-4 flex justify-between items-center">
        <h1 class="text-xl text-slate-600">Materi Pembelajaran {{ auth()->user()->role === 'peserta' ? 'Untukmu' : '' }}
        </h1>
        @if (auth()->user()->role !== 'peserta')
            <a href="{{ route('materi.create') }}" wire:navigate
                class="px-4 py-2 flex items-center space-x-1 bg-sky-500 text-white hover:bg-sky-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z">
                    </path>
                </svg>
                <span>Buat</span>
            </a>
        @endif
    </div>
    <hr>
    <div class="py-4">
        @if ($materis->count() > 0)
            @foreach ($materis as $materi)
                <div x-data='{isOpen: false}'>
                    <div @click='isOpen = !isOpen'
                        class="w-full flex justify-between items-center py-3 px-8 bg-white border-b border-slate-200 cursor-pointer">
                        <div>
                            <div>
                                <h3 class="text-slate-700 font-bold">{{ $materi->judul }} | <span
                                        class="text-sm text-slate-400 font-thin">{{ $materi->mapel->nama }}</span></h3>
                            </div>
                            <div class="text-slate-500 text-sm">
                                Pembuat :
                                @if (auth()->user()->role === 'peserta')
                                    {{ $materi->instruktur->user->name ?? 'Cenari Education Center' }}
                                @else
                                    {{ $materi->id_instruktur ? ($materi->id_instruktur === $data->id_instruktur ? 'Anda' : $materi->instruktur->user->name) : 'Cenari Education Center' }}
                                @endif
                            </div>
                            <div class="text-slate-400 text-xs">
                                Dibuat pada : {{ $materi->created_at->format('d M Y') }}
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" :class="isOpen ? '-rotate-180' : ''"
                            class="w-6 h-6 transition duration-300" viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                            </path>
                        </svg>
                    </div>
                    <div x-show='isOpen' class="" x-cloak x-collapse>
                        <div class="py-4 px-8">
                            <div>
                                {{ $materi->deskripsi }}
                            </div>
                            <div class="flex space-x-4 mt-2">
                                <a class="flex items-center space-x-2 text-blue-600 hover:text-blue-800 underline"
                                    href="{{ route('materi.detail', ['id' => $materi->id]) }}" wire:navigate>
                                    <span class="text-sm">Lebih lanjut</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                                        viewBox="0 0 256 256">
                                        <path
                                            d="M221.66,133.66l-72,72a8,8,0,0,1-11.32-11.32L196.69,136H40a8,8,0,0,1,0-16H196.69L138.34,61.66a8,8,0,0,1,11.32-11.32l72,72A8,8,0,0,1,221.66,133.66Z">
                                        </path>
                                    </svg>
                                </a>
                                @if (
                                    $data->role === 'admin' ||
                                        ($materi->id_instruktur && $materi->id_instruktur === $data->id_instruktur && $data->role === 'instruktur'))
                                    <button onclick="hapusMateriJs({{ $materi->id }})"
                                        class="text-red-600 hover:text-red-800 underline text-sm">hapus</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex justify-center">
                <span class="text-lg text-slate-500">Tidak Terdapat Materi Pembelajaran</span>
            </div>
        @endif
    </div>
</div>
<script>
    function hapusMateriJs(id) {
        Swal.fire({
            title: 'Apakah Kamu yakin?',
            text: "Kamu akan menghapus pesan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call(`hapusMateri`, (id));
            }
        });
    }
</script>
