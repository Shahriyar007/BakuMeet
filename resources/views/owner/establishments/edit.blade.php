@extends('layouts.owner')

@section('title', 'İşletmeyi Düzenle')

@section('content')
    <h1>İşletme Bilgilerini Düzenle</h1>

    @if ($errors->any())
        <div style="background: #ffe6e6; padding: 10px; border-radius: 4px;">
            @foreach ($errors->all() as $error)
                <p style="margin: 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

	<form method="POST" action="{{ route('owner.establishments.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 12px;">
            <label>İşletme Adı</label><br>
            <input type="text" name="name" value="{{ old('name', $establishment->name) }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 12px;">
            <label>Tür</label><br>
            <select name="type" required style="width: 100%; padding: 8px;">
                <option value="cafe" {{ old('type', $establishment->type) === 'cafe' ? 'selected' : '' }}>Kafe</option>
                <option value="restaurant" {{ old('type', $establishment->type) === 'restaurant' ? 'selected' : '' }}>Restoran</option>
            </select>
        </div>
        <div style="margin-bottom: 12px;">
            <label>Açıklama</label><br>
            <textarea name="description" rows="4" style="width: 100%; padding: 8px;">{{ old('description', $establishment->description) }}</textarea>
        </div>
        <div style="margin-bottom: 12px;">
            <label>Konum (bölge/adres)</label><br>
            <input type="text" name="location" value="{{ old('location', $establishment->location) }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 12px;">
            <label>Enlem (latitude)</label><br>
            <input type="text" name="latitude" value="{{ old('latitude', $establishment->latitude) }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 12px;">
            <label>Boylam (longitude)</label><br>
            <input type="text" name="longitude" value="{{ old('longitude', $establishment->longitude) }}" style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 12px;">
            <label>Mood</label><br>
            <select name="mood" required style="width: 100%; padding: 8px;">
                <option value="sakin" {{ old('mood', $establishment->mood) === 'sakin' ? 'selected' : '' }}>Sakin</option>
                <option value="romantik" {{ old('mood', $establishment->mood) === 'romantik' ? 'selected' : '' }}>Romantik</option>
                <option value="canlı" {{ old('mood', $establishment->mood) === 'canlı' ? 'selected' : '' }}>Canlı</option>
                <option value="lüks" {{ old('mood', $establishment->mood) === 'lüks' ? 'selected' : '' }}>Lüks</option>
                <option value="bütçedostu" {{ old('mood', $establishment->mood) === 'bütçedostu' ? 'selected' : '' }}>Bütçe Dostu</option>
            </select>
        </div>
        <div style="margin-bottom: 12px;">
            <label>Fiyat Aralığı</label><br>
            <select name="price_range" required style="width: 100%; padding: 8px;">
                <option value="1" {{ (string) old('price_range', $establishment->price_range) === '1' ? 'selected' : '' }}>₼</option>
                <option value="2" {{ (string) old('price_range', $establishment->price_range) === '2' ? 'selected' : '' }}>₼₼</option>
                <option value="3" {{ (string) old('price_range', $establishment->price_range) === '3' ? 'selected' : '' }}>₼₼₼</option>
            </select>
        </div>

        <h3>Etiketler</h3>
        @foreach ($tags as $tag)
            <label style="display: block; margin-bottom: 6px;">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTagIds) ? 'checked' : '' }}> {{ $tag->name }}
            </label>
        @endforeach

        <h3>Çalışma Saatleri</h3>
        @php
            $dayLabels = ['monday' => 'Pazartesi', 'tuesday' => 'Salı', 'wednesday' => 'Çarşamba', 'thursday' => 'Perşembe', 'friday' => 'Cuma', 'saturday' => 'Cumartesi', 'sunday' => 'Pazar'];
            $hours = $establishment->opening_hours ?? [];
        @endphp
        @foreach ($dayLabels as $key => $label)
            @php $day = $hours[$key] ?? []; @endphp
            <div style="margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                <span style="width: 90px;">{{ $label }}</span>
                <input type="time" name="open_{{ $key }}" value="{{ $day['open'] ?? '09:00' }}" style="padding: 6px;">
                <span>-</span>
                <input type="time" name="close_{{ $key }}" value="{{ $day['close'] ?? '22:00' }}" style="padding: 6px;">
                <label><input type="checkbox" name="closed_{{ $key }}" value="1" {{ ($day['closed'] ?? false) ? 'checked' : '' }}> Kapalı</label>
            </div>
        @endforeach
	<h3>Mevcut Fotoğraflar</h3>
        @if ($establishment->photos->isEmpty())
            <p>Henüz fotoğraf eklenmedi.</p>
        @else
            <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 12px;">
                @foreach ($establishment->photos as $photo)
                    <img src="{{ $photo->url() }}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                @endforeach
            </div>
        @endif

        <h3>Yeni Fotoğraf Ekle (en fazla 5, her biri max 5MB)</h3>
        <input type="file" name="photos[]" multiple accept="image/*" style="margin-bottom: 12px;">

        <button type="submit" style="padding: 10px 20px; margin-top: 12px;">Güncelle</button>
    </form>
@endsection
