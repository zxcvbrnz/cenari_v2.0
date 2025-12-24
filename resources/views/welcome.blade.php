<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cenari Education Center</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans max-w-7xl mx-auto px-6 py-10">
    <div class="grid lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-1 space-y-6">
            <div
                class="relative overflow-hidden bg-white rounded-3xl shadow-[0_20px_50px_rgba(124,58,237,0.1)] border border-slate-100 group">
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-violet-600 to-fuchsia-500"></div>

                <div class="relative pt-16 pb-8 flex flex-col items-center">
                    <div class="relative">
                        <div
                            class="absolute inset-0 bg-violet-200 rounded-full blur-xl opacity-40 group-hover:opacity-70 transition duration-500">
                        </div>

                        @if ($peserta->user->image)
                            {{-- Jika ada foto di database dan filenya eksis di storage --}}
                            <img src="{{ asset('storage/image/' . $peserta->user->image) }}"
                                alt="{{ $peserta->user->name }}"
                                class="relative w-36 h-36 object-cover rounded-full border-4 border-white shadow-2xl">
                        @else
                            {{-- Jika tidak ada foto, gunakan UI Avatars sebagai fallback --}}
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($peserta->user->name) }}&background=7c3aed&color=fff&size=200"
                                alt="{{ $peserta->user->name }}"
                                class="relative w-36 h-36 object-cover rounded-full border-4 border-white shadow-2xl">
                        @endif
                    </div>

                    <div class="mt-6 text-center px-4">
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $peserta->user->name }}</h2>
                        {{-- <p class="text-violet-600 font-medium text-sm">PESERTA DIDIK</p> --}}

                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span
                                class="px-4 py-1.5 rounded-full bg-violet-50 text-violet-700 text-[11px] font-bold uppercase tracking-wider border border-violet-100">Peserta
                                Didik</span>
                            <span
                                class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold uppercase tracking-wider border border-emerald-100">Lulus</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 border-t border-slate-50 bg-slate-50/50">
                    <div class="p-4 text-center border-r border-slate-100">
                        <span
                            class="block text-[10px] text-slate-400 uppercase font-bold tracking-widest">Kehadiran</span>
                        <span class="text-lg font-black text-slate-700">{{ $peserta->riwayatAbsensi->count() }}x</span>
                    </div>
                    <div class="p-4 text-center">
                        <span class="block text-[10px] text-slate-400 uppercase font-bold tracking-widest">Nilai
                            Rata</span>
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
                            @endif
                        @endforeach

                        @if ($jumlahMateri > 0)
                            <?php $rataRata = $totalNilai / $jumlahMateri; ?>

                            <span class="text-lg font-black text-slate-700">{{ number_format($rataRata, 2) }}</span>
                        @else
                            <span class="text-lg font-black text-slate-700">0</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div
                class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(124,58,237,0.1)] border border-slate-100 h-full flex flex-col">
                <div class="p-8 flex-grow">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-800">Detail Akademik</h3>
                            <p class="text-sm text-slate-400">Informasi resmi peserta kursus Cenari</p>
                        </div>
                        <div
                            class="h-12 w-12 bg-violet-100 rounded-2xl flex items-center justify-center text-violet-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-x-10 gap-y-8">
                        <div class="group">
                            <label
                                class="block text-[10px] font-black text-violet-400 uppercase tracking-[0.2em] mb-2">No.
                                Sertifikat</label>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-50 rounded-lg group-hover:bg-violet-50 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-violet-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-bold text-slate-700">{{ $peserta->sertifikat->nomor_sertifikat ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="group">
                            <label
                                class="block text-[10px] font-black text-violet-400 uppercase tracking-[0.2em] mb-2">Tempat,
                                Tanggal Lahir</label>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-slate-50 rounded-lg group-hover:bg-violet-50 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-violet-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700">{{ $peserta->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="group md:col-span-2">
                            <label
                                class="block text-[10px] font-black text-violet-400 uppercase tracking-[0.2em] mb-2">Program
                                {{ $peserta->id_group ? 'Pelatihan' : 'Kursus' }}</label>
                            <div
                                class="flex items-center gap-3 p-4 bg-violet-50/50 rounded-2xl border border-violet-100">
                                <div class="p-3 bg-white rounded-xl shadow-sm">
                                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <span
                                    class="text-base font-extrabold text-slate-800 uppercase italic">{{ $peserta->id_group ? $peserta->group->mapel->nama . ', ' . $peserta->group->nama : $peserta->mapel->nama }}</span>
                            </div>
                        </div>

                        <div class="group md:col-span-2">
                            <label
                                class="block text-[10px] font-black text-violet-400 uppercase tracking-[0.2em] mb-2">Tanggal
                                Berakhir {{ $peserta->id_group ? 'Pelatihan' : 'Kursus' }}</label>
                            <div
                                class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ $peserta->riwayatAbsensi->last()?->waktu_mulai?->translatedFormat('d F Y') ?? '-' }}
                                    </span>
                                </div>
                                {{-- <span
                                    class="text-[10px] font-black text-rose-600 bg-rose-50 px-3 py-1 rounded-lg uppercase animate-pulse">Berakhir
                                    dalam 6 hari</span> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50/50 rounded-b-3xl border-t border-slate-100">
                    <div
                        class="flex items-center justify-between text-[10px] font-bold text-slate-400 tracking-widest uppercase">
                        <span>Cenari Learning Management System</span>
                        <span>v2.0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
