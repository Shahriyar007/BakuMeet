@extends('layouts.app')

@section('title', 'Favorilerim - BakuMeet')

@section('content')
    <div>
        <h2>❤️ Favorilerim</h2>

        @if ($favorites->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12; margin-top: 15px;">
                <p>Henüz favori işletmeniz yok.</p>
                <a href="/establishments" class="btn" style="margin-top: 10px;">İşletmeleri Keşfet</a>
            </div>
        @else
            @foreach ($favorites as $place)
                <x-establishment-card :place="$place" />
            @endforeach
        @endif
    </div>
@endsection
