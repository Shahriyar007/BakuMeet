@extends('layouts.app')

@section('title', 'Trend Mekanlar - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 4px;">
            <i class="ti ti-flame" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i> Trend mekanlar
        </p>
        <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 16px;">Puan, yorum ve favori sayısına göre en çok ilgi gören mekanlar.</p>

        @foreach ($establishments as $index => $place)
            <x-establishment-card :place="$place" :index="$index" :show-review-stats="true" />
        @endforeach
    </div>
@endsection
