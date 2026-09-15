<x-guest-layout>
    <p class="heading" style="font-size: 22px; margin-bottom: 4px; text-align: center;">BakuMeet'e hoş geldin</p>
    <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); text-align: center; margin-bottom: 24px;">Nasıl devam etmek istersin?</p>

    <a href="{{ route('login') }}" style="text-decoration: none;">
        <div class="bk-card" style="padding: 16px; margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--color-accent-tint); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="ti ti-compass" style="font-size: 20px; color: var(--color-accent);" aria-hidden="true"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 2px;">Mekan keşfetmek istiyorum</p>
                <p style="font-size: var(--text-meta); color: var(--color-text-secondary);">Öneriler al, favorile, yorum yap</p>
            </div>
            <i class="ti ti-chevron-right" style="color: var(--color-text-secondary);" aria-hidden="true"></i>
        </div>
    </a>

    <a href="{{ route('owner.login') }}" style="text-decoration: none;">
        <div class="bk-card" style="padding: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--color-bg-muted); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="ti ti-building-store" style="font-size: 20px; color: var(--color-text-muted);" aria-hidden="true"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 2px;">İşletmemi yönetmek istiyorum</p>
                <p style="font-size: var(--text-meta); color: var(--color-text-secondary);">Profilini oluştur, fotoğraf ekle</p>
            </div>
            <i class="ti ti-chevron-right" style="color: var(--color-text-secondary);" aria-hidden="true"></i>
        </div>
    </a>

    <div style="text-align: center;">
        <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: var(--text-secondary); color: var(--color-text-secondary); text-decoration: none;">
            <i class="ti ti-arrow-right" aria-hidden="true"></i>Önce göz atmak istiyorum
        </a>
    </div>
</x-guest-layout>
