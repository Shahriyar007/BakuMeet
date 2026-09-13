@extends('layouts.app')

@section('title', 'Trend Mekanlar - BakuMeet')

@section('content')
    <div>
        <h2>🔥 Trend Mekanlar</h2>
        <p style="color: #999; margin-bottom: 20px;">Puan, yorum ve favori sayısına göre en çok ilgi gören mekanlar.</p>

        @foreach ($establishments as $index => $place)
            <x-establishment-card :place="$place" :index="$index" :show-review-stats="true" />
        @endforeach
    </div>
@endsection
