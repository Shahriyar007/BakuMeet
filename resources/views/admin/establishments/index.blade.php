@extends('layouts.admin')

@section('title', 'İşletmeler')

@section('content')
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 14px;">İşletmeler</p>

    <div style="display: flex; gap: 8px; overflow-x: auto; margin-bottom: 16px; padding-bottom: 2px;">
        <a href="{{ route('admin.establishments.index') }}" class="bk-chip {{ !$statusFilter ? 'bk-chip--active' : '' }}" style="text-decoration: none; flex-shrink: 0;">Tümü</a>
        <a href="{{ route('admin.establishments.index', ['status' => 'pending']) }}" class="bk-chip {{ $statusFilter === 'pending' ? 'bk-chip--active' : '' }}" style="text-decoration: none; flex-shrink: 0;">Onay bekliyor</a>
        <a href="{{ route('admin.establishments.index', ['status' => 'approved']) }}" class="bk-chip {{ $statusFilter === 'approved' ? 'bk-chip--active' : '' }}" style="text-decoration: none; flex-shrink: 0;">Yayında</a>
        <a href="{{ route('admin.establishments.index', ['status' => 'rejected']) }}" class="bk-chip {{ $statusFilter === 'rejected' ? 'bk-chip--active' : '' }}" style="text-decoration: none; flex-shrink: 0;">Reddedildi</a>
    </div>

    @forelse ($establishments as $establishment)
        <div class="bk-card" style="padding: 14px; margin-bottom: 10px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">{{ $establishment->name }}</p>
                @if ($establishment->status === 'pending')
                    <span class="bk-chip bk-badge--warning">Onay bekliyor</span>
                @elseif ($establishment->status === 'approved')
                    <span class="bk-chip bk-badge--success">Yayında</span>
                @elseif ($establishment->status === 'rejected')
                    <span class="bk-chip bk-badge--danger">Reddedildi</span>
                @endif
            </div>

            <p style="font-size: var(--text-meta); color: var(--color-text-secondary); margin-bottom: 4px;">{{ $establishment->type === 'cafe' ? 'Kafe' : 'Restoran' }} · {{ $establishment->location }}</p>

            @if ($establishment->businessAccount)
                <p style="font-size: var(--text-micro); color: var(--color-text-secondary); margin-bottom: 8px;">Sahip: {{ $establishment->businessAccount->name }} ({{ $establishment->businessAccount->email }})</p>
            @endif

            @if ($establishment->status === 'rejected' && $establishment->rejection_reason)
                <div style="background: var(--color-danger-tint); border-radius: var(--radius-control); padding: 8px 10px; margin-bottom: 10px;">
                    <p style="font-size: var(--text-micro); color: var(--color-danger-text-on-tint);">{{ $establishment->rejection_reason }}</p>
                </div>
            @endif

            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ url('/establishments/'.$establishment->id) }}" target="_blank" class="bk-btn-secondary" style="min-height: auto; padding: 8px 12px; font-size: var(--text-micro);">Görüntüle</a>

                @if ($establishment->status !== 'approved')
                    <form action="{{ route('admin.establishments.approve', $establishment) }}" method="POST">
                        @csrf
                        <button type="submit" class="bk-btn-primary" style="min-height: auto; padding: 8px 12px; font-size: var(--text-micro);">Onayla</button>
                    </form>
                @endif

                @if ($establishment->status !== 'rejected')
                    <button type="button" onclick="document.getElementById('reject-form-{{ $establishment->id }}').style.display = 'block'" class="bk-btn-secondary" style="min-height: auto; padding: 8px 12px; font-size: var(--text-micro); color: var(--color-danger); border-color: var(--color-danger);">Reddet</button>
                @endif
            </div>

            @if ($establishment->status !== 'rejected')
                <form id="reject-form-{{ $establishment->id }}" action="{{ route('admin.establishments.reject', $establishment) }}" method="POST" style="display: none; margin-top: 10px;">
                    @csrf
                    <textarea name="rejection_reason" required maxlength="500" rows="2" placeholder="Red sebebi..." class="bk-input" style="width: 100%; margin-bottom: 6px;"></textarea>
                    <button type="submit" class="bk-btn-primary" style="min-height: auto; padding: 8px 12px; font-size: var(--text-micro); background: var(--color-danger);">Reddi onayla</button>
                </form>
            @endif
        </div>
    @empty
        <div class="bk-card" style="padding: 24px 20px; text-align: center;">
            <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Bu filtrede işletme yok.</p>
        </div>
    @endforelse
@endsection
