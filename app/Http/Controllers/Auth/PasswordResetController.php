<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    // Halaman isi email
    public function request(): View
    {
        return view('auth.lupa-password');
    }

    // Kirim tautan reset ke email
    public function email(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // Hanya akun aktif yang dikirimi tautan
        Password::sendResetLink([
            'email' => $request->input('email'),
            'status' => User::STATUS_ACTIVE,
        ]);

        // Pesan sengaja sama, supaya orang luar tidak bisa menebak email mana yang terdaftar
        return back()->with('status', 'Cek kotak masuk email Anda.');
    }

    // Halaman buat password baru (dibuka dari tautan di email)
    public function edit(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Simpan password baru
    public function update(Request $request): RedirectResponse
    {
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password maksimal 72 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset(
            [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $request->input('token'),
                'status' => User::STATUS_ACTIVE,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'must_change_password' => false,
                ])->save();

                // Keluarkan akun ini dari semua sesi yang masih berjalan
                DB::table('sessions')->where('user_id', $user->id)->delete();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Tautan tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.']);
    }
}