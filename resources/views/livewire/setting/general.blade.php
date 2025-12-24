<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="p-4 flex justify-between items-center">
        <div class="text-xl text-slate-600">Pengaturan</div>
    </div>
    <hr>
    <div class="p-6">
        <form wire:submit.prevent="update"> <!-- .prevent untuk mencegah refresh -->
            <div class="text-slate-700 mb-5">Instruktur</div>
            <div class="mb-4 px-2">
                <div class="flex justify-between items-center">
                    <div class="text-sm md:text-md w-4/5 text-slate-700">{{ $setting1->key }}
                    </div>
                    <label
                        class="relative inline-block h-6 w-12 cursor-pointer rounded-full bg-gray-300 transition [-webkit-tap-highlight-color:_transparent] has-[:checked]:bg-teal-600">
                        <input class="peer sr-only" id="AcceptConditions" type="checkbox" wire:model="setting1edit" />
                        <!-- Binding langsung ke $setting1edit -->
                        <span
                            class="absolute inset-y-0 start-0 m-1 size-4 rounded-full bg-gray-300 ring-[6px] ring-inset ring-white transition-all peer-checked:start-6 peer-checked:bg-white peer-checked:ring-transparent"></span>
                    </label>
                </div>
                <span class="text-xs text-slate-400">{{ __('(Minimal 10 dan 12 kali Absen)') }}</span>
            </div>
            <div class="pt-4">
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            </div>
        </form>
    </div>
</div>
