<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AutoLoginController extends Controller
{
    public function handleLogin(Request $request)
    {
        if (!$request->has('token')) {
            abort(403, 'Token tidak ditemukan.');
        }

        try {
            // 1. Dekripsi payload yang dikirim aplikasi asal
            $data = decrypt($request->query('token'));

            // 2. Validasi waktu kedaluwarsa token (mencegah replay attack)
            if (now()->timestamp > $data['expires']) {
                abort(403, 'Link login sudah kedaluwarsa. Silakan klik ulang dari portal.');
            }

            // 3. Cari user di database target berdasarkan username yang dikirim
            $user = User::where('username', $data['username'])->first();

            if ($user) {
                // 4. Eksekusi login otomatis tanpa password di Laravel
                Auth::login($user);

                // 5. Alihkan user ke halaman dashboard utama Livewire target
                return redirect()->route('dashboard'); // Sesuaikan nama route dashboard Anda
            }

            abort(404, 'User tidak terdaftar di platform ini.');
        } catch (\Exception $e) {
            abort(403, 'Token tidak valid atau manipulasi terdeteksi.');
        }
    }
}