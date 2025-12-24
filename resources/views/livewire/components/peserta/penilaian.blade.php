<div class="grid lg:grid-cols-3 gap-8">
    <div class="py-4 lg:col-span-2 bg-white border border-slate-200 shadow-lg rounded-sm min-h-80">
        <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                <path
                    d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                </path>
            </svg>
            <span>Nilai Kamu</span>
        </div>
        <hr>
        <div class="py-4 px-6 lg:px-10 grid">
            @if ($nilai)
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
                            @foreach (range(1, 10) as $i)
                                @if ($nilai->{'materi_' . $i})
                                    <tr class="bg-white border-b">
                                        <td scope="row"
                                            class="px-6 py-4 font-medium text-gray-600 whitespace-nowrap">
                                            {{ $nilai->{'materi_' . $i} }}
                                        </td>
                                        <td scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $nilai->{'nilai_' . $i} }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex justify-center py-6 text-slate-600"><span>Kamu belum memiliki
                        nilai</span>
                </div>
            @endif
        </div>
    </div>
    <div class="py-4 bg-white border border-slate-200 shadow-lg rounded-sm max-h-80">
        <div class="flex items-center space-x-2 pb-4 px-4 sm:px-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                <path
                    d="M128,136a8,8,0,0,1-8,8H72a8,8,0,0,1,0-16h48A8,8,0,0,1,128,136Zm-8-40H72a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Zm112,65.47V224A8,8,0,0,1,220,231l-24-13.74L172,231A8,8,0,0,1,160,224V200H40a16,16,0,0,1-16-16V56A16,16,0,0,1,40,40H216a16,16,0,0,1,16,16V86.53a51.88,51.88,0,0,1,0,74.94ZM160,184V161.47A52,52,0,0,1,216,76V56H40V184Zm56-12a51.88,51.88,0,0,1-40,0v38.22l16-9.16a8,8,0,0,1,7.94,0l16,9.16Zm16-48a36,36,0,1,0-36,36A36,36,0,0,0,232,124Z">
                </path>
            </svg>
            <span>Sertifikat</span>
        </div>
        <hr>
        <div class="flex flex-col justify-center items-center py-6">
            @if ($sertifikat->link != null)
                <div class="text-slate-600 px-4">Silahkan Download<span class="text-teal-600 font-bold">
                        Sertifikat</span> Anda
                </div>
            @else
                <div class="text-slate-600 px-4">Sertifikat <span class="text-red-600 font-bold">belum</span> dapat
                    diunduh
                </div>
            @endif
            <div class="mt-10 mb-2">
                <svg class="animate-bounce text-slate-600" xmlns="http://www.w3.org/2000/svg" width="32"
                    height="32" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M205.66,149.66l-72,72a8,8,0,0,1-11.32,0l-72-72a8,8,0,0,1,11.32-11.32L120,196.69V40a8,8,0,0,1,16,0V196.69l58.34-58.35a8,8,0,0,1,11.32,11.32Z">
                    </path>
                </svg>
            </div>
            <div>
                <a href="{{ $sertifikat->link ? asset('storage/sertifikat/' . $sertifikat->link) : '#' }}"
                    {{ $sertifikat->link ? 'download' : '' }}
                    class="flex items-center space-x-2 px-6 py-2 bg-blue-600 text-white shadow-md shadow-blue-300 hover:bg-blue-500 {{ $sertifikat->link ? '' : 'cursor-not-allowed opacity-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M224,144v64a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V144a8,8,0,0,1,16,0v56H208V144a8,8,0,0,1,16,0Zm-101.66,5.66a8,8,0,0,0,11.32,0l40-40a8,8,0,0,0-11.32-11.32L136,124.69V32a8,8,0,0,0-16,0v92.69L93.66,98.34a8,8,0,0,0-11.32,11.32Z">
                        </path>
                    </svg>
                    <span class="text-sm">Unduh</span>
                </a>
            </div>
        </div>
    </div>
</div>
