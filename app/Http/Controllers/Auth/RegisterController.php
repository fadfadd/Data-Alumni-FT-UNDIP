<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Samakan format email dulu (huruf kecil, tanpa spasi)
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $domain = config('auth.allowed_email_domain');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'ends_with:@' . $domain, 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/'],
        ], [
            'name.required' => 'Username wajib diisi.',
            'name.max' => 'Username maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.ends_with' => "Gunakan email kampus (@{$domain}).",
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password maksimal 72 karakter.',
            'password.regex' => 'Password harus mengandung huruf dan angka.',
        ]);

        // Role dan status SELALU diatur di sini, tidak pernah dari form
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_PENDING,
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Pendaftaran berhasil. Akun Anda menunggu persetujuan admin sebelum bisa digunakan.');
    }
}