@extends('layouts.owner')

@section('title', 'İşletme Ekle')

@section('content')
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">İşletmenizi ekleyin</p>

    @if ($errors->any())
        <div class="bk-card" style="background: var(--color-danger-tint); border-color: var(--color-danger); padding: 12px 14px; margin-bottom: 14px;">
            @foreach ($errors->all() as $error)
                <p style="font-size: var(--text-meta); color: var(--color-danger-text-on-tint);">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('owner.establishments.store') }}">
        @csrf

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">TEMEL BİLGİ</p>
        <div class="bk-card" style="padding: 4px 14px; margin-bottom: 16px;">
            <div style="padding: 10px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">İşletme adı</label><br>
                <input type="text" name="name" value="{{ old('name') }}" required style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
            </div>
            <div style="padding: 10px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Tür</label><br>
                <select name="type" required style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
                    <option value="cafe" {{ old('type') === 'cafe' ? 'selected' : '' }}>Kafe</option>
                    <option value="restaurant" {{ old('type') === 'restaurant' ? 'selected' : '' }}>Restoran</option>
                </select>
            </div>
            <div style="padding: 10px 0;">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Açıklama</label><br>
                <textarea name="description" rows="3" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0; resize: vertical;">{{ old('description') }}</textarea>
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">KONUM</p>
        <div class="bk-card" style="padding: 4px 14px; margin-bottom: 16px;">
            <div style="padding: 10px 0; border-bottom: 0.5px solid var(--color-border-muted);">
                <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Adres</label><br>
                <input type="text" name="location" value="{{ old('location') }}" required style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
            </div>
            <div style="display: flex; gap: 12px; padding: 10px 0;">
                <div style="flex: 1;">
                    <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Enlem</label><br>
                    <input type="text" name="latitude" value="{{ old('latitude') }}" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
                </div>
                <div style="flex: 1;">
                    <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Boylam</label><br>
                    <input type="text" name="longitude" value="{{ old('longitude') }}" style="border: none; outline: none; background: transparent; width: 100%; font-size: var(--text-secondary); font-family: var(--font-body); padding: 4px 0;">
                </div>
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">RUH HALİ VE FİYAT</p>
        <div class="bk-card" style="padding: 14px; margin-bottom: 16px;">
            <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px;">
                @foreach (['sakin' => 'Sakin', 'romantik' => 'Romantik', 'canlı' => 'Canlı', 'lüks' => 'Lüks', 'bütçedostu' => 'Bütçe dostu'] as $value => $label)
                    <label class="bk-chip {{ old('mood') === $value ? 'bk-chip--active' : '' }}" style="cursor: pointer;">
                        <input type="radio" name="mood" value="{{ $value }}" {{ old('mood') === $value ? 'checked' : '' }} required style="display: none;">{{ $label }}
                    </label>
                @endforeach
            </div>
            <div style="display: flex; gap: 8px;">
                @foreach ([1 => '₼', 2 => '₼₼', 3 => '₼₼₼'] as $value => $label)
                    <label class="bk-chip {{ old('price_range') == $value ? 'bk-chip--active' : '' }}" style="flex: 1; justify-content: center; cursor: pointer;">
                        <input type="radio" name="price_range" value="{{ $value }}" {{ old('price_range') == $value ? 'checked' : '' }} required style="display: none;">{{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">ETİKETLER</p>
        <div class="bk-card" style="padding: 14px; margin-bottom: 16px;">
            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                @foreach ($tags as $tag)
                    <label class="bk-chip" style="cursor: pointer;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" style="margin-right: 2px;">{{ $tag->emoji }} {{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">ÇALIŞMA SAATLERİ</p>
        <div class="bk-card" style="padding: 4px 14px; margin-bottom: 16px;">
            @php $dayLabels = ['monday' => 'Pazartesi', 'tuesday' => 'Salı', 'wednesday' => 'Çarşamba', 'thursday' => 'Perşembe', 'friday' => 'Cuma', 'saturday' => 'Cumartesi', 'sunday' => 'Pazar']; @endphp
            @foreach ($dayLabels as $key => $label)
                <div style="display: flex; align-items: center; gap: 8px; padding: 8px 0; {{ !$loop->last ? 'border-bottom: 0.5px solid var(--color-border-muted);' : '' }}">
                    <span style="font-size: var(--text-meta); color: var(--color-text); width: 80px; flex-shrink: 0;">{{ $label }}</span>
                    <input type="time" name="open_{{ $key }}" value="09:00" style="border: none; background: var(--color-bg-muted); border-radius: 6px; padding: 4px 6px; font-size: var(--text-micro);">
                    <span style="color: var(--color-text-secondary); font-size: var(--text-micro);">-</span>
                    <input type="time" name="close_{{ $key }}" value="22:00" style="border: none; background: var(--color-bg-muted); border-radius: 6px; padding: 4px 6px; font-size: var(--text-micro);">
                    <label style="font-size: var(--text-micro); color: var(--color-text-secondary); display: flex; align-items: center; gap: 3px; margin-left: auto;">
                        <input type="checkbox" name="closed_{{ $key }}" value="1">Kapalı
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" id="submitBtn" class="bk-btn-primary" style="width: 100%; margin-bottom: 20px;">Kaydet</button>
    </form>

    <p style="font-size: var(--text-micro); font-weight: var(--weight-medium); color: var(--color-text-secondary); letter-spacing: 0.3px; margin-bottom: 8px;">FOTOĞRAFLAR (en fazla 5, her biri max 5MB)</p>
    <input type="file" id="photoInput" accept="image/*" multiple style="margin-bottom: 12px; font-size: var(--text-meta);">
    <div id="photoGrid" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;">
        @foreach ($pendingPhotos as $photo)
            <div class="photo-item" data-photo-id="{{ $photo->id }}" style="position: relative; width: 80px;">
                <img src="{{ $photo->url() }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: var(--radius-photo);">
                <form action="{{ route('owner.establishments.photos.destroy', $photo) }}" method="POST" style="margin-top: 4px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width: 100%; font-size: 10px; color: var(--color-danger); background: none; border: none;">Sil</button>
                </form>
                @if ($photo->is_primary)
                    <span style="position: absolute; top: 4px; left: 4px; background: rgba(42,33,27,0.7); color: #fff; font-size: 9px; padding: 2px 6px; border-radius: 999px;">Ana</span>
                @endif
            </div>
        @endforeach
    </div>
    @if ($pendingPhotos->isEmpty())
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
