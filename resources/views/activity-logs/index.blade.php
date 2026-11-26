
@extends('layouts.app')

@section('title', 'Riwayat Aktivitas | SIGMA Alumni')

@section('breadcrumb', 'Riwayat Aktivitas')

@push('styles')
<style>
    .activity-page {
        width: 100%;
        color: #172b4d;
    }

    /* HEADER */
    .activity-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .activity-heading h1 {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin: 0 0 9px;
        color: #173966;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .locked-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 20px;
        background: #f1f3f6;
        color: #7b8798;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0;
    }

    .activity-subtitle {
        max-width: 570px;
        margin: 0;
        color: #9299a5;
        font-size: 14px;
        line-height: 1.6;
    }

    .activity-btn-export {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 112px;
        padding: 12px 18px;
        margin-top: 48px;
        border: none;
        border-radius: 15px;
        background: #fff;
        color: #173966;
        box-shadow: 0 4px 14px rgba(0, 0, 0, .14);
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .activity-btn-export:hover {
        background: #edf3fb;
        color: #173966;
        transform: translateY(-2px);
    }

    /* FILTER */
    .activity-filter {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 32px;
        padding: 17px 23px;
        margin-bottom: 13px;
        border-radius: 16px;
        background: linear-gradient(110deg, #102d58, #1d4d82);
        box-shadow: 0 3px 6px rgba(15, 40, 75, .13);
    }

    .activity-field label {
        display: block;
        margin-bottom: 7px;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
    }

    .activity-control {
        width: 100%;
        height: 39px;
        padding: 0 12px;
        border: 1px solid transparent;
        border-radius: 9px;
        outline: none;
        background: #fff;
        color: #4d5665;
        font-family: inherit;
        font-size: 13px;
    }

    .activity-control:focus {
        border-color: #8fb8ed;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .18);
    }

    /* TABLE */
    .activity-card {
        overflow: hidden;
        border: 1px solid #edf0f4;
        border-radius: 13px;
        background: #fff;
        box-shadow: 0 4px 15px rgba(25, 42, 65, .16);
    }

    .activity-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .activity-table {
        width: 100%;
        min-width: 0;
        table-layout: fixed;
        border-collapse: collapse;
    }

    /* Lebar masing-masing kolom */
    .activity-table th:nth-child(1),
    .activity-table td:nth-child(1) {
        width: 15%;
    }

    .activity-table th:nth-child(2),
    .activity-table td:nth-child(2) {
        width: 14%;
    }

    .activity-table th:nth-child(3),
    .activity-table td:nth-child(3) {
        width: 10%;
    }

    .activity-table th:nth-child(4),
    .activity-table td:nth-child(4) {
        width: 20%;
    }

    .activity-table th:nth-child(5),
    .activity-table td:nth-child(5) {
        width: 20%;
    }

    .activity-table th:nth-child(6),
    .activity-table td:nth-child(6) {
        width: 21%;
    }

    .activity-table thead {
        background: #fff;
    }

    .activity-table th {
        padding: 12px 14px;
        border-bottom: 1px solid #e9edf2;
        color: #647895;
        font-size: 11px;
        font-weight: 700;
        text-align: center;
        white-space: nowrap;
    }

    .activity-table td {
        padding: 11px 14px;
        border-bottom: 1px solid #edf0f4;
        color: #53647e;
        font-size: 11px;
        line-height: 1.35;
        text-align: center;
        vertical-align: middle;
    }

    .activity-table tbody tr:hover {
        background: #fafcff;
    }

    .activity-date {
        color: #687c98 !important;
        white-space: nowrap;
    }

    .activity-actor {
        color: #17243a !important;
        font-weight: 700;
        white-space: nowrap;
    }

    .activity-subject,
    .activity-description,
    .activity-change {
        min-width: 0;
        overflow-wrap: anywhere;
    }

    .activity-subject {
        color: #52647e !important;
    }

    .activity-description {
        color: #71829b !important;
    }

    .activity-change {
        min-width: 150px;
    }

    /* ACTION BADGES */
    .activity-badge {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-create {
        background: #e4faf4;
        color: #159b82;
    }

    .badge-update {
        background: #e5efff;
        color: #3471d8;
    }

    .badge-delete {
        background: #ffebee;
        color: #df5368;
    }

    .badge-import {
        background: #e5efff;
        color: #2869d5;
    }

    .badge-export {
        background: #eeedff;
        color: #6255db;
    }

    .badge-verify {
        background: #e9edff;
        color: #5267d8;
    }

    .badge-login {
        background: #edf1f6;
        color: #60718a;
    }

    .badge-default {
        background: #edf0f5;
        color: #647188;
    }

    /* PERUBAHAN DATA */
    .change-value {
        display: inline-block;
        max-width: 145px;
        overflow: hidden;
        padding: 4px 7px;
        margin: 2px;
        border: 1px solid #c8f1df;
        border-radius: 5px;
        background: #edfff7;
        color: #07966d;
        font-size: 10px;
        text-overflow: ellipsis;
        vertical-align: middle;
        white-space: nowrap;
    }

    .change-old {
        border-color: #ffd7dc;
        background: #fff0f1;
        color: #df5368;
    }

    .change-arrow {
        color: #8c9ab0;
        font-size: 11px;
    }

    .empty-activity {
        padding: 45px 20px !important;
        color: #8591a4 !important;
        text-align: center !important;
    }

    .empty-activity strong {
        display: block;
        margin-bottom: 7px;
        color: #3c4c65;
        font-size: 14px;
    }

    /* TABLE FOOTER */
    .activity-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 11px 13px;
        color: #8a9bb2;
        font-size: 10px;
    }

    .activity-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .activity-pagination a,
    .activity-pagination span {
        padding: 6px 10px;
        border: 1px solid #e1e7ef;
        border-radius: 6px;
        background: #fff;
        color: #52617a;
        text-decoration: none;
    }

    .activity-pagination .current {
        border-color: #193b75;
        background: #193b75;
        color: #fff;
    }

    .activity-pagination .disabled {
        background: #f8f9fb;
        color: #b2bdcb;
    }

    .activity-note {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 12px;
        color: #9aa9bd;
        font-size: 10px;
    }

    @media (max-width: 1000px) {
        .activity-filter {
            gap: 16px;
        }

        .activity-heading h1 {
            font-size: 29px;
        }
    }

    @media (max-width: 750px) {
        .activity-header {
            flex-direction: column;
        }

        .activity-btn-export {
            margin-top: 0;
        }

        .activity-filter {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .activity-note {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .activity-filter {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .activity-heading h1 {
            font-size: 25px;
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

    <!-- HEADER -->
    <div class="activity-header">

        <div class="activity-heading">
            <h1>
                Riwayat Aktivitas
                <span class="locked-badge">🔒 Terkunci</span>
            </h1>

            <p class="activity-subtitle">
                Catatan setiap tindakan pada aplikasi.
                Catatan ini tidak dapat diubah atau dihapus siapa pun.
            </p>
        </div>

        <a
            href="{{ route('activity-logs.export', request()->only(['from', 'to', 'actor', 'action'])) }}"
            class="activity-btn-export"
        >
            Ekspor
        </a>

    </div>

    <!-- FILTER -->
    <form
        method="GET"
        action="{{ route('activity-logs.index') }}"
        class="activity-filter"
    >

        <div class="activity-field">
            <label for="from">Dari tanggal</label>
            <input
                type="date"
                id="from"
                name="from"
                class="activity-control"
                value="{{ $filters['from'] ?? '' }}"
                onchange="this.form.submit()"
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
                onchange="this.form.submit()"
            >
        </div>

        <div class="activity-field">
            <label for="actor">Pelaku</label>
            <select
                name="actor"
                id="actor"
                class="activity-control"
                onchange="this.form.submit()"
            >
                <option value="">Semua jenis</option>

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
                onchange="this.form.submit()"
            >
                <option value="">Semua jenis</option>

                @foreach ($actions as $action)
                    <option
                        value="{{ $action }}"
                        @selected(($filters['action'] ?? '') === $action)
                    >
                        {{ ucfirst($action) }}
                    </option>
                @endforeach
            </select>
        </div>

    </form>

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
                                'verified' => 'Verifikasi',
                                'login' => 'Login',
                                'restored' => 'Pulihkan',
                                'test' => 'Uji Coba',
                            ];

                            $badgeClasses = [
                                'created' => 'badge-create',
                                'updated' => 'badge-update',
                                'deleted' => 'badge-delete',
                                'imported' => 'badge-import',
                                'exported' => 'badge-export',
                                'verified' => 'badge-verify',
                                'login' => 'badge-login',
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
                                {{ $activity->created_at?->format('d M Y · H.i') }}
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

                                @if (
                                    is_array($changes) &&
                                    (isset($changes['old']) || isset($changes['new']))
                                )

                                    <span class="change-value change-old">
                                        {{ is_scalar($changes['old'] ?? null) ? $changes['old'] : 'Data sebelumnya' }}
                                    </span>

                                    <span class="change-arrow">→</span>

                                    <span class="change-value">
                                        {{ is_scalar($changes['new'] ?? null) ? $changes['new'] : 'Data terbaru' }}
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
                {{ $activities->total() }} catatan ditampilkan
            </div>

            <div class="activity-pagination">

                @if ($activities->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $activities->previousPageUrl() }}">‹</a>
                @endif

                <span class="current">
                    {{ $activities->currentPage() }}
                </span>

                @if ($activities->hasMorePages())
                    <a href="{{ $activities->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif

            </div>

        </div>

    </div>

    <!-- CATATAN BAWAH -->
    <div class="activity-note">

        <span>
            Menampilkan aktivitas sejak
            {{ $activities->last()?->created_at?->format('d M Y') ?? 'belum tersedia' }}
            hingga hari ini.
        </span>

        <span>🔒 Catatan aktivitas bersifat permanen</span>

    </div>

</div>

@endsection