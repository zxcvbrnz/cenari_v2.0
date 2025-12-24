<aside>
    <div class="fixed top-0 left-0 z-50 h-screen  w-64 shadow-md transition-transform sm:translate-x-0"
        :class="sidebarOpen ? '' : '-translate-x-full'">
        <div class="absolute top-0 left-0 h-full w-full px-3 py-4 overflow-y-auto bg-white">
            <ul x-data="{ menuOpen: {{ request()->routeIs('admin.create.*') ? 2 : (request()->routeIs('admin.data.*') ? 1 : (request()->routeIs('admin.jadwal.*') ? 3 : 'null')) }} }" class="space-y-2 font-medium">
                <li class="flex items-end">
                    <a href="" class="flex items-center p-2 text-slate-600 font-semibold rounded-lg space-x-3">
                        <img width="150px" src="{{ asset('image/cenari.png') }}" alt="logo">
                    </a>
                    <span class="text-xs text-slate-400">V{{ env('APP_VERSION') }}</span>
                </li>
                <hr>
                <li>
                    <x-side-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" wire:navigate>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                            viewBox="0 0 256 256">
                            <path
                                d="M100,116.43a8,8,0,0,0,4-6.93v-72A8,8,0,0,0,93.34,30,104.06,104.06,0,0,0,25.73,147a8,8,0,0,0,4.52,5.81,7.86,7.86,0,0,0,3.35.74,8,8,0,0,0,4-1.07ZM88,49.62v55.26L40.12,132.51C40,131,40,129.48,40,128A88.12,88.12,0,0,1,88,49.62ZM128,24a8,8,0,0,0-8,8v91.82L41.19,169.73a8,8,0,0,0-2.87,11A104,104,0,1,0,128,24Zm0,192a88.47,88.47,0,0,1-71.49-36.68l75.52-44a8,8,0,0,0,4-6.92V40.36A88,88,0,0,1,128,216Z">
                            </path>
                        </svg>
                        <span class="ml-3">Beranda</span>
                    </x-side-link>
                </li>
                <li class="pt-2">
                    <span class="text-sm text-slate-800">Menu Utama</span>
                </li>
                @if ($role == 'admin')
                    <li>
                        <x-side-link href="{{ route('permohonan') }}" :active="request()->routeIs('permohonan')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M213.66,66.34l-40-40A8,8,0,0,0,168,24H88A16,16,0,0,0,72,40V56H56A16,16,0,0,0,40,72V216a16,16,0,0,0,16,16H168a16,16,0,0,0,16-16V200h16a16,16,0,0,0,16-16V72A8,8,0,0,0,213.66,66.34ZM168,216H56V72h76.69L168,107.31v84.53c0,.06,0,.11,0,.16s0,.1,0,.16V216Zm32-32H184V104a8,8,0,0,0-2.34-5.66l-40-40A8,8,0,0,0,136,56H88V40h76.69L200,75.31Zm-56-32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h48A8,8,0,0,1,144,152Zm0,32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h48A8,8,0,0,1,144,184Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Permohonan</span>
                            @if ($permohonan > 0)
                                <span class="relative flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full p-2 w-full rounded-full bg-sky-400 opacity-75"></span>
                                    <span
                                        class="relative rounded-full text-xs h-3 w-3 p-2 bg-sky-500 text-white flex items-center justify-center">
                                        {{ $permohonan }}
                                    </span>
                                </span>
                            @endif
                        </x-side-link>
                    </li>
                    <li>
                        <x-side-link @click="menuOpen !== 3 ? menuOpen = 3 : menuOpen = null" class="cursor-pointer"
                            :active="request()->routeIs('admin.jadwal.*')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M232,136.66A104.12,104.12,0,1,1,119.34,24,8,8,0,0,1,120.66,40,88.12,88.12,0,1,0,216,135.34,8,8,0,0,1,232,136.66ZM120,72v56a8,8,0,0,0,8,8h56a8,8,0,0,0,0-16H136V72a8,8,0,0,0-16,0Zm40-24a12,12,0,1,0-12-12A12,12,0,0,0,160,48Zm36,24a12,12,0,1,0-12-12A12,12,0,0,0,196,72Zm24,36a12,12,0,1,0-12-12A12,12,0,0,0,220,108Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Jadwal</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                :class="menuOpen === 3 ? 'rotate-90' : ''" class="w-4 h-4 transition duration-300"
                                viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </x-side-link>
                        <ul x-cloak x-show="menuOpen === 3" x-collapse class="space-y-2 py-2">
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.jadwal.private') }}" :active="request()->routeIs('admin.jadwal.private')"
                                    wire:navigate>
                                    <span class="pl-2 py-0.5">Private</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.jadwal.pelatihan') }}"
                                    :active="request()->routeIs('admin.jadwal.pelatihan')" wire:navigate>
                                    <span class="pl-2 py-0.5">Pelatihan</span>
                                </x-side-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <x-side-link @click="menuOpen !== 1 ? menuOpen = 1 : menuOpen = null" class="cursor-pointer"
                            :active="request()->routeIs('admin.data.*')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M152,80a8,8,0,0,1,8-8h88a8,8,0,0,1,0,16H160A8,8,0,0,1,152,80Zm96,40H160a8,8,0,0,0,0,16h88a8,8,0,0,0,0-16Zm0,48H184a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm-96.25,22a8,8,0,0,1-5.76,9.74,7.55,7.55,0,0,1-2,.26,8,8,0,0,1-7.75-6c-6.16-23.94-30.34-42-56.25-42s-50.09,18.05-56.25,42a8,8,0,0,1-15.5-4c5.59-21.71,21.84-39.29,42.46-48a48,48,0,1,1,58.58,0C129.91,150.71,146.16,168.29,151.75,190ZM80,136a32,32,0,1,0-32-32A32,32,0,0,0,80,136Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Daftar Data</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                :class="menuOpen === 1 ? 'rotate-90' : ''" class="w-4 h-4 transition duration-300"
                                viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </x-side-link>
                        <ul x-cloak x-show="menuOpen === 1" x-collapse class="space-y-2 py-2">
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.data.peserta') }}" :active="request()->routeIs('admin.data.peserta') ||
                                    request()->routeIs('admin.data.peserta.*')"
                                    wire:navigate>
                                    <span class="pl-2 py-0.5">Peserta</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.data.instruktur') }}"
                                    :active="request()->routeIs('admin.data.instruktur') ||
                                        request()->routeIs('admin.data.instruktur.*')" wire:navigate>
                                    <span class="pl-2 py-0.5">Instruktur</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.data.pelatihan') }}"
                                    :active="request()->routeIs('admin.data.pelatihan') ||
                                        request()->routeIs('admin.data.pelatihan.*')" wire:navigate>
                                    <span class="pl-2 py-0.5">Pelatihan</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.data.mapel') }}" :active="request()->routeIs('admin.data.mapel') ||
                                    request()->routeIs('admin.data.mapel.*')"
                                    wire:navigate>
                                    <span class="pl-2 py-0.5">Program</span>
                                </x-side-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <x-side-link @click="menuOpen !== 2 ? menuOpen = 2 : menuOpen = null" class="cursor-pointer"
                            :active="request()->routeIs('admin.create.*')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M256,136a8,8,0,0,1-8,8H232v16a8,8,0,0,1-16,0V144H200a8,8,0,0,1,0-16h16V112a8,8,0,0,1,16,0v16h16A8,8,0,0,1,256,136Zm-57.87,58.85a8,8,0,0,1-12.26,10.3C165.75,181.19,138.09,168,108,168s-57.75,13.19-77.87,37.15a8,8,0,0,1-12.25-10.3c14.94-17.78,33.52-30.41,54.17-37.17a68,68,0,1,1,71.9,0C164.6,164.44,183.18,177.07,198.13,194.85ZM108,152a52,52,0,1,0-52-52A52.06,52.06,0,0,0,108,152Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Tambah Data</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                :class="menuOpen === 2 ? 'rotate-90' : ''" class="w-4 h-4 transition duration-300"
                                viewBox="0 0 256 256">
                                <path
                                    d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z">
                                </path>
                            </svg>
                        </x-side-link>
                        <ul x-cloak x-show="menuOpen === 2" x-collapse class="space-y-2 py-2">
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.create.peserta') }}"
                                    :active="request()->routeIs('admin.create.peserta')">
                                    <span class="pl-2 py-0.5">Tambah Peserta</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.create.instruktur') }}"
                                    :active="request()->routeIs('admin.create.instruktur')" wire:navigate>
                                    <span class="pl-2 py-0.5">Tambah Instruktur</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.create.pelatihan') }}"
                                    :active="request()->routeIs('admin.create.pelatihan')" wire:navigate>
                                    <span class="pl-2 py-0.5">Tambah Pelatihan</span>
                                </x-side-link>
                            </li>
                            <li>
                                <x-side-link class="ml-10" href="{{ route('admin.create.mapel') }}" :active="request()->routeIs('admin.create.mapel')"
                                    wire:navigate>
                                    <span class="pl-2 py-0.5">Tambah Program</span>
                                </x-side-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <x-side-link href="{{ route('admin.pembayaran') }}" :active="request()->routeIs('admin.pembayaran')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="w-6 h-6"viewBox="0 0 256 256">
                                <path
                                    d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pembayaran</span>
                        </x-side-link>
                    </li>
                    <li>
                        <x-side-link href="{{ route('admin.sertifikat') }}" :active="request()->routeIs('admin.sertifikat')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M216,40H40A16,16,0,0,0,24,56V216a8,8,0,0,0,11.58,7.16L64,208.94l28.42,14.22a8,8,0,0,0,7.16,0L128,208.94l28.42,14.22a8,8,0,0,0,7.16,0L192,208.94l28.42,14.22A8,8,0,0,0,232,216V56A16,16,0,0,0,216,40Zm0,163.06-20.42-10.22a8,8,0,0,0-7.16,0L160,207.06l-28.42-14.22a8,8,0,0,0-7.16,0L96,207.06,67.58,192.84a8,8,0,0,0-7.16,0L40,203.06V56H216ZM60.42,167.16a8,8,0,0,0,10.74-3.58L76.94,152h38.12l5.78,11.58a8,8,0,1,0,14.32-7.16l-32-64a8,8,0,0,0-14.32,0l-32,64A8,8,0,0,0,60.42,167.16ZM96,113.89,107.06,136H84.94ZM136,128a8,8,0,0,1,8-8h16V104a8,8,0,0,1,16,0v16h16a8,8,0,0,1,0,16H176v16a8,8,0,0,1-16,0V136H144A8,8,0,0,1,136,128Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Sertifikat</span>
                        </x-side-link>
                    </li>
                @endif
                @if ($role == 'instruktur')
                    <li>
                        <x-side-link href="{{ route('instruktur.buat.permohonan') }}" :active="request()->routeIs('instruktur.buat.permohonan')"
                            wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M213.66,66.34l-40-40A8,8,0,0,0,168,24H88A16,16,0,0,0,72,40V56H56A16,16,0,0,0,40,72V216a16,16,0,0,0,16,16H168a16,16,0,0,0,16-16V200h16a16,16,0,0,0,16-16V72A8,8,0,0,0,213.66,66.34ZM168,216H56V72h76.69L168,107.31v84.53c0,.06,0,.11,0,.16s0,.1,0,.16V216Zm32-32H184V104a8,8,0,0,0-2.34-5.66l-40-40A8,8,0,0,0,136,56H88V40h76.69L200,75.31Zm-56-32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h48A8,8,0,0,1,144,152Zm0,32a8,8,0,0,1-8,8H88a8,8,0,0,1,0-16h48A8,8,0,0,1,144,184Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Buat Permohonan</span>
                        </x-side-link>
                    </li>
                    <li>
                        <x-side-link href="{{ route('instruktur.peserta.didik') }}" :active="request()->routeIs('instruktur.peserta.didik') ||
                            request()->routeIs('instruktur.peserta.didik.*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Peserta Didik</span>
                        </x-side-link>
                    </li>
                    <li>
                        <x-side-link href="{{ route('instruktur.pelatihan') }}" :active="request()->routeIs('instruktur.pelatihan') ||
                            request()->routeIs('instruktur.pelatihan.*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Pelatihan</span>
                        </x-side-link>
                    </li>
                    <li>
                        <x-side-link href="{{ route('instruktur.program') }}" :active="request()->routeIs('instruktur.program')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 256 256">
                                <path
                                    d="M208,24H72A32,32,0,0,0,40,56V224a8,8,0,0,0,8,8H192a8,8,0,0,0,0-16H56a16,16,0,0,1,16-16H208a8,8,0,0,0,8-8V32A8,8,0,0,0,208,24ZM120,40h48v72L148.79,97.6a8,8,0,0,0-9.6,0L120,112Zm80,144H72a31.82,31.82,0,0,0-16,4.29V56A16,16,0,0,1,72,40h32v88a8,8,0,0,0,12.8,6.4L144,114l27.21,20.4A8,8,0,0,0,176,136a8,8,0,0,0,8-8V40h16Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Program kamu</span>
                        </x-side-link>
                    </li>
                @endif
                @if ($role == 'peserta')
                    <li>
                        <x-side-link href="{{ route('peserta.absensi') }}" :active="request()->routeIs('peserta.absensi')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M168,152a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,152Zm-8-40H96a8,8,0,0,0,0,16h64a8,8,0,0,0,0-16Zm56-64V216a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V48A16,16,0,0,1,56,32H92.26a47.92,47.92,0,0,1,71.48,0H200A16,16,0,0,1,216,48ZM96,64h64a32,32,0,0,0-64,0ZM200,48H173.25A47.93,47.93,0,0,1,176,64v8a8,8,0,0,1-8,8H88a8,8,0,0,1-8-8V64a47.93,47.93,0,0,1,2.75-16H56V216H200Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Absensi</span>
                        </x-side-link>
                    </li>
                    <li>
                        <x-side-link href="{{ route('peserta.penilaian') }}" :active="request()->routeIs('peserta.penilaian')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                viewBox="0 0 256 256">
                                <path
                                    d="M216,40H40A16,16,0,0,0,24,56V216a8,8,0,0,0,11.58,7.16L64,208.94l28.42,14.22a8,8,0,0,0,7.16,0L128,208.94l28.42,14.22a8,8,0,0,0,7.16,0L192,208.94l28.42,14.22A8,8,0,0,0,232,216V56A16,16,0,0,0,216,40Zm0,163.06-20.42-10.22a8,8,0,0,0-7.16,0L160,207.06l-28.42-14.22a8,8,0,0,0-7.16,0L96,207.06,67.58,192.84a8,8,0,0,0-7.16,0L40,203.06V56H216ZM60.42,167.16a8,8,0,0,0,10.74-3.58L76.94,152h38.12l5.78,11.58a8,8,0,1,0,14.32-7.16l-32-64a8,8,0,0,0-14.32,0l-32,64A8,8,0,0,0,60.42,167.16ZM96,113.89,107.06,136H84.94ZM136,128a8,8,0,0,1,8-8h16V104a8,8,0,0,1,16,0v16h16a8,8,0,0,1,0,16H176v16a8,8,0,0,1-16,0V136H144A8,8,0,0,1,136,128Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Penilaian</span>
                        </x-side-link>
                    </li>
                    @if (auth()->user()->peserta->id_group)
                        <li>
                            <x-side-link href="{{ route('peserta.anggota.pelatihan') }}" :active="request()->routeIs('peserta.anggota.pelatihan')"
                                wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z">
                                    </path>
                                </svg>
                                <span class="flex-1 ms-3 whitespace-nowrap">Anggota Pelatihan</span>
                            </x-side-link>
                        </li>
                    @endif
                @endif
                <li class="pt-2">
                    <span class="text-sm text-slate-800">Menu Spesial</span>
                </li>
                @if (auth()->user()->role == 'instruktur' ||
                        auth()->user()->role == 'admin' ||
                        auth()->user()->peserta->status == 'aktif')
                    <li>
                        <x-side-link href="{{ route('materi') }}" :active="request()->routeIs('materi') || request()->routeIs('materi.*')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="w-6 h-6"viewBox="0 0 256 256">
                                <path
                                    d="M232,48H160a40,40,0,0,0-32,16A40,40,0,0,0,96,48H24a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H96a24,24,0,0,1,24,24,8,8,0,0,0,16,0,24,24,0,0,1,24-24h72a8,8,0,0,0,8-8V56A8,8,0,0,0,232,48ZM96,192H32V64H96a24,24,0,0,1,24,24V200A39.81,39.81,0,0,0,96,192Zm128,0H160a39.81,39.81,0,0,0-24,8V88a24,24,0,0,1,24-24h64ZM160,88h40a8,8,0,0,1,0,16H160a8,8,0,0,1,0-16Zm48,40a8,8,0,0,1-8,8H160a8,8,0,0,1,0-16h40A8,8,0,0,1,208,128Zm0,32a8,8,0,0,1-8,8H160a8,8,0,0,1,0-16h40A8,8,0,0,1,208,160Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Materi Pembelajaran</span>
                        </x-side-link>
                    </li>
                @endif
                <li class="pt-2">
                    <span class="text-sm text-slate-800">Pengaturan</span>
                </li>
                @if ($role == 'admin')
                    <li>
                        <x-side-link href="{{ route('setting.general') }}" :active="request()->routeIs('setting.general')" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="w-6 h-6"viewBox="0 0 256 256">
                                <path
                                    d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z">
                                </path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">General</span>
                        </x-side-link>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div x-show="sidebarOpen" class="fixed top-0 left-0 w-screen h-screen bg-black opacity-30 z-40"
        @click="sidebarOpen = false"></div>

</aside>
