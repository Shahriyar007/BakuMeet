@extends('layouts.app')

@section('title', 'Öneri Sihirbazı - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 4px;">Sana ne uygun?</p>
        <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 16px;">Birkaç soruyu cevapla, sana en uygun mekanları bulalım.</p>

        <form action="/wizard/results" method="GET">
            <div class="bk-card" style="padding: 4px 14px; margin-bottom: 20px;">
                <div style="padding: 12px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                    <label style="font-size: var(--text-meta); color: var(--color-text-muted); font-weight: var(--weight-medium);">Bugün ne modundasın?</label><br>
                    <select name="mood" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 6px 0;">
                        <option value="">Farketmez</option>
                        <option value="romantik">Romantik</option>
                        <option value="sakin">Sakin</option>
                        <option value="canlı">Canlı</option>
                        <option value="lüks">Lüks</option>
                        <option value="bütçedostu">Bütçe dostu</option>
                    </select>
                </div>

                <div style="padding: 12px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                    <label style="font-size: var(--text-meta); color: var(--color-text-muted); font-weight: var(--weight-medium);">Bütçen ne kadar?</label><br>
                    <select name="price_range" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 6px 0;">
                        <option value="">Farketmez</option>
                        <option value="1">₼ Ucuz</option>
                        <option value="2">₼₼ Orta</option>
                        <option value="3">₼₼₼ Pahalı</option>
                    </select>
                </div>

                <div style="padding: 12px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                    <label style="font-size: var(--text-meta); color: var(--color-text-muted); font-weight: var(--weight-medium);">Hangi semtte olsun?</label><br>
                    <select name="location" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 6px 0;">
                        <option value="">Farketmez</option>
                        <option value="Sabail">Sabail</option>
                        <option value="Nizami">Nizami</option>
                        <option value="Bayıl">Bayıl</option>
                        <option value="Yasamal">Yasamal</option>
                        <option value="İçərişəhər">İçərişəhər</option>
                        <option value="Nərimanov">Nərimanov</option>
                    </select>
                </div>

                <div style="padding: 12px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                    <label style="font-size: var(--text-meta); color: var(--color-text-muted); font-weight: var(--weight-medium);">Özel bir özellik ister misin?</label><br>
                    <select name="tag_id" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 6px 0;">
                        <option value="">Farketmez</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->emoji }} {{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="padding: 12px 0;">
                    <label style="font-size: var(--text-meta); color: var(--color-text-muted); font-weight: var(--weight-medium);">Sana yakın mekanlar mı olsun?</label><br>
                    <p id="wizard-loc-status" style="font-size: var(--text-meta); color: var(--color-text-secondary); margin: 6px 0;">Konum eklemek için dokun (opsiyonel)</p>
                    <input type="hidden" name="lat" id="wizard-lat">
                    <input type="hidden" name="lng" id="wizard-lng">
                    <div onclick="getWizardLocation()" class="bk-btn-secondary" style="display: inline-flex; min-height: auto; padding: 8px 14px;">
                        <i class="ti ti-map-pin" aria-hidden="true"></i>Konumumu ekle
                    </div>
                </div>
            </div>

            <button type="submit" class="bk-btn-primary" style="width: 100%;">
                <i class="ti ti-sparkles" aria-hidden="true"></i>Önerileri göster
            </button>
        </form>
    </div>

    <script>
        function getWizardLocation() {
            const status = document.getElementById('wizard-loc-status');
            status.innerText = 'Konum alınıyor...';

            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('wizard-lat').value = position.coords.latitude;
                document.getElementById('wizard-lng').value = position.coords.longitude;
                status.innerText = 'Konumun eklendi';
            }, function () {
                status.innerText = 'Konum izni verilmedi, bu adım atlanacak';
            });
        }
    </script>
@endsection
