@extends('layouts.app')

@section('title', 'İşletmeler - BakuMeet')

@section('content')
        <form action="/compare" method="GET" id="compare-form">
        <input type="hidden" name="lat" id="compare-lat">
        <input type="hidden" name="lng" id="compare-lng">
    <div>
        <h2>İşletmeler Listesi</h2>

        <!-- FILTRE FORMU -->
        <div class="card" style="background-color: #ecf0f1; margin-bottom: 20px;">
            <h3>Filtre</h3>
            <form action="/filter" method="GET" style="display: grid; gap: 10px;">
                <div>
                    <label for="location"><strong>Semt Seç:</strong></label><br>
                    <select name="location" id="location" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Tümü --</option>
                        <option value="Sabail">Sabail</option>
                        <option value="Nizami">Nizami</option>
                        <option value="Bayıl">Bayıl</option>
                        <option value="Yasamal">Yasamal</option>
                        <option value="İçərişəhər">İçərişəhər (Eski Şehir)</option>
                        <option value="Nərimanov">Nərimanov</option>
                    </select>
                </div>

                <div>
                    <label for="mood"><strong>Ruh Hali Seç:</strong></label><br>
                    <select name="mood" id="mood" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Tümü --</option>
                        <option value="romantik">💕 Romantik</option>
                        <option value="sakin">🧘 Sakin</option>
                        <option value="canlı">🎉 Canlı</option>
                        <option value="lüks">👑 Lüks</option>
                        <option value="bütçedostu">💰 Bütçe Dostu</option>
                    </select>
                </div>

                <div>
                    <label for="price_range"><strong>Fiyat Aralığı:</strong></label><br>
                    <select name="price_range" id="price_range" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Tümü --</option>
                        <option value="1">₼ Ucuz</option>
                        <option value="2">₼₼ Orta</option>
                        <option value="3">₼₼₼ Pahalı</option>
                    </select>
                </div>

      		<div>
                    <label for="tag"><strong>Özellik:</strong></label><br>
                    <select name="tag" id="tag" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Tümü --</option>
                        @foreach (\App\Models\Tag::all() as $tagOption)
                            <option value="{{ $tagOption->id }}">{{ $tagOption->emoji }} {{ $tagOption->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" style="padding: 10px; background-color: #3498db; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;">
                    🔍 Filtrele
                </button>
            </form>
        </div>

        @if (isset($filter))
            <p style="color: #27ae60; margin: 15px 0; font-size: 14px;">
                📌 Filtre: <strong>{{ $filter }}</strong>
                <a href="/establishments" style="color: #e74c3c;">Filtresi Kaldır</a>
            </p>
        @endif

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Sonuç bulunamadı.</p>
            </div>
        @else
           @foreach ($establishments as $place)
                <div class="card">
                    <label style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px; font-size: 13px; color: #3498db;">
                        <input type="checkbox" name="ids[]" value="{{ $place->id }}" class="compare-checkbox">
                        Karşılaştırmaya ekle
                    </label>
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3>{{ $place->name }}</h3>

                            <p>
                                <span class="badge {{ $place->type }}">
                                    @if ($place->type === 'restaurant')
                                        🍽️ Restoran
                                    @elseif ($place->type === 'cafe')
                                        ☕ Kafe
                                    @endif
                                </span>
                                <span class="badge">📍 {{ $place->location }}</span>
                                <span class="badge">🎭 {{ $place->mood }}</span>
                                <span class="badge">{{ str_repeat('₼', $place->price_range) }}</span>
                                @if ($place->statusText())
                                    <span class="badge" style="background-color: {{ $place->isOpenNow() ? '#2ecc71' : '#e74c3c' }}; color: white;">
                                    @foreach ($place->tags as $tag)
                                    <span class="badge">{{ $tag->emoji }} {{ $tag->name }}</span>
                                @endforeach
    {{ $place->isOpenNow() ? '🟢' : '🔴' }} {{ $place->statusText() }}
                                    </span>
                                @endif 
  </p>

                            @if ($place->description)
                                <p><strong>Açıklama:</strong> {{ Str::limit($place->description, 100) }}</p>
                            @endif

                            <p>
                                <strong>Puanı:</strong>
                                <span class="rating">⭐ {{ $place->rating ?? 'Henüz puanlanmamış' }}</span>
                            </p>

                            <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
                        </div>

                        <div>
                            @if ($place->image)
                                <img src="{{ $place->image }}" alt="{{ $place->name }}" style="width: 150px; height: 150px; border-radius: 8px; object-fit: cover;">
                            @else
                                <div style="width: 150px; height: 150px; border-radius: 8px; background-color: {{ $place->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 48px;">
                                    {{ $place->type === 'restaurant' ? '🍽️' : '☕' }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
@endif
    </div>

    <div id="compare-bar" style="display: none; position: fixed; bottom: 0; left: 0; right: 0; background: #2c3e50; padding: 12px; text-align: center; z-index: 100;">
        <button type="submit" form="compare-form" style="padding: 10px 20px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">
            ⚖️ Karşılaştır (<span id="compare-count">0</span>)
        </button>
    </div>
    </form>

    <script>
        const checkboxes = document.querySelectorAll('.compare-checkbox');
        const bar = document.getElementById('compare-bar');
        const countEl = document.getElementById('compare-count');

        function updateCompareBar() {
            const checked = document.querySelectorAll('.compare-checkbox:checked');
            countEl.innerText = checked.length;
            bar.style.display = checked.length >= 2 ? 'block' : 'none';

            checkboxes.forEach(cb => {
                if (!cb.checked && checked.length >= 3) {
                    cb.disabled = true;
                } else {
                    cb.disabled = false;
                }
            });
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateCompareBar));

        document.getElementById('compare-form').addEventListener('submit', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    document.getElementById('compare-lat').value = position.coords.latitude;
                    document.getElementById('compare-lng').value = position.coords.longitude;
                });
            }
        });
    </script>
@endsection
