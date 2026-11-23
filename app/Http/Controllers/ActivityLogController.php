<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Validasi filter aktivitas.
     */
    private function validatedFilters(Request $request): array
    {
        return $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'actor' => ['nullable', 'string', 'max:255'],
            'action' => ['nullable', 'string', 'max:100'],
        ]);
    }

    /**
     * Membuat query riwayat aktivitas berdasarkan filter.
     */
    private function filteredQuery(array $filters): Builder
    {
        $query = ActivityLog::with('user')
            ->orderByDesc('created_at');

        if (!empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        if (!empty($filters['actor'])) {
            $query->where('actor_name', $filters['actor']);
        }

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        return $query;
    }

    /**
     * Menampilkan daftar riwayat aktivitas.
     */
    public function index(Request $request): View
    {
        $filters = $this->validatedFilters($request);

        $query = $this->filteredQuery($filters);

        $activities = $query->paginate(10)->withQueryString();

        $actors = ActivityLog::whereNotNull('actor_name')
            ->distinct()
            ->orderBy('actor_name')
            ->pluck('actor_name');

        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('activity-logs.index', compact(
            'activities',
            'actors',
            'actions',
            'filters'
        ));
    }

    /**
     * Mengunduh riwayat aktivitas dalam format CSV.
     */
    public function export(Request $request)
    {
        $filters = $this->validatedFilters($request);

        $query = $this->filteredQuery($filters);

        $fileName = 'riwayat-aktivitas-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($query) {

            $output = fopen('php://output', 'w');

            // BOM agar karakter bahasa Indonesia terbaca dengan baik di Excel.
            fwrite($output, "\xEF\xBB\xBF");

            // Header kolom CSV.
            fputcsv($output, [
                'Waktu',
                'Pelaku',
                'Aksi',
                'Data Terkait',
                'Detail Aktivitas',
                'Perubahan',
            ]);

            // Mencegah data yang diawali simbol formula dianggap
            // sebagai rumus ketika dibuka di aplikasi spreadsheet.
            $safeValue = static function ($value): string {
                if (is_array($value) || is_object($value)) {
                    $value = json_encode(
                        $value,
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                    ) ?: '';
                }

                $value = (string) ($value ?? '');

                if (preg_match('/^[\t\r ]*[=+\-@]/u', $value)) {
                    $value = "'" . $value;
                }

                return $value;
            };

            // Mengambil data per 500 baris agar lebih hemat memori.
            $query->chunk(500, function ($activities) use ($output, $safeValue) {

                foreach ($activities as $activity) {

                    $subject = $activity->subject_type
                        ? class_basename($activity->subject_type)
                        : '-';

                    if ($activity->subject_id) {
                        $subject .= ' #' . $activity->subject_id;
                    }

                    $actor = $activity->actor_name
                        ?: ($activity->user?->name ?? 'System');

                    $changes = $activity->properties
                        ? json_encode(
                            $activity->properties,
                            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                        )
                        : '';

                    $actionKey = strtolower(
                        \Illuminate\Support\Str::afterLast($activity->action, '.')
                    );

                    $actionLabels = [
                        'created' => 'Tambah',
                        'create' => 'Tambah',
                        'updated' => 'Ubah',
                        'update' => 'Ubah',
                        'deleted' => 'Hapus',
                        'delete' => 'Hapus',
                        'imported' => 'Import',
                        'import' => 'Import',
                        'exported' => 'Ekspor',
                        'export' => 'Ekspor',
                        'test' => 'Uji Coba',
                        'login' => 'Login',
                        'logout' => 'Logout',
                        'verified' => 'Verifikasi',
                    ];

                    $actionLabel = $actionLabels[$actionKey]
                        ?? ucfirst($actionKey);

                    fputcsv($output, array_map($safeValue, [
                        $activity->created_at?->format('d/m/Y H:i:s'),
                        $actor,
                        $actionLabel,
                        $subject,
                        $activity->description,
                        $changes,
                    ]));
                }
            });

            fclose($output);

        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
