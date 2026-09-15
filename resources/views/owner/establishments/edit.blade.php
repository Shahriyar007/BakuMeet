@extends('layouts.owner')

@section('title', 'İşletmeyi Düzenle')

@section('content')
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">İşletme bilgilerini düzenle</p>

    @if ($errors->any())
        <div class="bk-card" style="background: var(--color-danger-tint); border-color: var(--color-danger); padding: 12px 14px; margin-bottom: 14px;">
            @foreach ($errors->all() as $error)
                <p style="font-size: var(--text-meta); color: var(--color-danger-text-on-tint);">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('status'))
        <div class="bk-card" style="background: var(--color-success-tint); border-color: var(--color-success); padding: 12px 14px; margin-bottom: 14px;">
            <p style="font-size: var(--text-meta); color: var(--color-success-text-on-tint);">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('owner.establishments.update') }}">
        @csrf
        @method('PUT')

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">TEMEL BİLGİ</p>
        <div class="bk-card" style="padding: 4px 14px; margin-bottom: 16px;">
            <div style="padding: 10px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">İşletme adı</label><br>
                <input type="text" name="name" value="{{ old('name', $establishment->name) }}" required style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
            </div>
            <div style="padding: 10px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Tür</label><br>
                <select name="type" required style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
                    <option value="cafe" {{ old('type', $establishment->type) === 'cafe' ? 'selected' : '' }}>Kafe</option>
                    <option value="restaurant" {{ old('type', $establishment->type) === 'restaurant' ? 'selected' : '' }}>Restoran</option>
                </select>
            </div>
            <div style="padding: 10px 0;">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Açıklama</label><br>
                <textarea name="description" rows="3" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0; resize: vertical;">{{ old('description', $establishment->description) }}</textarea>
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">KONUM</p>
        <div class="bk-card" style="padding: 4px 14px; margin-bottom: 16px;">
            <div style="padding: 10px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Adres</label><br>
                <input type="text" name="location" value="{{ old('location', $establishment->location) }}" required style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
            </div>
            <div style="display: flex; gap: 12px; padding: 10px 0;">
                <div style="flex: 1;">
                    <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Enlem</label><br>
                    <input type="text" name="latitude" value="{{ old('latitude', $establishment->latitude) }}" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
                </div>
                <div style="flex: 1;">
                    <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Boylam</label><br>
                    <input type="text" name="longitude" value="{{ old('longitude', $establishment->longitude) }}" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
                </div>
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">RUH HALİ VE FİYAT</p>
        <div class="bk-card" style="padding: 14px; margin-bottom: 16px;">
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px;">
                @foreach (['sakin' => 'Sakin', 'romantik' => 'Romantik', 'canlı' => 'Canlı', 'lüks' => 'Lüks', 'bütçedostu' => 'Bütçe dostu'] as $value => $label)
                    @php $moodVal = old('mood', $establishment->mood); @endphp
                    <label class="bk-chip {{ $moodVal === $value ? 'bk-chip--active' : '' }}" style="cursor: pointer;">
                        <input type="radio" name="mood" value="{{ $value }}" {{ $moodVal === $value ? 'checked' : '' }} required style="display: none;">{{ $label }}
                    </label>
                @endforeach
            </div>
            <div style="display: flex; gap: 8px;">
                @foreach ([1 => '₼', 2 => '₼₼', 3 => '₼₼₼'] as $value => $label)
                    @php $priceVal = (string) old('price_range', $establishment->price_range); @endphp
                    <label class="bk-chip {{ $priceVal === (string) $value ? 'bk-chip--active' : '' }}" style="flex: 1; justify-content: center; cursor: pointer;">
                        <input type="radio" name="price_range" value="{{ $value }}" {{ $priceVal === (string) $value ? 'checked' : '' }} required style="display: none;">{{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">ETİKETLER</p>
        <div class="bk-card" style="padding: 14px; margin-bottom: 16px;">
            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                @foreach ($tags as $tag)
                    <label class="bk-chip" style="cursor: pointer;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTagIds) ? 'checked' : '' }} style="margin-right: 2px;">{{ $tag->emoji }} {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">ÇALIŞMA SAATLERİ</p>
        <div class="bk-card" style="padding: 4px 14px; margin-bottom: 16px;">
            @php
                $dayLabels = ['monday' => 'Pazartesi', 'tuesday' => 'Salı', 'wednesday' => 'Çarşamba', 'thursday' => 'Perşembe', 'friday' => 'Cuma', 'saturday' => 'Cumartesi', 'sunday' => 'Pazar'];
                $hours = $establishment->opening_hours ?? [];
            @endphp
            @foreach ($dayLabels as $key => $label)
                @php $day = $hours[$key] ?? []; @endphp
                <div style="display: flex; align-items: center; gap: 8px; padding: 8px 0; {{ !$loop->last ? 'border-bottom: 0.5px solid var(--color-border-muted);' : '' }}">
                    <span style="font-size: var(--text-meta); color: var(--color-text); width: 80px; flex-shrink: 0;">{{ $label }}</span>
                    <input type="time" name="open_{{ $key }}" value="{{ $day['open'] ?? '09:00' }}" style="border: none; background: var(--color-bg-muted); border-radius: 6px; padding: 4px 6px; font-size: var(--text-micro);">
                    <span style="color: var(--color-text-secondary); font-size: var(--text-micro);">-</span>
                    <input type="time" name="close_{{ $key }}" value="{{ $day['close'] ?? '22:00' }}" style="border: none; background: var(--color-bg-muted); border-radius: 6px; padding: 4px 6px; font-size: var(--text-micro);">
                    <label style="font-size: var(--text-micro); color: var(--color-text-secondary); display: flex; align-items: center; gap: 3px; margin-left: auto;">
                        <input type="checkbox" name="closed_{{ $key }}" value="1" {{ ($day['closed'] ?? false) ? 'checked' : '' }}>Kapalı
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" id="submitBtn" class="bk-btn-primary" style="width: 100%; margin-bottom: 20px;">Güncelle</button>
    </form>

    <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">FOTOĞRAFLAR (en fazla 5, her biri max 5MB)</p>
    <input type="file" id="photoInput" accept="image/*" multiple style="margin-bottom: 12px; font-size: var(--text-meta);">
    <div id="photoGrid" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;">
        @foreach ($establishment->photos as $photo)
            <div class="photo-item" data-photo-id="{{ $photo->id }}" style="position: relative; width: 80px;">
                <img src="{{ $photo->url() }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: var(--radius-photo);">
                <form action="{{ route('owner.establishments.photos.destroy', $photo) }}" method="POST" style="margin-top: 4px;" onsubmit="return confirm('Bu fotoğrafı silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; font-size: 10px; color: var(--color-danger); background: none; border: none;">Sil</button>
                </form>
                @if ($photo->is_primary)
                    <span style="position: absolute; top: 4px; left: 4px; background: rgba(42,33,27,0.7); color: #fff; font-size: 9px; padding: 2px 6px; border-radius: 999px;">Ana</span>
                @else
                    <form action="{{ route('owner.establishments.photos.primary', $photo) }}" method="POST" style="margin-top: 2px;">
                        @csrf
                        <button type="submit" style="width: 100%; font-size: 9px; padding: 2px; background: none; border: none; color: var(--color-text-secondary);">Ana fotoğraf yap</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    @if ($establishment->photos->isEmpty())
        <p id="noPhotosText" style="font-size: var(--text-meta); color: var(--color-text-secondary); margin-bottom: 20px;">Henüz fotoğraf eklenmedi.</p>
    @endif

    <script>
        document.querySelectorAll('input[type="radio"][name="mood"], input[type="radio"][name="price_range"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.querySelectorAll('input[name="' + radio.name + '"]').forEach(function (r) {
                    r.closest('label').classList.remove('bk-chip--active');
                });
                radio.closest('label').classList.add('bk-chip--active');
            });
        });
    </script>

    @include('owner.partials.photo-upload-script', ['uploadUrl' => route('owner.establishments.photos.upload')])
@endsection
