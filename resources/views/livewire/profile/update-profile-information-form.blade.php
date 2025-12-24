<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Component;
use Silvanix\Wablas\Message;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component {
    use WithFileUploads;

    public string $image = '';
    
    #[Validate('image|max:5120')] 
    public $postImage;

    public string $name = '';

    public string $username = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->image = Auth::user()->image ? Auth::user()->image : '';
        $this->name = Auth::user()->name;
        $this->username = Auth::user()->username;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        if ($user->role === 'peserta' && $user->peserta->status === 'nonaktif') {
            $this->dispatch('alert-fail', message: 'Tidak dapat merubah profil');
            $this->name = Auth::user()->name;
            $this->username = Auth::user()->username;
            return;
        }

        $username_old = $user->username;

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'postImage' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $imageName = $this->image;

        if ($this->postImage && $this->postImage->getPathname()) {
            if ($this->image) {
                Storage::disk('public')->delete('image/' . $this->image);
            }

            $imageName = time() . '_' . $this->postImage->getClientOriginalName();

            $this->postImage->StoreAs(path: 'public/image', name: $imageName);

            $this->dispatch('profile-image-updated', image: $imageName);
        }

        // $user->fill($validated);
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->image = $imageName;

        $user->save();

        $this->postImage = null;
        $this->image = $imageName;

        $this->dispatch('profile-updated', name: $user->name);

        $this->dispatch('alert-success', message: 'Profil Berhasil Diperbarui.');

        $send = new Message();

        $username_new = $user->username;
        if (Auth()->user()->role == 'peserta') {
            $nomor_telpon = Auth::user()->peserta->nomor_telepon;
            $wa = [
                [
                    'phone' => $nomor_telpon,
                    'message' => 'Halo Peserta, Username Anda Telah Diubah Dari ' . $username_old . '<br>' . 'Menjadi ' . $username_new . '<br>' . 'Silahkan Cek Website Kami Dibawah ini' . '<br>' . 'www.kursus.cenari.sch.id',
                ],
            ];
            $send->multiple_text($wa);
        } elseif (Auth()->user()->role == 'instruktur') {
            $nomor_telpon = Auth::user()->instruktur->nomor_telepon;
            $wa = [
                [
                    'phone' => $nomor_telpon,
                    'message' => 'Halo Instruktur, Username Anda Telah Diubah Dari ' . $username_old . '<br>' . 'Menjadi ' . $username_new . '<br>' . 'Silahkan Cek Website Kami Dibawah ini' . '<br>' . 'www.kursus.cenari.sch.id',
                ],
            ];
            $send->multiple_text($wa);
        } else {
            $wa = [
                [
                    'phone' => env('ADMIN_NUMBER'),
                    'message' => 'Halo Admin, Username Anda Telah Diubah Dari ' . $username_old . '<br>' . 'Menjadi ' . $username_new . '<br>' . 'Silahkan Cek Website Kami Dibawah ini' . '<br>' . 'www.kursus.cenari.sch.id',
                ],
            ];
            $send->multiple_text($wa);
        }
    }

    public function deleteProfileImage(): void
    {
        $user = Auth::user();

        if ($user->role === 'peserta' && $user->peserta->status === 'nonaktif') {
            $this->dispatch('alert-fail', message: 'Tidak dapat merubah profil');
            return;
        }

        if ($user->image) {
            Storage::disk('public')->delete('image/' . $user->image);
        }

        $user->image = '';
        $user->save();

        $this->image = 'default.png';

        $this->dispatch('image-profile-deleted');

        $this->dispatch('alert-success', message: 'Gambar profil berhasil dihapus.');
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
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui Informasi Mengenai Nama Dan Username Akunmu') }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div class="pb-6"
            x-data="{ uploading: false, progress: 0 }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false; progress = 0;"
            x-on:livewire-upload-error="uploading = false; progress = 0;"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <x-input-label for="image" :value="__('Foto Profil')" />
            <div class="text-red-500 text-xs font-bold mt-2">{{ 'JPEG,PNG or JPG (MAX:5MB)' }}</div>
            @if (!auth()->user()->image)
                <div class="text-orange-500 text-xs font-bold mt-2">{{ '* DISARANKAN AGAR MENAMBAHKAN FOTO PROFIL' }}
                </div>
            @endif
            <div class="relative w-60 h-60">
                @if (auth()->user()->image)
                    <button type="button" wire:click="deleteProfileImage"
                        class="absolute top-0 right-0 bg-red-500 text-white p-2 rounded-full cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                            viewBox="0 0 256 256">
                            <path
                                d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z">
                            </path>
                        </svg>
                    </button>
                @endif
                <label for="image"
                    class="absolute flex items-center justify-center bg-slate-600 opacity-0 hover:opacity-100 bg-opacity-50 w-full h-full rounded-full cursor-pointer group transition-all ease-linear duration-200">
                    <svg class="w-2/4 h-2/4 text-slate-400 opacity-90" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 256 256">
                        <path
                            d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40ZM156,88a12,12,0,1,1-12,12A12,12,0,0,1,156,88Zm60,112H40V160.69l46.34-46.35a8,8,0,0,1,11.32,0h0L165,181.66a8,8,0,0,0,11.32-11.32l-17.66-17.65L173,138.34a8,8,0,0,1,11.31,0L216,170.07V200Z">
                        </path>
                    </svg>
                </label>
                <label for="image" class="absolute bottom-0 right-0 bg-violet-300 p-3 rounded-full cursor-pointer">
                    <svg class="w-10 h-10 text-violet-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 256 256">
                        <path
                            d="M208,56H180.28L166.65,35.56A8,8,0,0,0,160,32H96a8,8,0,0,0-6.65,3.56L75.71,56H48A24,24,0,0,0,24,80V192a24,24,0,0,0,24,24H208a24,24,0,0,0,24-24V80A24,24,0,0,0,208,56Zm8,136a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V80a8,8,0,0,1,8-8H80a8,8,0,0,0,6.66-3.56L100.28,48h55.43l13.63,20.44A8,8,0,0,0,176,72h32a8,8,0,0,1,8,8ZM128,88a44,44,0,1,0,44,44A44.05,44.05,0,0,0,128,88Zm0,72a28,28,0,1,1,28-28A28,28,0,0,1,128,160Z">
                        </path>
                    </svg>
                </label>
                @if ($postImage)
                    <img x-data="{ image: '{{ $postImage->temporaryUrl() }}' }" :src="image" class="w-full h-full rounded-full object-cover">
                @else
                    <img class="w-full h-full rounded-full object-cover" x-data="{ images: '{{ $image ? asset('storage/image/' . $image) : asset('image/default.png') }}' }" :src="images"
                        alt="profile" x-on:image-profile-deleted.window="images = '{{ asset('image/default.png') }}'">
                @endif
            </div>
            <div x-show="uploading" class="text-slate-600">
                <div class="w-full lg:w-1/2 mt-4 bg-gray-200 rounded-sm">
                    <div x-text="progress + '%'" class="rounded-sm text-center text-white" style="font-size: 10px; padding-top: 1px; padding-bottom: 1px; background:#7c3aed;" :style="{ width: progress + '%' }"></div>
                </div>
                <div class="text-sm">Uploading....</div>
            </div>
            <x-file-input type="file" wire:model="postImage" id="image" class="hidden"
                onchange="loadFile(event)" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input wire:model="username" id="username" name="username" type="text" class="mt-1 block w-full"
                required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
        </div>
    </form>
</section>
