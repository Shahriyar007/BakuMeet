@extends('layouts.app')

@section('title', 'Öneri Sihirbazı - BakuMeet')

@section('content')
    <div>
        <h2>🧙 Sana Ne Uygun?</h2>
        <p style="color: #999; margin-bottom: 20px;">Birkaç soruyu cevapla, sana en uygun mekanları bulalım.</p>

        <div class="card">
            <form action="/wizard/results" method="GET" style="display: grid; gap: 15px;">
                <div>
                    <label><strong>1. Bugün ne modundasın?</strong></label><br>
                    <select name="mood" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Farketmez --</option>
                        <option value="romantik">💕 Romantik</option>
                        <option value="sakin">🧘 Sakin</option>
                        <option value="canlı">🎉 Canlı</option>
                        <option value="lüks">👑 Lüks</option>
                        <option value="bütçedostu">💰 Bütçe Dostu</option>
                    </select>
                </div>

                <div>
                    <label><strong>2. Bütçen ne kadar?</strong></label><br>
                    <select name="price_range" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Farketmez --</option>
                        <option value="1">₼ Ucuz</option>
                        <option value="2">₼₼ Orta</option>
                        <option value="3">₼₼₼ Pahalı</option>
                    </select>
                </div>

                <div>
                    <label><strong>3. Hangi semtte olsun?</strong></label><br>
                    <select name="location" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Farketmez --</option>
                        <option value="Sabail">Sabail</option>
                        <option value="Nizami">Nizami</option>
                        <option value="Bayıl">Bayıl</option>
                        <option value="Yasamal">Yasamal</option>
                        <option value="İçərişəhər">İçərişəhər</option>
                        <option value="Nərimanov">Nərimanov</option>
                    </select>
                </div>

                <div>
                    <label><strong>4. Özel bir özellik ister misin?</strong></label><br>
                    <select name="tag_id" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                        <option value="">-- Farketmez --</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->emoji }} {{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label><strong>5. Sana yakın mekanlar mı olsun?</strong></label><br>
                    <p id="wizard-loc-status" style="font-size: 13px; color: #999; margin-top: 5px;">Konum eklemek için tıkla (opsiyonel)</p>
                    <input type="hidden" name="lat" id="wizard-lat">
                    <input type="hidden" name="lng" id="wizard-lng">
                    <button type="button" onclick="getWizardLocation()" style="padding: 8px 12px; background-color: #ecf0f1; border: none; border-radius: 4px; cursor: pointer;">📍 Konumumu Ekle</button>
                </div>

                <button type="submit" style="padding: 12px; background-color: #3498db; color: white; border: none; border-radius: 4px; font-size: 15px; cursor: pointer;">
                    ✨ Önerileri Göster
                </button>
            </form>
        </div>
    </div>

    <script>
        function getWizardLocation() {
            const status = document.getElementById('wizard-loc-status');
            status.innerText = 'Konum alınıyor...';

            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('wizard-lat').value = position.coords.latitude;
                document.getElementById('wizard-lng').value = position.coords.longitude;
                status.innerText = '✅ Konumun eklendi';
            }, function () {
                status.innerText = '⚠️ Konum izni verilmedi, bu adım atlanacak';
            });
        }
    </script>
@endsection
