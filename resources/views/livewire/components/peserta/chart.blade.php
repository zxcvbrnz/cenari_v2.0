<div class="grid lg:grid-cols-5 gap-8">
    <div class="lg:col-span-3 bg-white border border-slate-200 shadow-lg rounded-sm py-4">
        <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                <path
                    d="M232,136.66A104.12,104.12,0,1,1,119.34,24,8,8,0,0,1,120.66,40,88.12,88.12,0,1,0,216,135.34,8,8,0,0,1,232,136.66ZM120,72v56a8,8,0,0,0,8,8h56a8,8,0,0,0,0-16H136V72a8,8,0,0,0-16,0Zm40-24a12,12,0,1,0-12-12A12,12,0,0,0,160,48Zm36,24a12,12,0,1,0-12-12A12,12,0,0,0,196,72Zm24,36a12,12,0,1,0-12-12A12,12,0,0,0,220,108Z">
                </path>
            </svg>
            <span>Jadwal Kursus</span>
        </div>
        <hr>
        <div class="py-4 px-6 lg:px-10">
            @if ($jadwalKursus->count() > 0)
                <ul class="list-disc">
                    @foreach ($jadwalKursus as $dat)
                        <li class="text-sm">
                            Kursus pada tanggal <span
                                class="text-teal-600 font-semibold">{{ $dat->waktu_mulai->format('d M Y H:i') }}</span>
                            ~
                            Instruktur: <span class="text-amber-600 font-semibold">{{ $dat->nama_instruktur }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="flex justify-center py-6 px-4 text-slate-600"><span>Kamu tidak memiliki jadwal kursus</span>
                </div>
            @endif
        </div>
    </div>
    <div class="lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm py-4">
        <div class="pb-4 px-4 sm:px-6">Insturktur</div>
        <hr>
        <div class="pt-4 px-4 sm:px-6">
            <div class="flex justify-center">
                <div class="w-36 h-36">
                    <img class="w-full h-full rounded-full object-cover"
                        src="{{ $instruktur->user->image ? asset('storage/image/' . $instruktur->user->image) : asset('image/default.png') }}"
                        alt="profil instruktur">
                </div>
            </div>
            <div class="mt-6 text-sm">
                <div class="flex justify-between py-3">
                    <div>Nama</div>
                    <div class="text-end text-base text-slate-700">{{ $instruktur->user->name }}</div>
                </div>
                <hr>
                <div class="flex justify-between py-3">
                    <div>Jenis Kelamin</div>
                    <div class="text-end text-base text-slate-700">{{ $instruktur->jenis_kelamin }}</div>
                </div>
                <hr>
                <div class="flex justify-between py-3">
                    <div>Alamat</div>
                    <div class="text-end text-base text-slate-700">{{ $instruktur->alamat }}</div>
                </div>
                <hr>
                <div class="flex justify-between py-3">
                    <div>Whatsapp</div>
                    <div class="text-end text-base text-slate-700">
                        <td>
                            @php
                                $nomor = $instruktur->nomor_telepon ?? '0800000000';
                                if (Str::startsWith($nomor, '08')) {
                                    $nomor = '62' . substr($nomor, 1);
                                }
                            @endphp
                            
                            <a target="_blank"
                               href="{{ 'https://wa.me/' . $nomor . '?text=' . urlencode('Hallo Instruktur ' . $instruktur->user->name) }}"
                               class="text-blue-800 hover:text-blue-600 underline font-thin">
                               {{ $instruktur->nomor_telepon ?? '08xxxxxxx' }}
                            </a>
                        </td>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
