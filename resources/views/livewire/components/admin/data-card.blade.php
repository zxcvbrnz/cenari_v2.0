<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
    <div class="w-full h-40">
        <div class="w-full h-full bg-white border border-slate-200 shadow-lg rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span
                    class="text-3xl font-bold {{ $pesertaDidikBaru > 0 ? 'text-green-500' : '' }}">{{ $pesertaDidikBaru }}</span>
            </div>
            <div class="-mt-1 text-slate-600">
                <span class="text-sm">Peserta Didik Baru</span>
                <span class="text-xs block">{{ __('(Belum Melakukan Absensi)') }}</span>
            </div>
        </div>
    </div>
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold {{ $pesertaDidikAktif > 0 ? 'text-green-500' : '' }}">
                    {{ $pesertaDidikAktif }} </span>
            </div>
            <div class="-mt-1 text-slate-600">
                <span class="text-sm">Peserta Didik Aktif</span>
                <span class="text-xs block">{{ __('(Sedang Kursus)') }}</span>

            </div>
        </div>
    </div>
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span
                    class="text-3xl font-bold {{ $pesertaDidikSudahAbsendanNilai > 0 ? 'text-orange-500' : 'text-green-500' }}">
                    {{ $pesertaDidikSudahAbsendanNilai }} </span>
            </div>
            <div class="-mt-1 text-slate-600">
                <span class="text-sm">Peserta Didik Selesai </span>
                <span class="text-xs block">{{ __('(Belum Ada Sertifikat)') }}</span>
            </div>
        </div>
    </div>
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold">
                    {{ $pesertaDidikNonaktif }} </span>
            </div>
            <div class="-mt-1">
                <span class="text-sm text-slate-600">Peserta Didik Selesai</span>
            </div>
        </div>
    </div>
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span
                    class="text-3xl font-bold {{ $pesertaDidikBelumLunas > 0 ? 'text-orange-500' : 'text-green-500' }}">
                    {{ $pesertaDidikBelumLunas }} </span>
            </div>
            <div class="-mt-1">
                <span class="text-sm text-slate-600">Peserta Didik Belum Lunas</span>
            </div>
        </div>
    </div>
    <div class="w-full h-40">
        <div class="w-full h-full bg-white shadow-lg border border-slate-200 rounded-sm px-8 py-6">
            <div class="flex">
                <div class="bg-blue-100 text-blue-600 p-2.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold"> {{ $pelatihan }} </span>
            </div>
            <div class="-mt-1">
                <span class="text-sm text-slate-600">Pelatihan Aktif</span>
            </div>
        </div>
    </div>
</div>
