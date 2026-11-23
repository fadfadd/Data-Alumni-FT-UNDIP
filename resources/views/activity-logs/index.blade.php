
@extends('layouts.app')

@section('title', 'Riwayat Aktivitas | SIGMA Alumni')
@section('breadcrumb', 'Riwayat Aktivitas')

@push('styles')
<style>
    .activity-page {
        width: 100%;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 25px;
    }

    .activity-title {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 8px;
    }

    .activity-title h1 {
        color: #172b4d;
        font-size: 27px;
    }

    .locked-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0f3f8;
        color: #65748b;
        border-radius: 20px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .activity-subtitle {
        color: #778196;
        font-size: 14px;
        line-height: 1.6;
    }

    .activity-card {
        background: white;
        border: 1px solid #e6ebf2;
        border-radius: 13px;
        margin-bottom: 18px;
        box-shadow: 0 3px 12px rgba(22, 40, 70, 0.025);
    }

    .activity-filter-body {
        padding: 18px 20px;
    }

    .activity-filter-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .activity-field label {
        display: block;
        margin-bottom: 8px;
        color: #68768d;
        font-size: 11px;
        font-weight: 600;
    }

    .activity-control {
        width: 100%;
        height: 40px;
        padding: 0 11px;
        border: 1px solid #dfe5ee;
        border-radius: 8px;
        background: white;
        color: #35435b;
        font-size: 13px;
        outline: none;
    }

    .activity-control:focus {
        border-color: #5279b3;
        box-shadow: 0 0 0 3px rgba(82, 121, 179, 0.09);
    }

    .activity-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .activity-table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
    }

    .activity-table thead {
        background: #f8f9fc;
    }

    .activity-table th {
        padding: 15px 17px;
        text-align: left;
        color: #7b879c;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .activity-table td {
        padding: 15px 17px;
        border-top: 1px solid #edf0f5;
        color: #53627a;
        font-size: 12px;
        line-height: 1.6;
        vertical-align: middle;
    }

    .activity-table tbody tr:hover {
        background: #fafbfe;
    }

    .activity-date {
        color: #77849a;
        white-space: nowrap;
    }

    .activity-actor {
        color: #253650;
        font-weight: 600;
        white-space: nowrap;
    }

    .activity-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-create {
        background: #e6f4ec;
        color: #25804c;
    }

    .badge-update {
        background: #e8effb;
        color: #426aab;
    }

    .badge-delete {
        background: #fbe9e9;
        color: #c34d4d;
    }

    .badge-import {
        background: #eee9fb;
        color: #7655ae;
    }

    .badge-export {
        background: #e4f3f2;
        color: #25817b;
    }

    .badge-default {
        background: #edf0f5;
        color: #647188;
    }

    .activity-subject {
        color: #344761;
        font-weight: 500;
        min-width: 140px;
    }

    .activity-description {
        color: #718098;
        min-width: 190px;
    }

    .activity-change {
        min-width: 150px;
    }

    .change-value {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 5px;
        background: #e8f3ed;
        color: #34815a;
        font-size: 10px;
        margin: 2px;
    }

    .empty-activity {
        padding: 45px 20px !important;
        text-align: center;
        color: #8591a4 !important;
    }

    .empty-activity strong {
        display: block;
        color: #3c4c65;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .activity-footer {
        padding: 15px 18px;
        border-top: 1px solid #edf0f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        color: #7c879a;
        font-size: 11px;
    }

    .activity-pagination {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .activity-pagination a,
    .activity-pagination span {
        padding: 7px 11px;
        border: 1px solid #dfe5ed;
        border-radius: 7px;
        text-decoration: none;
        color: #52617a;
        background: white;
    }

    .activity-pagination .current {
        background: #193b75;
        color: white;
        border-color: #193b75;
    }

    .activity-pagination .disabled {
        color: #b2bdcb;
        background: #f8f9fb;
    }

    .activity-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
    }

    .activity-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 14px;
        border: none;
        border-radius: 7px;
        cursor: pointer;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .activity-btn-primary {
        background: #193b75;
        color: white;
    }

    .activity-btn-reset {
        background: #edf0f5;
        color: #506078;
    }

    .activity-btn-export {
    background: white;
    color: #193b75;
    border: 1px solid #dfe5ed;
    white-space: nowrap;
    transition: 0.2s;
    }

    .activity-btn-export:hover {
        background: #193b75;
        color: white;
    }

    @media (max-width: 900px) {
        .activity-filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .activity-header {
            flex-direction: column;
        }

        .activity-filter-grid {
            grid-template-columns: 1fr;
        }

        .activity-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

<div class="activity-page">

    <!-- JUDUL HALAMAN -->
    <div class="activity-header">
        <div>
            <div class="activity-title">
                <h1>Riwayat Aktivitas</h1>

                <span class="locked-badge">
                    Terkunci
                </span>
            </div>

            <p class="activity-subtitle">
                Catatan setiap tindakan pada aplikasi.
                Catatan ini tidak dapat diubah atau dihapus siapa pun.
            </p>
        </div>
        <a
            href="{{ route('activity-logs.export', request()->only(['from', 'to', 'actor', 'action'])) }}"
            class="activity-btn activity-btn-export"
        >
            Ekspor
        </a>
    </div>

    <!-- FILTER -->
    <div class="activity-card">
        <div class="activity-filter-body">

            <form method="GET" action="{{ route('activity-logs.index') }}">

                <div class="activity-filter-grid">

                    <div class="activity-field">
                        <label for="from">Dari tanggal</label>

                        <input
                            type="date"
                            id="from"
                            name="from"
                            class="activity-control"
                            value="{{ $filters['from'] ?? '' }}"
                        >
                    </div>

                    <div class="activity-field">
                        <label for="to">Sampai tanggal</label>

                        <input
                            type="date"
                            id="to"
                            name="to"
                            class="activity-control"
                            value="{{ $filters['to'] ?? '' }}"
                        >
                    </div>

                    <div class="activity-field">
                        <label for="actor">Pelaku</label>

                        <select
                            name="actor"
                            id="actor"
                            class="activity-control"
                        >
                            <option value="">Semua pelaku</option>

                            @foreach ($actors as $actor)
                                <option
                                    value="{{ $actor }}"
                                    @selected(($filters['actor'] ?? '') === $actor)
                                >
                                    {{ $actor }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="activity-field">
                        <label for="action">Jenis aksi</label>

                        <select
                            name="action"
                            id="action"
                            class="activity-control"
                        >
                            <option value="">Semua aksi</option>

                            @foreach ($actions as $action)
                                <option
                                    value="{{ $action }}"
                                    @selected(($filters['action'] ?? '') === $action)
                                >
                                    {{ $action }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="activity-filter-actions">
                    <button type="submit" class="activity-btn activity-btn-primary">
                        Terapkan Filter
                    </button>

                    <a
                        href="{{ route('activity-logs.index') }}"
                        class="activity-btn activity-btn-reset"
                    >
                        Reset
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- TABEL RIWAYAT AKTIVITAS -->
    <div class="activity-card">

        <div class="activity-table-wrapper">

            <table class="activity-table">

                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pelaku</th>
                        <th>Aksi</th>
                        <th>Data terkait</th>
                        <th>Detail</th>
                        <th>Perubahan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($activities as $activity)

                        @php
                            $actionKey = strtolower(
                                \Illuminate\Support\Str::afterLast(
                                    $activity->action,
                                    '.'
                                )
                            );

                            $actionLabels = [
                                'created' => 'Tambah',
                                'updated' => 'Ubah',
                                'deleted' => 'Hapus',
                                'imported' => 'Import',
                                'exported' => 'Ekspor',
                                'test' => 'Uji Coba',
                            ];

                            $badgeClasses = [
                                'created' => 'badge-create',
                                'updated' => 'badge-update',
                                'deleted' => 'badge-delete',
                                'imported' => 'badge-import',
                                'exported' => 'badge-export',
                            ];

                            $actionLabel = $actionLabels[$actionKey]
                                ?? ucfirst($actionKey);

                            $badgeClass = $badgeClasses[$actionKey]
                                ?? 'badge-default';

                            $subjectLabel = $activity->subject_type
                                ? class_basename($activity->subject_type)
                                : '-';

                            if ($activity->subject_id) {
                                $subjectLabel .= ' #' . $activity->subject_id;
                            }

                            $actorName = $activity->actor_name
                                ?: ($activity->user?->name ?? 'System');

                            $changes = $activity->properties;
                        @endphp

                        <tr>

                            <td class="activity-date">
                                {{ $activity->created_at?->format('d M Y • H:i') }}
                            </td>

                            <td class="activity-actor">
                                {{ $actorName }}
                            </td>

                            <td>
                                <span class="activity-badge {{ $badgeClass }}">
                                    {{ $actionLabel }}
                                </span>
                            </td>

                            <td class="activity-subject">
                                {{ $subjectLabel }}
                            </td>

                            <td class="activity-description">
                                {{ $activity->description }}
                            </td>

                            <td class="activity-change">
                                @if (is_array($changes) && isset($changes['old'], $changes['new']))
                                    <span class="change-value">
                                        {{ is_scalar($changes['old']) ? $changes['old'] : 'Data sebelumnya' }}
                                    </span>

                                    →
                                    
                                    <span class="change-value">
                                        {{ is_scalar($changes['new']) ? $changes['new'] : 'Data terbaru' }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-activity">
                                <strong>Belum ada aktivitas</strong>
                                Riwayat aktivitas akan muncul setelah admin
                                melakukan tindakan pada aplikasi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        <div class="activity-footer">

            <div>
                Menampilkan
                {{ $activities->firstItem() ?? 0 }}
                sampai
                {{ $activities->lastItem() ?? 0 }}
                dari
                {{ $activities->total() }}
                aktivitas
            </div>

            <div class="activity-pagination">

                @if ($activities->onFirstPage())
                    <span class="disabled">Sebelumnya</span>
                @else
                    <a href="{{ $activities->previousPageUrl() }}">
                        Sebelumnya
                    </a>
                @endif

                <span class="current">
                    {{ $activities->currentPage() }}
                    / {{ max($activities->lastPage(), 1) }}
                </span>

                @if ($activities->hasMorePages())
                    <a href="{{ $activities->nextPageUrl() }}">
                        Selanjutnya
                    </a>
                @else
                    <span class="disabled">Selanjutnya</span>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection
