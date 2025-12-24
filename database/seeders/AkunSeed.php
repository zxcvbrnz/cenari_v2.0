<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Menyimpan data user (admin) ke dalam tabel
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'cenarikursus',
            'password' => bcrypt('adm1ncenari'),
            'id_peserta' => null,
            'id_instruktur' => null,
            'role' => 'admin',
        ]);

        // Menyimpan data user (peserta) ke dalam tabel
        DB::table('users')->insert([
            'name' => 'Peserta 1',
            'username' => 'peserta1',
            'password' => bcrypt('peserta1'),
            'id_peserta' => 1,
            'id_instruktur' => null,
            'role' => 'peserta',
        ]);

        DB::table('users')->insert([
            'name' => 'Peserta 2',
            'username' => 'peserta2',
            'password' => bcrypt('peserta2'),
            'id_peserta' => 2,
            'id_instruktur' => null,
            'role' => 'peserta',
        ]);

        // Menyimpan data user (instruktur) ke dalam tabel
        DB::table('users')->insert([
            'name' => 'Instruktur 1',
            'username' => 'instruktur1',
            'password' => bcrypt('instruktur1'),
            'id_peserta' => null,
            'id_instruktur' => 1,
            'role' => 'instruktur',
        ]);

        DB::table('users')->insert([
            'name' => 'Instruktur 2',
            'username' => 'instruktur2',
            'password' => bcrypt('instruktur2'),
            'id_peserta' => null,
            'id_instruktur' => 2,
            'role' => 'instruktur',
        ]);


        DB::table('instrukturs')->insert([
            'alamat' => "Alamat Instruktur 1",
            'nik' => "1234567890123456",
            'qrcode' => "QRCode Instruktur 1",
            'kota' => "Kota Instruktur 1",
            'provinsi' => "Provinsi Instruktur 1",
            'email' => "instruktur1@example.com",
            'ttl' => "01 Januari 1990",
            'jenis_kelamin' => "Laki-laki",
            'pendidikan' => "S1 Teknik Informatika",
            'tanggal_menjadi' => "01 Januari 2010",
            'NUPWK' => "NUPWK Instruktur 1",
            'rekening' => "1234567890",
            'status' => "aktif",
            'status_kerja' => "Pegawai Negeri",
            'pekerjaan' => "Instruktur",
            'nomor_telepon' => "081234567890",
        ]);

        // Menyimpan data instruktur lainnya jika diperlukan
        DB::table('instrukturs')->insert([
            'alamat' => "Alamat Instruktur 2",
            'nik' => "1234567890123457",
            'qrcode' => "QRCode Instruktur 2",
            'kota' => "Kota Instruktur 2",
            'provinsi' => "Provinsi Instruktur 2",
            'email' => "instruktur2@example.com",
            'ttl' => "02 Februari 1991",
            'jenis_kelamin' => "Perempuan",
            'pendidikan' => "S2 Manajemen",
            'tanggal_menjadi' => "01 Februari 2011",
            'NUPWK' => "NUPWK Instruktur 2",
            'rekening' => "0987654321",
            'status' => "aktif",
            'status_kerja' => "Pegawai Swasta",
            'pekerjaan' => "Dosen",
            'nomor_telepon' => "089876543210",
        ]);

        DB::table('pesertas')->insert([
            'id_instruktur' => 2,
            'id_group' => null,
            'id_mapel' => null,
            'tempat_lahir' => "Tempat Lahir Peserta 1",
            'tanggal_lahir' => "01 Januari 2000",
            'nama_ibu' => "Ibu Peserta 1",
            'nama_ayah' => "Ayah Peserta 1",
            'nisn' => "1234567890",
            'nik' => "1234567890123456",
            'jenis_kelamin' => "Laki-laki",
            'pendidikan' => "SMP",
            'agama' => "Islam",
            'kewarganegaraan' => "WNI",
            'penerima_kps' => "Ya",
            'no_kps' => "1234567890123456",
            'layak_pip' => "Ya",
            'alasan_pip' => "Alasan PIP Peserta 1",
            'penerima_kip' => "Ya",
            'no_kip' => "1234567890123456",
            'alamat' => "Alamat Peserta 1",
            'rt' => "001",
            'rw' => "002",
            'kode_pos' => "12345",
            'nama_desa_kelurahan' => "Desa Peserta 1",
            'provinsi' => "Provinsi Peserta 1",
            'kab_kota' => "Kota Peserta 1",
            'kecamatan' => "Kecamatan Peserta 1",
            'jenis_tinggal' => "Rumah Sendiri",
            'alat_transportasi' => "Sepeda Motor",
            'nomor_telepon' => "081234567890",
            'status' => "aktif",
        ]);

        // Menyimpan data peserta lainnya jika diperlukan
        DB::table('pesertas')->insert([
            'id_instruktur' => 1,
            'id_group' => null,
            'id_mapel' => null,
            'tempat_lahir' => "Tempat Lahir Peserta 2",
            'tanggal_lahir' => "02 Februari 2001",
            'nama_ibu' => "Ibu Peserta 2",
            'nama_ayah' => "Ayah Peserta 2",
            'nisn' => "0987654321",
            'nik' => "1234567890123457",
            'jenis_kelamin' => "Perempuan",
            'pendidikan' => "SD",
            'agama' => "Kristen",
            'kewarganegaraan' => "WNI",
            'penerima_kps' => "Tidak",
            'no_kps' => null,
            'layak_pip' => "Tidak",
            'alasan_pip' => null,
            'penerima_kip' => "Tidak",
            'no_kip' => null,
            'alamat' => "Alamat Peserta 2",
            'rt' => "003",
            'rw' => "004",
            'kode_pos' => "54321",
            'nama_desa_kelurahan' => "Desa Peserta 2",
            'provinsi' => "Provinsi Peserta 2",
            'kab_kota' => "Kota Peserta 2",
            'kecamatan' => "Kecamatan Peserta 2",
            'jenis_tinggal' => "Rumah Orang Tua",
            'alat_transportasi' => "Mobil",
            'nomor_telepon' => "089876543210",
            'status' => "nonaktif",
        ]);
    }
}
