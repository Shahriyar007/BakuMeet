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
            
@auth
                <form action="/establishments/{{ $establishment->id }}/favorite" method="POST" style="display: inline;">
                    @csrf
                    @php
                        $isFavorited = auth()->user()->favorites()->where('establishment_id', $establishment->id)->exists();
                    @endphp
                    <button type="submit" style="padding: 8px 15px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; background-color: {{ $isFavorited ? '#e74c3c' : '#ecf0f1' }}; color: {{ $isFavorited ? 'white' : '#333' }};">
                        {{ $isFavorited ? '❤️ Favorilerde' : '🤍 Favorilere Ekle' }}
                    </button>
                </form>
            @endauth
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
<!-- YORUMLAR BÖLÜMÜ -->
        <div class="card" style="margin-top: 20px;">
            <h3>💬 Yorumlar</h3>
            
            @auth
                <form action="/establishments/{{ $establishment->id }}/reviews" method="POST" style="margin: 15px 0; display: grid; gap: 10px;">
                    @csrf
                    <div>
                        <label><strong>Puan (1-5):</strong></label><br>
                        <select name="rating" required style="padding: 8px; width: 100%;">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label><strong>Yorumunuz:</strong></label><br>
                        <textarea name="comment" required maxlength="500" rows="3" style="padding: 8px; width: 100%;"></textarea>
                    </div>
                    <button type="submit" style="padding: 10px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Yorum Ekle
                    </button>
                </form>
            @else
                <p style="margin: 15px 0;">
                    Yorum yazmak için <a href="/login">giriş yapın</a>.
                </p>
            @endauth
            
            @forelse ($establishment->reviews as $review)
                <div style="border-top: 1px solid #eee; padding: 15px 0;">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="rating">{{ str_repeat('⭐', $review->rating) }}</span>
                    <p style="margin-top: 5px;">{{ $review->comment }}</p>
                    <small style="color: #999;">{{ $review->created_at->diffForHumans() }}</small>
                    
                    @auth
                        @if (auth()->id() === $review->user_id)
                            <form action="/reviews/{{ $review->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 12px;">Sil</button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p style="color: #999; margin: 15px 0;">Henüz yorum yapılmamış. İlk yorumu sen yap!</p>
            @endforelse
        </div>
@endsection
