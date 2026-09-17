@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div style="padding-top: 20px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--color-accent-tint); color: var(--color-accent-text-on-tint); display: flex; align-items: center; justify-content: center; font-family: var(--font-heading); font-size: 20px; font-weight: 500;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p style="font-size: 16px; font-weight: 500; color: var(--color-text);">{{ auth()->user()->name }}</p>
                <p style="font-size: 12px; color: var(--color-text-secondary);">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="bk-card" style="padding: 16px; margin-bottom: 14px;">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bk-card" style="padding: 16px; margin-bottom: 14px;">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bk-card" style="padding: 16px; margin-bottom: 14px;">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
