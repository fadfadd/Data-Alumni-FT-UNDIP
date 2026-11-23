<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = Str::lower($credentials['email']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $detik = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$detik} detik.",
            ]);
        }

        if (! Auth::attempt($credentials)) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $user = Auth::user();

        // Status baru dicek SETELAH password benar, supaya orang luar
        // tidak bisa menebak email siapa saja yang terdaftar.
        if (! $user->isActive()) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => $this->pesanStatus($user->status),
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah keluar.');
    }

    private function pesanStatus(string $status): string
    {
        return match ($status) {
            User::STATUS_PENDING => 'Akun Anda masih menunggu persetujuan admin.',
            User::STATUS_REJECTED => 'Pendaftaran akun Anda ditolak. Silakan hubungi admin.',
            User::STATUS_DISABLED => 'Akun Anda dinonaktifkan. Silakan hubungi admin.',
            default => 'Akun ini tidak dapat digunakan.',
        };
    }
}