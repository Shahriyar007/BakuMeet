@extends('layouts.app')

@section('title', $establishment->name . ' - BakuMeet')

@section('content')
    <div>
        <a href="/establishments" style="color: #3498db; text-decoration: none;">← Geri Dön</a>
        
        <div class="card" style="margin-top: 20px;">
            @if ($establishment->image)
                <div style="margin-bottom: 20px;">
                    <img src="{{ $establishment->image }}" alt="{{ $establishment->name }}" style="width: 100%; max-height: 400px; border-radius: 8px; object-fit: cover;">
                </div>
            @endif
            
            <h2>{{ $establishment->name }}</h2>
            
            <div style="margin: 15px 0;">
                <span class="badge {{ $establishment->type }}">
                    @if ($establishment->type === 'restaurant')
                        🍽️ Restoran
                    @elseif ($establishment->type === 'cafe')
                        ☕ Kafe
                    @endif
                </span>
                <span class="badge">📍 {{ $establishment->location }}</span>
                <span class="badge">🎭 {{ $establishment->mood }}</span>
            </div>
            
            <p style="margin: 15px 0; font-size: 16px;">
                <strong>Puanı:</strong> 
                <span class="rating">⭐ {{ $establishment->rating ?? 'Henüz puanlanmamış' }}</span>
            </p>
            
            <h3 style="margin-top: 20px; margin-bottom: 10px;">Açıklama</h3>
            <p>{{ $establishment->description ?? 'Açıklama bulunmamaktadır.' }}</p>
            
            <h3 style="margin-top: 20px; margin-bottom: 10px;">Konum Bilgileri</h3>
            <p>
                <strong>Semt:</strong> {{ $establishment->location }}<br>
                @if ($establishment->latitude && $establishment->longitude)
                    <strong>Koordinatlar:</strong> {{ $establishment->latitude }}, {{ $establishment->longitude }}
                @else
                    <em>Koordinatlar henüz eklenmemiş.</em>
                @endif
            </p>
        </div>
    </div>
@endsection
