<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Silvanix\Wablas\Message;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        $user = Auth::user();
        if ($user->role === 'peserta' && $user->peserta->status === 'nonaktif') {
            $this->dispatch('alert-fail', message: 'Tidak dapat merubah profil');
            return;
        }
        $password_old = $this->current_password;

        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('alert-success', message: 'Password Berhasil Diperbarui.');

        $send = new Message();

        $password_new = $validated['password'];
        if (Auth()->user()->role == 'peserta') {
            $nomor_telpon = Auth::user()->peserta->nomor_telepon;
            $wa = [
                [
                    'phone' => $nomor_telpon,
                    'message' => 'Halo Peserta, Password Anda Telah Diubah Dari ' . $password_old . '<br>' . 'Menjadi ' . $password_new . '<br>' . 'Silahkan Cek Website Kami Dibawah ini' . '<br>' . 'www.kursus.cenari.sch.id',
                ],
            ];
            $send->multiple_text($wa);
        } elseif (Auth()->user()->role == 'instruktur') {
            $nomor_telpon = Auth::user()->instruktur->nomor_telepon;
            $wa = [
                [
                    'phone' => $nomor_telpon,
                    'message' => 'Halo Instruktur, Password Anda Telah Diubah Dari ' . $password_old . '<br>' . 'Menjadi ' . $password_new . '<br>' . 'Silahkan Cek Website Kami Dibawah ini' . '<br>' . 'www.kursus.cenari.sch.id',
                ],
            ];
            $send->multiple_text($wa);
        } else {
            $wa = [
                [
                    'phone' => env('ADMIN_NUMBER'),
                    'message' => 'Halo Admin, Password Anda Telah Diubah Dari ' . $password_old . '<br>' . 'Menjadi ' . $password_new . '<br>' . 'Silahkan Cek Website Kami Dibawah ini' . '<br>' . 'www.kursus.cenari.sch.id',
                ],
            ];
            $send->multiple_text($wa);
        }
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Perbarui Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('Pastikan Menggunakan Password Yang Kuat Untuk Menjaga Keamanan Akunmu') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Sekarang')" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password"
                type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password"
                class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation"
                name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            {{-- <x-action-message class="me-3" on="password-updated">
                {{ __('Tersimpan.') }}
            </x-action-message> --}}
            {{-- @script
                <script>
                    $wire.on('password-updated', () => {
                        success_alert(event.detail.message)
                    });
                </script>
            @endscript --}}
        </div>
    </form>
</section>
