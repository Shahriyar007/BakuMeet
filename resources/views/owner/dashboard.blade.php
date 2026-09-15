@extends('layouts.owner')

@section('title', 'Panel')

@section('content')
    <p style="font-size: var(--text-meta); color: var(--color-text-secondary); margin-bottom: 2px;">Merhaba,</p>
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 18px;">{{ $account->name }}</p>

    @if ($account->isPending())
        <div class="bk-card" style="padding: 24px 20px; text-align: center;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-warning-tint); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                <i class="ti ti-clock" style="font-size: 22px; color: var(--color-warning);" aria-hidden="true"></i>
            </div>
            <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 4px;">Başvurun inceleniyor</p>
            <p style="font-size: var(--text-meta); color: var(--color-text-secondary);">Onaylandığında işletmeni ekleyebileceksin.</p>
        </div>
    @elseif (! $establishment)
        <div class="bk-card" style="padding: 24px 20px; text-align: center;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--color-accent-tint); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                <i class="ti ti-building-store" style="font-size: 22px; color: var(--color-accent);" aria-hidden="true"></i>
            </div>
            <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 4px;">Hesabın onaylandı</p>
            <p style="font-size: var(--text-meta); color: var(--color-text-secondary); margin-bottom: 14px;">Şimdi işletmeni ekleyip fotoğraflarını yükleyebilirsin.</p>
            <a href="{{ route('owner.establishments.create') }}" class="bk-btn-primary" style="display: inline-flex;">
                <i class="ti ti-plus" aria-hidden="true"></i>İşletme ekle
            </a>
        </div>
    @else
        <div class="bk-card" style="padding: 14px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                <p class="heading" style="font-size: var(--text-card-title);">{{ $establishment->name }}</p>
                @if ($establishment->status === 'pending')
                    <span class="bk-chip bk-badge--warning">Onay bekliyor</span>
                @elseif ($establishment->status === 'approved')
                    <span class="bk-chip bk-badge--success">Yayında</span>
                @elseif ($establishment->status === 'rejected')
                    <span class="bk-chip bk-badge--danger">Reddedildi</span>
                @endif
            </div>

            @if ($establishment->status === 'rejected' && $establishment->rejection_reason)
                <div style="background: var(--color-danger-tint); border-radius: var(--radius-control); padding: 10px 12px; margin-bottom: 12px;">
                    <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-danger-text-on-tint); margin-bottom: 2px;">Sebep</p>
                    <p style="font-size: var(--text-meta); color: var(--color-danger-text-on-tint);">{{ $establishment->rejection_reason }}</p>
                </div>
            @endif

            @if ($establishment->status === 'approved')
                <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                    <div style="flex: 1; background: var(--color-bg-muted); border-radius: var(--radius-control); padding: 8px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 3px;">
                            <i class="ti ti-star" style="font-size: 13px; color: var(--color-accent);" aria-hidden="true"></i>
                            <span style="font-size: 14px; font-weight: var(--weight-medium);">{{ $establishment->rating ?? '-' }}</span>
                        </div>
                        <p style="font-size: 10px; color: var(--color-text-secondary); margin-top: 2px;">Puan</p>
                    </div>
                    <div style="flex: 1; background: var(--color-bg-muted); border-radius: var(--radius-control); padding: 8px; text-align: center;">
                        <p style="font-size: 14px; font-weight: var(--weight-medium);">{{ $establishment->reviews_count }}</p>
                        <p style="font-size: 10px; color: var(--color-text-secondary); margin-top: 2px;">Yorum</p>
                    </div>
                    <div style="flex: 1; background: var(--color-bg-muted); border-radius: var(--radius-control); padding: 8px; text-align: center;">
                        <p style="font-size: 14px; font-weight: var(--weight-medium);">{{ $establishment->favorited_by_count }}</p>
                        <p style="font-size: 10px; color: var(--color-text-secondary); margin-top: 2px;">Favori</p>
                    </div>
                </div>
            @endif

            <div style="display: flex; flex-direction: column; gap: 4px; font-size: var(--text-secondary); color: var(--color-text-muted); margin-bottom: 12px;">
                <p>{{ $establishment->type === 'cafe' ? 'Kafe' : 'Restoran' }} · {{ $establishment->mood }} · {{ $establishment->location }}</p>
                @if ($establishment->description)
                    <p style="color: var(--color-text-secondary);">{{ Str::limit($establishment->description, 100) }}</p>
                @endif
            </div>

            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('owner.establishments.edit') }}" class="bk-btn-primary" style="flex: 1; min-height: auto; padding: 10px;">
                    <i class="ti ti-edit" aria-hidden="true"></i>Düzenle
                </a>
                @if ($establishment->status === 'approved')
                    <a href="{{ url('/establishments/'.$establishment->id) }}" target="_blank" class="bk-btn-secondary" style="flex: 1; min-height: auto; padding: 10px;">
                        <i class="ti ti-eye" aria-hidden="true"></i>Profili gör
                    </a>
                @endif
            </div>
        </div>
    @endif
@endsection
