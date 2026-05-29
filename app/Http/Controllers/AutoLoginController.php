<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AutoLoginController extends Controller
{
    public function handleLogin(Request $request)
    {
        // 1. Pastikan semua parameter yang dibutuhkan ada
        if (!$request->has(['username', 'expires', 'signature'])) {
            abort(403, 'Akses ilegal: Parameter tidak lengkap.');
        }

        $username = $request->query('username');
        $expires = $request->query('expires');
        $receivedSignature = $request->query('signature');

        // 2. Cek apakah link sudah kedaluwarsa (mencegah link dipakai berkali-kali di masa depan)
        if (now()->timestamp > $expires) {
            abort(403, 'Link login sudah kedaluwarsa. Silakan klik ulang dari portal.');
        }

        // 3. Rakit kembali string data sesuai format asli aplikasi pengirim
        $dataToVerify = "username=" . $username . "&expires=" . $expires;

        // 4. Hitung ulang signature menggunakan Secret Key yang sama di .env target
        $secretKey = env('PORTAL_SECRET_KEY');
        $validSignature = hash_hmac('sha256', $dataToVerify, $secretKey);

        // 5. Cocokkan signature kiriman dengan signature kalkulasi lokal (Gunakan hash_equals untuk keamanan)
        if (!hash_equals($validSignature, $receivedSignature)) {
            abort(403, 'Token tidak valid atau manipulasi terdeteksi.');
        }

        // 6. Jika lolos validasi, cari user & lakukan login otomatis
        $user = User::where('username', $username)->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate(); // Sangat penting agar Livewire mendeteksi session baru

            return redirect()->route('dashboard'); // Sesuaikan nama route dashboard Livewire Anda
        }

        abort(404, 'User tidak ditemukan di sistem platform kursus.');
    }
}