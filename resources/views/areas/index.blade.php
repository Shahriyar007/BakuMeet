@extends('layouts.app')

@section('title', 'Bölgeler - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 4px;">Bölgeye göre keşfet</p>
        <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 16px;">Bir semt seç, o bölgedeki tüm mekanları keşfet.</p>

        @foreach ($locations as $loc)
            <a href="/areas/{{ urlencode($loc->location) }}" style="text-decoration: none;">
                <div class="bk-card" style="padding: 14px; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="ti ti-map-pin" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i>
                        <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">{{ $loc->location }}</span>
                    </div>
                    <span class="bk-chip">{{ $loc->total }} mekan</span>
                </div>
            </a>
        @endforeach
    </div>
@endsection
