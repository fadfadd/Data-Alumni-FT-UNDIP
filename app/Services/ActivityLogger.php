<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Mencatat aktivitas pengguna ke database.
     */
    public function log(
        string $action,
        string $description,
        ?Model $subject = null,
        array $properties = []
    ): ActivityLog {

        // Mengambil pengguna yang sedang login
        $user = Auth::user();

        // Mengambil informasi request
        $request = request();

        // Membuat catatan aktivitas
        $activity = new ActivityLog([
            'user_id' => $user?->id,
            'actor_name' => $user?->name ?? 'System',
            'action' => $action,
            'description' => $description,
            'properties' => empty($properties) ? null : $properties,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Menghubungkan aktivitas dengan data terkait
        if ($subject !== null) {
            $activity->subject()->associate($subject);
        }

        // Menyimpan aktivitas ke database
        $activity->save();

        return $activity;
    }
}