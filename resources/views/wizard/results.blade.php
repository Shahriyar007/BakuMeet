@extends('layouts.app')

@section('title', 'Önerilerin - BakuMeet')

@section('content')
    <div>
        <a href="/wizard" style="color: #3498db; text-decoration: none;">← Tekrar Dene</a>
        <h2>✨ Senin İçin Önerdiklerimiz</h2>

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Bu kriterlere uygun mekan bulunamadı. Farklı seçeneklerle tekrar dene.</p>
            </div>
        @else
            @foreach ($establishments as $index => $place)
                <x-establishment-card :place="$place" :index="$index" :show-distance="true" />
            @endforeach
        @endif
    </div>
@endsection
