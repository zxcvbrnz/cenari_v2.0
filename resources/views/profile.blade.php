<x-app-layout>
    <div class="py-14">
        <div class="max-w-7xl  space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-sm">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-sm">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            @if (auth()->user()->role == 'peserta')
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-sm">
                    <div class="max-w-xl">
                        <livewire:profile.bio-data-peserta />
                    </div>
                </div>
            @endif

            @if (auth()->user()->role == 'instruktur')
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-sm">
                    <div class="max-w-xl">
                        <livewire:profile.bio-data-instruktur />
                    </div>
                </div>
            @endif

            {{-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-sm">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div> --}}
        </div>
    </div>
</x-app-layout>
