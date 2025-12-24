<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public $data;
    public function mount(): void
    {
        $this->data = auth()->user();
    }
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>

<nav x-data="{ open: false }" class="fixed w-full z-10 py-1 bg-white border-b shadow-md border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <button @click="sidebarOpen = true" type="button"
                        class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="flex items-center ms-6 space-x-2 md:space-x-6">
                <a href="{{ route('masukan') }}" wire:navigate
                    class="relative text-slate-700 bg-gray-100 p-2 rounded-full shadow-inner hover:text-blue-800">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M102,152a6,6,0,0,1-6,6H56a6,6,0,0,1,0-12H96A6,6,0,0,1,102,152Zm136-36v60a14,14,0,0,1-14,14H134v34a6,6,0,0,1-12,0V190H32a14,14,0,0,1-14-14V116A58.07,58.07,0,0,1,76,58h78V24a6,6,0,0,1,6-6h32a6,6,0,0,1,0,12H166V58h14A58.07,58.07,0,0,1,238,116ZM122,178V116a46,46,0,0,0-92,0v60a2,2,0,0,0,2,2Zm104-62a46.06,46.06,0,0,0-46-46H166v74a6,6,0,0,1-12,0V70H111.29A57.93,57.93,0,0,1,134,116v62h90a2,2,0,0,0,2-2Z">
                        </path>
                    </svg>
                    <span class="absolute top-0 start-7 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full ">
                        <span
                            class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75 animate-ping"></span>
                    </span>
                </a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-normal rounded-md text-gray-700 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="hidden md:flex">
                                <div class="flex flex-col justify-end text-end">
                                    <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                        x-on:profile-updated.window="name = $event.detail.name">
                                    </div>
                                    <span class="text-xs text-gray-500 font-thin">
                                        @if ($data->role === 'admin')
                                            Admin
                                        @endif
                                        @if ($data->role === 'instruktur')
                                            Instruktur
                                        @endif
                                        @if ($data->role === 'peserta')
                                            @if ($data->peserta->id_group)
                                                {{ $data->peserta->group->mapel->nama }}
                                            @else
                                                {{ $data->peserta->mapel->nama }}
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center ms-4">
                                <div class="relative" x-data="{ image: '{{ auth()->user()->image ? asset('storage/image/' . auth()->user()->image) : asset('image/default.png') }}' }" x-init="$watch('image', value => console.log('Image updated:', value))">
                                    <img class="w-10 h-10 object-cover rounded-full" :src="image"
                                        alt="profile"
                                        x-on:profile-image-updated.window="image = '{{ asset('storage/image/') }}/' + $event.detail.image"
                                        x-on:image-profile-deleted.window="image = '{{ asset('image/default.png') }}'">
                                    <template x-if="image === '{{ asset('image/default.png') }}'">
                                        <span
                                            class="absolute top-0 start-7 w-2.5 h-2.5 bg-orange-500 border-2 border-white rounded-full ">
                                            <span
                                                class="absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75 animate-ping"></span>
                                        </span>
                                    </template>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ms-3" fill="currentColor"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            <span class="relative">
                                {{ __('Profile') }}
                                @if (!auth()->user()->image)
                                    <span
                                        class="absolute top-0 -end-2 w-2 h-2 bg-orange-500 border-2 border-white rounded-full ">
                                        <span
                                            class="absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75 animate-ping"></span>
                                    </span>
                                @endif
                            </span>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
