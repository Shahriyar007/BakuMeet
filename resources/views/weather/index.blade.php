@extends('layouts.app')

@section('title', 'Hava Durumuna Göre - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">
            <i class="ti ti-sun" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i> Hava durumuna göre öneriler
        </p>

        <div class="bk-card" style="padding: 16px; text-align: center; margin-bottom: 20px;">
            <p style="font-size: var(--text-secondary); color: var(--color-text-muted); margin-bottom: 4px;">Bakü şu an: <strong style="color: var(--color-text);">{{ $condition }}</strong></p>
            @if ($temperature !== null)
                <p class="heading" style="font-size: 22px;">{{ $temperature }}°C</p>
            @endif
        </div>

        <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 12px;">Bugün için önerilerimiz</p>

        @if ($establishments->isEmpty())
            <div class="bk-card" style="padding: 28px 20px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Şu an için uygun öneri bulunamadı.</p>
            </div>
        @else
            @foreach ($establishments as $place)
                <x-establishment-card :place="$place" />
            @endforeach
        @endif
    </div>
@endsection
