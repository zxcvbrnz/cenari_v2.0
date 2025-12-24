<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
    @if(!auth()->user()->peserta->group)
        <div class="w-full h-40">
            <div class="w-full h-full bg-white border border-slate-200 shadow-lg rounded-sm px-8 py-6">
                <div class="flex">
                    <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                            <path
                                d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    @if ($statusPembayaran === 'Lunas')
                        <span class="text-3xl font-bold text-green-600">{{ $statusPembayaran }}</span>
                    @elseif($statusPembayaran === 'Belum Lunas')
                        <span class="text-3xl font-bold text-orange-600">{{ $statusPembayaran }}</span>
                    @elseif($statusPembayaran === 'Belum Bayar')
                        <span class="text-3xl font-bold text-red-600">{{ $statusPembayaran }}</span>
                    @endif
                </div>
                <div class="-mt-1">
                    <span class="text-sm text-slate-600">Status Pembayaran</span>
                </div>
            </div>
        </div>
    @endif
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M231.65,194.55,198.46,36.75a16,16,0,0,0-19-12.39L132.65,34.42a16.08,16.08,0,0,0-12.3,19l33.19,157.8A16,16,0,0,0,169.16,224a16.25,16.25,0,0,0,3.38-.36l46.81-10.06A16.09,16.09,0,0,0,231.65,194.55ZM136,50.15c0-.06,0-.09,0-.09l46.8-10,3.33,15.87L139.33,66Zm6.62,31.47,46.82-10.05,3.34,15.9L146,97.53Zm6.64,31.57,46.82-10.06,13.3,63.24-46.82,10.06ZM216,197.94l-46.8,10-3.33-15.87L212.67,182,216,197.85C216,197.91,216,197.94,216,197.94ZM104,32H56A16,16,0,0,0,40,48V208a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V48A16,16,0,0,0,104,32ZM56,48h48V64H56Zm0,32h48v96H56Zm48,128H56V192h48v16Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold">{{ $absensi }}</span>
            </div>
            <div class="-mt-1">
                <span class="text-sm text-slate-600">Absensi</span>
            </div>
        </div>
    </div>
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 256 256">
                        <path
                            d="M128,136a8,8,0,0,1-8,8H72a8,8,0,0,1,0-16h48A8,8,0,0,1,128,136Zm-8-40H72a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Zm112,65.47V224A8,8,0,0,1,220,231l-24-13.74L172,231A8,8,0,0,1,160,224V200H40a16,16,0,0,1-16-16V56A16,16,0,0,1,40,40H216a16,16,0,0,1,16,16V86.53a51.88,51.88,0,0,1,0,74.94ZM160,184V161.47A52,52,0,0,1,216,76V56H40V184Zm56-12a51.88,51.88,0,0,1-40,0v38.22l16-9.16a8,8,0,0,1,7.94,0l16,9.16Zm16-48a36,36,0,1,0-36,36A36,36,0,0,0,232,124Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                @if ($sertifikat->link != null)
                    <span class="text-3xl font-bold text-green-600">Lulus</span>
                @else
                    <span class="text-3xl font-bold text-orange-600">Pending</span>
                @endif
            </div>
            <div class="-mt-1">
                <span class="text-sm text-slate-600">Sertifikat</span>
            </div>
        </div>
    </div>
</div>
