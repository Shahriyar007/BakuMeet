@extends('layouts.app')

@section('title', 'Koleksiyonlar - BakuMeet')

@section('content')
    <h2>📚 Koleksiyonlar</h2>
    <p style="margin: 10px 0 20px; color: #666; font-size: 14px;">Özenle seçilmiş mekan listeleri</p>

    @foreach ($collections as $collection)
        <a href="/collections/{{ $collection->id }}" style="text-decoration: none;">
            <div class="card">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="font-size: 40px;">{{ $collection->emoji }}</div>
                    <div>
                        <h3>{{ $collection->title }}</h3>
                        <p style="color: #666; font-size: 13px;">{{ $collection->description }}</p>
                        <p style="color: #999; font-size: 12px; margin-top: 5px;">{{ $collection->establishments->count() }} mekan</p>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
@endsection
