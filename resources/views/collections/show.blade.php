@extends('layouts.app')

@section('title', $collection->title . ' - BakuMeet')

@section('content')
    <a href="/collections" style="color: #3498db; text-decoration: none;">← Koleksiyonlara Dön</a>

    <div style="text-align: center; margin: 20px 0;">
        <div style="font-size: 50px;">{{ $collection->emoji }}</div>
        <h2>{{ $collection->title }}</h2>
        <p style="color: #666; margin-top: 5px;">{{ $collection->description }}</p>
    </div>

    @foreach ($collection->establishments as $place)
        <div class="card">
            <h3>{{ $place->name }}</h3>
            <p>
                <span class="badge {{ $place->type }}">
                    @if ($place->type === 'restaurant')
                        🍽️ Restoran
                    @else
                        ☕ Kafe
                    @endif
                </span>
                <span class="badge">📍 {{ $place->location }}</span>
                <span class="badge">🎭 {{ $place->mood }}</span>
            </p>
            <p><span class="rating">⭐ {{ $place->rating }}</span></p>
            <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
        </div>
    @endforeach
@endsection
