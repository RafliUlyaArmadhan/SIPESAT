@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')

<style>
    .activity-container {
        padding: 30px;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .activity-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .activity-header p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .refresh-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: #166534;
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .refresh-btn:hover {
        background: #14532d;
        color: white;
    }

    .activity-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
    }

    .activity-table thead {
        background: #166534;
        color: white;
    }

    .activity-table th {
        padding: 15px 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .activity-table td {
        padding: 15px 16px;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
        font-size: 13px;
        vertical-align: middle;
    }

    .activity-table tbody tr:hover {
        background: #f8fafc;
    }

    .activity-table tbody tr:last-child td {
        border-bottom: none;
    }

    .user-name {
        font-weight: 600;
        color: #1f2937;
    }

    .user-email {
        display: block;
        margin-top: 3px;
        color: #9ca3af;
        font-size: 12px;
    }

    .activity-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #dcfce7;
        color: #166534;
        font-size: 12px;
        font-weight: 600;
    }

    .module-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 6px;
        background: #f3f4f6;
        color: #374151;
        font-size: 12px;
        font-weight: 500;
    }

    .description {
        max-width: 300px;
        line-height: 1.5;
    }

    .ip-address {
        font-family: monospace;
        font-size: 12px;
        color: #6b7280;
        background: #f3f4f6;
        padding: 5px 8px;
        border-radius: 5px;
    }

    .time {
        white-space: nowrap;
        color: #4b5563;
    }

    .empty-data {
        text-align: center;
        padding: 50px 20px !important;
        color: #9ca3af !important;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .activity-container {
            padding: 20px;
        }

        .activity-header {
            align-items: flex-start;
            gap: 15px;
            flex-direction: column;
        }

        .activity-header h2 {
            font-size: 20px;
        }
    }
</style>

<div class="activity-container">

    {{-- Header --}}
    <div class="activity-header">
        <div>
            <h2>Log Aktivitas Sistem</h2>
            <p>Riwayat aktivitas pengguna yang tercatat di dalam sistem.</p>
        </div>

        <a href="{{ route('admin.activity-log.index') }}" class="refresh-btn">
            ↻ Refresh
        </a>
    </div>

    {{-- Tabel --}}
    <div class="activity-card">
        <div class="table-wrapper">

            <table class="activity-table">

                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Modul</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($activityLogs as $log)

                        <tr>

                            {{-- Waktu --}}
                            <td class="time">
                                {{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-' }}
                            </td>

                            {{-- Pengguna --}}
                            <td>
                                @if ($log->user)
                                    <span class="user-name">
                                        {{ $log->user->name }}
                                    </span>

                                    <span class="user-email">
                                        {{ $log->user->email }}
                                    </span>
                                @else
                                    <span class="user-name">
                                        Sistem
                                    </span>
                                @endif
                            </td>

                            {{-- Aktivitas --}}
                            <td>
                                <span class="activity-badge">
                                    {{ $log->activity }}
                                </span>
                            </td>

                            {{-- Modul --}}
                            <td>
                                <span class="module-badge">
                                    {{ $log->module }}
                                </span>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="description">
                                {{ $log->description ?? '-' }}
                            </td>

                            {{-- IP Address --}}
                            <td>
                                @if ($log->ip_address)
                                    <span class="ip-address">
                                        {{ $log->ip_address }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty-data">
                                <div class="empty-icon">📋</div>
                                <strong>Belum ada aktivitas</strong>
                                <br>
                                <span>
                                    Data aktivitas sistem akan muncul di sini.
                                </span>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection