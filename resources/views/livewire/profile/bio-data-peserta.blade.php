<?php

use App\Models\User;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $alamat = '';
    public $nomor_telepon = '';
    public $nik = '';
    public $nisn = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $peserta = Auth::user()->peserta;
        $this->alamat = $peserta->alamat;
        $this->nomor_telepon = $peserta->nomor_telepon;
        $this->nik = $peserta->nik;
        $this->nisn = $peserta->nisn;
        // $this->alamat = Peserta::where('id_peserta', $id)->value('alamat');
        // $this->nomor_telepon = Peserta::where('id_peserta', $id)->value('nomor_telepon');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $peserta = Auth::user()->peserta;
        if ($user->role === 'peserta' && $user->peserta->status === 'nonaktif') {
            $this->dispatch('alert-fail', message: 'Tidak dapat merubah profil');
            return;
        }
        $id = Auth::user()->id_peserta;
        $data = Peserta::findOrFail($id);

        $validated = $this->validate([
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        $data->fill($validated);

        $data->save();

        $this->dispatch('alert-success', message: 'Profil Berhasil Diperbarui');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Pribadi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui Informasi Pribadi Anda') }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-area-input wire:model="alamat" id="alamat" name="alamat" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="alamat" />
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div>
            <x-input-label for="nomor_telepon" :value="__('Nomor Whatsapp')" />
            <x-text-input wire:model="nomor_telepon" id="nomor_telepon" name="nomor_telepon" type="number" readonly
                class="mt-1 block w-full" required autofocus autocomplete="nomor_telepon" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
        </div>
        <div>
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input wire:model="nik" id="nik" name="nik" type="number" readonly
                class="mt-1 block w-full" required autofocus autocomplete="nik" />
            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        </div>
        <div>
            <x-input-label for="nisn" :value="__('NISN/NIS')" />
            <x-text-input wire:model="nisn" id="nisn" name="nisn" type="number" readonly
                class="mt-1 block w-full" required autofocus autocomplete="nisn" />
            <x-input-error class="mt-2" :messages="$errors->get('nisn')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            <x-action-message class="me-3" on="bio-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>
