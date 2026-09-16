@extends('layouts.admin')

@section('title', 'Panel')

@section('content')
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">Genel bakış</p>

    <div style="display: flex; gap: 8px; margin-bottom: 20px;">
        <div class="bk-card" style="flex: 1; padding: 14px; text-align: center;">
            <p class="heading" style="font-size: 22px; color: var(--color-accent);">{{ $pendingEstablishments }}</p>
            <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Onay bekleyen işletme</p>
        </div>
        <div class="bk-card" style="flex: 1; padding: 14px; text-align: center;">
            <p class="heading" style="font-size: 22px; color: var(--color-accent);">{{ $totalEstablishments }}</p>
            <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Toplam işletme</p>
        </div>
        <div class="bk-card" style="flex: 1; padding: 14px; text-align: center;">
            <p class="heading" style="font-size: 22px; color: var(--color-accent);">{{ $totalAccounts }}</p>
            <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">İşletme hesabı</p>
        </div>
    </div>

    <a href="{{ route('admin.establishments.index', ['status' => 'pending']) }}" class="bk-btn-primary" style="width: 100%; margin-bottom: 10px;">
        <i class="ti ti-clock" aria-hidden="true"></i>Onay bekleyenleri gör
    </a>
    <a href="{{ route('admin.establishments.index') }}" class="bk-btn-secondary" style="width: 100%;">
        <i class="ti ti-list" aria-hidden="true"></i>Tüm işletmeler
    </a>
@endsection
