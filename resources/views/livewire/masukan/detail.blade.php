<div class="bg-white border border-slate-200 shadow-lg rounded-sm">
    <div class="text-slate-700 p-4">
        Masukan dari : {{ $masukan->user->name }} ~ <span class="text-sm font-bold">{{ $masukan->user->role }}</span>
    </div>
    <hr />
    <div class="p-4">
        <form wire:submit="balasan" class="grid gap-4 w-full lg:w-1/2">
            <div>
                <x-input-label class="required" for="subject" :value="__('Subjek')" />
                <x-text-input wire:model="subject" id="subject" name="subject" type="text" class="mt-1 block w-full"
                    readonly />
                <x-input-error class="mt-2" :messages="$errors->get('subject')" />
            </div>
            <div>
                <x-input-label class="required" for="message" :value="__('Pesan')" />
                <textarea name="" id="" rows="6" required wire:model="message" readonly
                    class="w-full mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('message')" />
            </div>
            <div>
                <x-input-label class="required" for="reply" :value="__('Balasan')" />
                <textarea name="" id="" rows="6" required wire:model="reply"
                    class="w-full mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('reply')" />
            </div>
            <div>
                <x-primary-button>{{ __('Kirim') }}</x-primary-button>
            </div>
        </form>
    </div>
</div>
