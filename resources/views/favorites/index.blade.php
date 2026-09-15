@extends('layouts.app')

@section('title', 'Favorilerim - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">Kaydedilenler</p>

        @if ($favorites->isEmpty())
            <div class="bk-card" style="padding: 28px 20px; text-align: center;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--color-accent-tint); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                    <i class="ti ti-heart" style="font-size: 24px; color: var(--color-accent);" aria-hidden="true"></i>
                </div>
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); margin-bottom: 4px;">Henüz favorin yok</p>
                <p style="font-size: var(--text-meta); color: var(--color-text-secondary); margin-bottom: 16px;">Beğendiğin yerleri kalp ikonuna dokunarak buraya kaydet.</p>
                <a href="/establishments" class="bk-btn-primary" style="display: inline-flex;">Keşfetmeye başla</a>
            </div>
        @else
            @foreach ($favorites as $place)
                <x-establishment-card :place="$place" />
            @endforeach
        @endif
    </div>
@endsection
