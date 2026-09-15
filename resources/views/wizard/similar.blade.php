@extends('layouts.app')

@section('title', 'Senin İçin - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 4px;">Beğendiklerine benzer</p>
        <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 16px;">Favorilerine bakarak seçtiğimiz öneriler.</p>

        @if ($establishments->isEmpty())
            <div class="bk-card" style="padding: 28px 20px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 16px;">Henüz yeterli favori mekanın yok. Birkaç mekanı favorile, sana özel öneriler burada görünecek.</p>
                <a href="/establishments" class="bk-btn-primary" style="display: inline-flex;">Mekanları keşfet</a>
            </div>
        @else
            @foreach ($establishments as $place)
                <x-establishment-card :place="$place" />
            @endforeach
        @endif
    </div>
@endsection
