<div class="grid lg:grid-cols-3 gap-8">
    <div class="flex justify-center items-center bg-white border border-slate-200 shadow-lg rounded-sm p-6 py-8">
        <div class="">
            {!! $qrcode !!}
        </div>
    </div>
    <div class="py-4 lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm">
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
            @if ($jadwalCount > 0)
                <ul class="list-disc">
                    @foreach ($jadwalGroup as $dat)
                        <li class="text-sm"> Jadwal
                            <span class="font-bold text-slate-800"><span class="text-sky-600">Pelatihan</span>
                                {{ $dat->nama_group }}</span>
                            pada
                            <span class="font-bold text-violet-600">{{ $dat->waktu_mulai->format('d M Y H:i') }}</span>
                            ~ {{ $dat->keterangan }}
                        </li>
                    @endforeach
                    @foreach ($jadwalPrivate as $dat)
                        <li class="text-sm"> Jadwal
                            <span class="font-bold text-slate-800"><span class="text-teal-600">Private</span>
                                {{ $dat->nama_peserta }}</span>
                            pada
                            <span class="font-bold text-violet-600">{{ $dat->waktu_mulai->format('d M Y H:i') }}</span>
                            ~ {{ $dat->keterangan }}
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="flex justify-center py-6 px-4 text-slate-600"><span>Kamu tidak memiliki permohonan
                        kursus private</span>
                </div>
            @endif
        </div>
    </div>
</div>
