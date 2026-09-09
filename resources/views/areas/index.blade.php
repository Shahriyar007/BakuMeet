@extends('layouts.app')

@section('title', 'Bölgeler - BakuMeet')

@section('content')
    <div>
        <h2>🗺️ Bölgeye Göre Keşfet</h2>
        <p style="color: #999; margin-bottom: 20px;">Bir semt seç, o bölgedeki tüm mekanları keşfet.</p>

        @foreach ($locations as $loc)
            <a href="/areas/{{ urlencode($loc->location) }}" style="text-decoration: none;">
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3>📍 {{ $loc->location }}</h3>
                        <span class="badge">{{ $loc->total }} mekan</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
