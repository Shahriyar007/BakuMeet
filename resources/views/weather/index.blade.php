@extends('layouts.app')

@section('title', 'Hava Durumuna Göre - BakuMeet')

@section('content')
    <div>
        <h2>{{ $emoji }} Hava Durumuna Göre Öneriler</h2>

        <div class="card" style="background-color: #ecf0f1; text-align: center;">
            <p style="font-size: 18px; margin: 5px 0;">Bakü şu an: <strong>{{ $condition }}</strong></p>
            @if ($temperature !== null)
                <p style="font-size: 24px; margin: 5px 0;">🌡️ {{ $temperature }}°C</p>
            @endif
        </div>

        <h3 style="margin: 20px 0 10px;">Bugün İçin Önerilerimiz</h3>

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Şu an için uygun öneri bulunamadı.</p>
            </div>
        @else
            @foreach ($establishments as $place)
                <x-establishment-card :place="$place" />
            @endforeach
        @endif
    </div>
@endsection
