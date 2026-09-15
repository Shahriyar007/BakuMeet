@extends('layouts.app')

@section('title', 'Önerilerin - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <a href="/wizard" style="display: inline-flex; align-items: center; gap: 4px; color: var(--color-text-secondary); text-decoration: none; font-size: var(--text-meta); margin-bottom: 8px;">
            <i class="ti ti-arrow-left" aria-hidden="true"></i>Tekrar dene
        </a>
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">Senin için önerdiklerimiz</p>

        @if ($establishments->isEmpty())
            <div class="bk-card" style="padding: 28px 20px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Bu kriterlere uygun mekan bulunamadı. Farklı seçeneklerle tekrar dene.</p>
            </div>
        @else
            @foreach ($establishments as $index => $place)
                <x-establishment-card :place="$place" :index="$index" :show-distance="true" />
            @endforeach
        @endif
    </div>
@endsection
