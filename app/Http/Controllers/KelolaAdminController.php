<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KelolaAdminController extends Controller
{
    public function index(): View
    {
        $akun = User::query()
            ->whereIn('status', [User::STATUS_ACTIVE, User::STATUS_DISABLED])
            ->orderByRaw('status = ? desc', [User::STATUS_ACTIVE])
            ->orderByRaw('role = ? desc', [User::ROLE_SUPER_ADMIN])
            ->orderBy('created_at')
            ->get();

        $pending = User::query()
            ->where('status', User::STATUS_PENDING)
            ->orderBy('created_at')
            ->get();

        $statistik = [
            'total' => $akun->count(),
            'aktif' => $akun->where('status', User::STATUS_ACTIVE)->count(),
            'nonaktif' => $akun->where('status', User::STATUS_DISABLED)->count(),
        ];

        return view('kelola-admin.index', compact('akun', 'pending', 'statistik'));
    }

    public function konfirmasi(Request $request, User $user): RedirectResponse
    {
        if ($user->status !== User::STATUS_PENDING) {
            return back()->with('galat', 'Akun ini tidak sedang menunggu konfirmasi.');
        }

        $user->forceFill([
            'status' => User::STATUS_ACTIVE,
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
        ])->save();

        return back()->with('sukses', 'Akun ' . $user->name . ' dikonfirmasi dan sudah bisa login.');
    }

    public function tolak(User $user): RedirectResponse
    {
        if ($user->status !== User::STATUS_PENDING) {
            return back()->with('galat', 'Akun ini tidak sedang menunggu konfirmasi.');
        }

        $user->forceFill(['status' => User::STATUS_REJECTED])->save();

        return back()->with('sukses', 'Pendaftaran ' . $user->name . ' ditolak.');
    }

    public function status(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('galat', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        if ($user->status === User::STATUS_ACTIVE) {
            $user->forceFill(['status' => User::STATUS_DISABLED])->save();

            // Akhiri sesi yang sedang berjalan supaya langsung keluar
            DB::table('sessions')->where('user_id', $user->id)->delete();

            return back()->with('sukses', 'Akun ' . $user->name . ' dinonaktifkan.');
        }

        if ($user->status === User::STATUS_DISABLED) {
            $user->forceFill(['status' => User::STATUS_ACTIVE])->save();

            return back()->with('sukses', 'Akun ' . $user->name . ' diaktifkan kembali.');
        }

        return back()->with('galat', 'Status akun ini tidak bisa diubah dari sini.');
    }
}