<?php

use App\Models\User;
use App\Models\Instruktur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $alamat = '';
    public string $nomor_telepon = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $id = Auth::user()->id_instruktur;
        $instruktur = Instruktur::findOrFail($id);
        $this->alamat = $instruktur->alamat;
        $this->nomor_telepon = $instruktur->nomor_telepon;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $id = Auth::user()->id_instruktur;
        $data = Instruktur::findOrFail($id);

        $validated = $this->validate([
            'alamat' => ['required', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:255'],
        ]);

        $data->fill($validated);

        $data->save();
        // $this->dispatchBrowserEvent('profile-updated');
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
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('Informasi Pribadi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('Perbarui Informasi Pribadi Anda') }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input wire:model="alamat" id="alamat" name="alamat" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="alamat" />
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div>
            <x-input-label for="nomor_telepon" :value="__('Nomor Telepon')" />
            <x-text-input wire:model="nomor_telepon" id="nomor_telepon" name="nomor_telepon" type="text"
                class="mt-1 block w-full" required autofocus autocomplete="nomor_telepon" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
        </div>
    </form>
</section>
