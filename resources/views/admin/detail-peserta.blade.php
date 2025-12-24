<x-app-layout>
    <main class="py-14 lg:py-20">
        <livewire:components.admin.update-peserta :peserta="$peserta" />
        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <div class="py-4 bg-white border border-slate-200 shadow-lg rounded-sm min-h-80">
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
                    @if ($peserta->riwayatAbsensi->count() > 0)
                        <ul class="list-disc">
                            @foreach ($peserta->riwayatAbsensi as $record)
                                <li class="text-sm">
                                    Jadwal: <span
                                        class="text-teal-600 font-semibold">{{ $record->waktu_mulai->format('d M Y h:i') }}</span>
                                    ~
                                    Absen pada: <span
                                        class="text-violet-600 font-semibold">{{ $record->waktu_absen->format('d M Y h:i') }}</span>
                                    ~
                                    Instruktur: <span
                                        class="text-amber-600 font-semibold">{{ $record->nama_instruktur }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="flex justify-center py-6 text-slate-600"><span>Peserta belum melakukan
                                absensi</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="py-4 bg-white border border-slate-200 shadow-lg rounded-sm">
                <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                        </path>
                    </svg>
                    <span>Nilai</span>
                </div>
                <hr>
                <div class="py-4 px-6 lg:px-10 grid">
                    @if (auth()->user()->role === 'admin')
                        @if ($peserta->nilai)
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 w-4/5">
                                                Materi
                                            </th>
                                            <th scope="col" class="px-6 py-3 w-1/5">
                                                Nilai
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                            $totalNilai = 0;
                                            $jumlahMateri = 0;
                                        ?>
                                        @foreach (range(1, 10) as $i)
                                            @if (isset($peserta->nilai->{'materi_' . $i}) && isset($peserta->nilai->{'nilai_' . $i}))
                                                <?php
                                                    $totalNilai += $peserta->nilai->{'nilai_' . $i};
                                                    $jumlahMateri++;
                                                ?>
                                                <tr class="bg-white border-b">
                                                    <th scope="row" class="px-6 py-4 font-medium text-gray-600 whitespace-nowrap">
                                                        {{ $peserta->nilai->{'materi_' . $i} }}
                                                    </th>
                                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                        {{ $peserta->nilai->{'nilai_' . $i} }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        
                                        @if ($jumlahMateri > 0)
                                            <?php $rataRata = $totalNilai / $jumlahMateri; ?>
                                            <tr class="bg-gray-200 font-bold">
                                                <th scope="row" class="px-6 py-4">Rata-rata</th>
                                                <td class="px-6 py-4">{{ number_format($rataRata, 2) }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="flex justify-center py-6 text-slate-600"><span>Peserta belum memiliki
                                    nilai</span>
                            </div>
                        @endif
                    @elseif(auth()->user()->role === 'instruktur')
                        <livewire:components.instruktur.create-nilai-peserta :peserta="$peserta" />
                    @endif
                </div>
            </div>
        </div>
        @if (auth()->user()->role === 'admin')
            <livewire:components.admin.hapus-peserta :peserta="$peserta" />
        @endif
    </main>
</x-app-layout>
