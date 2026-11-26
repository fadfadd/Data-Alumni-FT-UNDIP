<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load('approver');

        // Akan diisi dari fitur Activity Log (dikerjakan anggota lain). Sementara kosong.
        // Untuk melihat tampilan seperti desain, buka komentar contoh di bawah (hapus nanti):
        // $aktivitas = collect([
        //     ['jenis' => 'Import', 'keterangan' => 'Import_Alumni_2007.xlsx', 'waktu' => now()],
        //     ['jenis' => 'Verifikasi', 'keterangan' => 'Contoh keterangan aktivitas', 'waktu' => now()->subDay()],
        //     ['jenis' => 'Ekspor', 'keterangan' => 'Laporan Alumni per Program Studi', 'waktu' => now()->subDays(2)],
        // ]);
        $aktivitas = collect();

        return view('profil.index', compact('user', 'aktivitas'));
    }

    public function updateNama(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 100 karakter.',
        ]);

        $request->user()->update(['name' => $data['name']]);

        return back()->with('status_nama', 'Nama berhasil diubah.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'password_lama' => ['required', 'current_password'],
            'password_baru' => [
                'required', 'string', 'min:8', 'max:72',
                'different:password_lama',
                'confirmed',
            ],
        ], [
            'password_lama.required' => 'Password saat ini wajib diisi.',
            'password_lama.current_password' => 'Password saat ini salah.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.max' => 'Password baru maksimal 72 karakter.',
            'password_baru.different' => 'Password baru harus berbeda dari password saat ini.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($data['password_baru']),
            'must_change_password' => false,
        ])->save();

        return back()->with('status_password', 'Password berhasil diubah.');
    }
}