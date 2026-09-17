@extends('layouts.app')

@section('title', 'İşletmeler - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 12px;">İşletmeler</p>

        <form action="/filter" method="GET" style="margin-bottom: 14px;">
            <div style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px;">
                <select name="location" onchange="this.form.submit()" class="bk-chip" style="border: 0.5px solid var(--color-border); flex-shrink: 0;">
                    <option value="">Semt</option>
                    <option value="Sabail">Sabail</option>
                    <option value="Nizami">Nizami</option>
                    <option value="Bayıl">Bayıl</option>
                    <option value="Yasamal">Yasamal</option>
                    <option value="İçərişəhər">İçərişəhər</option>
                    <option value="Nərimanov">Nərimanov</option>
                </select>
                <select name="mood" onchange="this.form.submit()" class="bk-chip" style="border: 0.5px solid var(--color-border); flex-shrink: 0;">
                    <option value="">Ruh hali</option>
                    <option value="romantik">Romantik</option>
                    <option value="sakin">Sakin</option>
                    <option value="canlı">Canlı</option>
                    <option value="lüks">Lüks</option>
                    <option value="bütçedostu">Bütçe dostu</option>
                </select>
                <select name="price_range" onchange="this.form.submit()" class="bk-chip" style="border: 0.5px solid var(--color-border); flex-shrink: 0;">
                    <option value="">Fiyat</option>
                    <option value="1">₼</option>
                    <option value="2">₼₼</option>
                    <option value="3">₼₼₼</option>
                </select>
                <select name="tag" onchange="this.form.submit()" class="bk-chip" style="border: 0.5px solid var(--color-border); flex-shrink: 0;">
                    <option value="">Özellik</option>
                    @foreach (\App\Models\Tag::all() as $tagOption)
                        <option value="{{ $tagOption->id }}">{{ $tagOption->emoji }} {{ $tagOption->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        @if (isset($filter))
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 14px;">
                <span class="bk-chip bk-chip--active">{{ $filter }}</span>
                <a href="/establishments" style="font-size: var(--text-meta); color: var(--color-danger); text-decoration: none;">Filtreyi kaldır</a>
            </div>
        @endif

        <p style="font-size: var(--text-meta); color: var(--color-text-secondary); margin-bottom: 14px;">{{ $establishments->count() }} sonuç</p>

        @if ($establishments->isEmpty())
            <div class="bk-card" style="padding: 28px 20px; text-align: center;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--color-accent-tint); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                    <i class="ti ti-search-off" style="font-size: 24px; color: var(--color-accent);" aria-hidden="true"></i>
                </div>
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); margin-bottom: 4px;">Sonuç bulunamadı</p>
                <p style="font-size: var(--text-meta); color: var(--color-text-secondary);">Farklı bir filtre dene.</p>
            </div>
        @else
            @foreach ($establishments as $place)
		<div>
                    <label style="display: inline-flex; align-items: center; gap: 4px; margin: 12px 0 -4px; font-size: var(--text-micro); color: var(--color-text-secondary);">
                        <input type="checkbox" name="ids[]" value="{{ $place->id }}" class="compare-checkbox">
                        Karşılaştırmaya ekle
                    </label>
                    <x-establishment-card
                        :place="$place"
                        photo-size="150px"
                        :show-open-status="true"
                        :show-tags="true"
                        :show-description="true"
                    />
                </div>
            @endforeach
        @endif
    </div>

    <div id="compare-bar" style="display: none; position: fixed; bottom: 70px; left: 0; right: 0; max-width: 480px; margin: 0 auto; padding: 0 16px; z-index: 30;">
        <div class="bk-btn-primary" onclick="goToCompare()" style="width: 100%;">
            <i class="ti ti-arrows-left-right" aria-hidden="true"></i>Karşılaştır (<span id="compare-count">0</span>)
        </div>
    </div>

    <script>
        function goToCompare() {
            const checked = document.querySelectorAll('.compare-checkbox:checked');
            const ids = Array.from(checked).map(cb => cb.value);
            let url = '/compare?' + ids.map(id => 'ids[]=' + id).join('&');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    url += '&lat=' + position.coords.latitude + '&lng=' + position.coords.longitude;
                    window.location.href = url;
                }, function () {
                    window.location.href = url;
                });
            } else {
                window.location.href = url;
            }
        }
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
    </script>
@endsection
