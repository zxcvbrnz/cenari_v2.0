<div>
    <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
            <path
                d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-38.34-85.66a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L116,164.69l42.34-42.35A8,8,0,0,1,169.66,122.34Z">
            </path>
        </svg>
        <span>Riwayat Absensi</span>
    </div>
    <hr>
    <div class="py-4 px-6 lg:px-10">
        @if ($absens->count() > 0)
            <ul class="list-disc">
                @foreach ($absens as $record)
                    <li class="text-sm">
                        Jadwal: <span
                            class="text-teal-600 font-semibold">{{ $record->waktu_mulai->format('d M Y H:i') }}</span> ~
                        Absen pada: <span
                            class="text-violet-600 font-semibold">{{ $record->waktu_absen->format('d M Y H:i') }}</span>
                        ~
                        Instruktur: <span class="text-amber-600 font-semibold">{{ $record->nama_instruktur }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="flex justify-center py-6 text-slate-600"><span>Kamu belum melakukan absensi</span></div>
        @endif
    </div>
</div>
