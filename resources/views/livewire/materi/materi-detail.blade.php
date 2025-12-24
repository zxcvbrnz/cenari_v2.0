<div>
    <div class="flex justify-between items-center pb-4">
        <div>
            <h1 class="text-xl font-bold text-slate-600">{{ $materi->judul }} | <span
                    class="text-base text-slate-400 font-thin">{{ $materi->mapel->nama }}</span></h1>
            <span class="text-slate-500 text-sm">
                Dibuat oleh :
                @if (auth()->user()->role === 'peserta')
                    {{ $materi->instruktur->user->name ?? 'Cenari Education Center' }}
                @else
                    {{ $materi->id_instruktur ? ($materi->id_instruktur === auth()->user()->id_instruktur ? 'Anda' : $materi->instruktur->user->name) : 'Cenari Education Center' }}
                @endif
            </span>
        </div>
        <div>
            @if (auth()->user()->role === 'admin' ||
                    ($materi->id_instruktur && $materi->id_instruktur === auth()->user()->id_instruktur))
                <a href="{{ route('materi.edit', ['id' => $materi->id]) }}" wire:navigate
                    class="px-4 py-2 flex items-center space-x-1 bg-sky-500 text-white hover:bg-sky-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.68,147.31,64l24-24L216,84.68Z">
                        </path>
                    </svg>
                    <span>Edit</span>
                </a>
            @endif
        </div>
    </div>
    <hr class="border-t border-slate-600">
    <div class="py-6">
        @if ($materi->link)
            <div class="w-full lg:w-1/2">
                <div class="aspect-w-16 aspect-h-9">
                    <iframe src="https://www.youtube.com/embed/{{ $materi->link }}" frameborder="0"
                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        @endif
        <div class="pt-10">
            @if ($materi->file)
                <span class="text-sm font-thin text-slate-500">{{ $materi->file }}</span>
                <div class="flex">
                    <a href="{{ asset('storage/files/' . $materi->file) }}" download
                        class="flex items-center space-x-2 px-6 py-2 bg-blue-600 text-white shadow-md shadow-blue-300 hover:bg-blue-500 disabled:bg-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                            viewBox="0 0 256 256">
                            <path
                                d="M224,144v64a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V144a8,8,0,0,1,16,0v56H208V144a8,8,0,0,1,16,0Zm-101.66,5.66a8,8,0,0,0,11.32,0l40-40a8,8,0,0,0-11.32-11.32L136,124.69V32a8,8,0,0,0-16,0v92.69L93.66,98.34a8,8,0,0,0-11.32,11.32Z">
                            </path>
                        </svg>
                        <span class="text-sm">Unduh file</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="py-4">
        <div class="mb-6">
            <p>{{ $materi->deskripsi }}</p>
        </div>
        <div class="w-full">
            <pre class="font-sans w-full lg:w-1/2">{{ $materi->artikel }}</pre>
        </div>
    </div>
</div>
