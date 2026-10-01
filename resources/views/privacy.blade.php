@extends('layouts.app')

@section('title', 'Məxfilik Siyasəti – BakuMeet')

@section('content')
<style>
    .pp { padding: 20px 0 40px; line-height: 1.6; }
    .pp h2 { font-size: 16px; font-weight: var(--weight-medium); margin: 22px 0 6px; }
    .pp p, .pp li { font-size: var(--text-secondary); }
    .pp ul { margin: 6px 0 0 18px; }
    .pp li { margin-bottom: 6px; }
</style>
<div class="pp">
    <h1 class="heading" style="font-size: 24px; margin-bottom: 4px;">Məxfilik Siyasəti</h1>
    <p style="color: var(--color-text-secondary);">Son yenilənmə: 1 oktyabr 2026</p>

    <h2>1. Giriş</h2>
    <p>BakuMeet Bakıdakı restoran və kafeləri məkana və əhval-ruhiyyəyə görə kəşf etməyə kömək edən xidmətdir. Bu siyasət xidmətdən istifadə zamanı hansı məlumatların toplandığını, nə üçün istifadə olunduğunu və hüquqlarınızı izah edir.</p>

    <h2>2. Topladığımız məlumatlar</h2>
    <ul>
        <li><strong>Hesab məlumatları:</strong> qeydiyyatdan keçdikdə adınız, e-poçt ünvanınız və şifrəniz. Şifrə düz mətn kimi deyil, şifrələnmiş (hash) formada saxlanılır.</li>
        <li><strong>Biznes hesabları:</strong> müəssisə sahibləri üçün ad, e-poçt, şifrə, müəssisə məlumatları (ad, ünvan, iş saatları və s.) və yüklənən fotoşəkillər.</li>
        <li><strong>İstifadəçi məzmunu:</strong> yazdığınız rəylər və reytinqlər, seçilmişlərə əlavə etdiyiniz məkanlar. Rəyləriniz adınızla digər istifadəçilərə görünür.</li>
        <li><strong>Məkan:</strong> "yaxınlıqda" və tövsiyə funksiyaları üçün yalnız siz icazə verdikdə cihazınızın məkanı istifadə olunur. İcazəni istənilən vaxt brauzer və ya telefon ayarlarından geri ala bilərsiniz. Məkanınızı hesabınıza bağlı şəkildə saxlamırıq.</li>
        <li><strong>Texniki məlumatlar:</strong> IP ünvanı və brauzer məlumatı (sessiyanın işləməsi və təhlükəsizlik üçün). Müəssisə səhifələrinin neçə dəfə baxıldığını saymaq üçün təsadüfi anonim identifikator (kuki) və IP ünvanı saxlanılır.</li>
    </ul>

    <h2>3. Kukilər</h2>
    <p>Sayt sessiyanı idarə etmək, formaları qorumaq və baxış statistikasını saymaq üçün kukilərdən istifadə edir. Reklam məqsədli kuki istifadə etmirik.</p>

    <h2>4. Üçüncü tərəf xidmətlər</h2>
    <p>Xidmətin işləməsi üçün aşağıdakı provayderlərdən istifadə edirik. Onlar xidməti göstərmək üçün məlumatın bir hissəsini (məsələn, IP ünvanını) qəbul edə bilər:</p>
    <ul>
        <li>Railway – saytın yerləşdirilməsi və verilənlər bazası</li>
        <li>Cloudflare R2 – fotoşəkillərin saxlanılması</li>
        <li>Resend – şifrə bərpası və təsdiq e-poçtlarının göndərilməsi</li>
        <li>Sentry – xətaların aşkarlanması</li>
        <li>Open-Meteo – hava proqnozu</li>
        <li>OpenStreetMap və Leaflet – xəritə</li>
        <li>Google Fonts – şriftlər</li>
    </ul>

    <h2>5. Məlumatlardan istifadə məqsədi</h2>
    <p>Məlumatları yalnız xidməti göstərmək, hesabınızı qorumaq, rəy və seçilmişlər kimi funksiyaları işlətmək, müəssisə sahiblərinə səhifə baxışı statistikasını göstərmək və xətaları düzəltmək üçün istifadə edirik. Şəxsi məlumatlarınızı satmırıq və reklam məqsədilə üçüncü tərəflərlə paylaşmırıq.</p>

    <h2>6. Saxlama müddəti</h2>
    <p>Hesab məlumatlarınız hesabınız aktiv olduğu müddətdə saxlanılır. Hesabı sildikdə ona bağlı şəxsi məlumatlar, o cümlədən rəylər və seçilmişlər silinir.</p>

    <h2>7. Hüquqlarınız</h2>
    <p>Məlumatlarınıza giriş, düzəliş və silinmə tələb edə bilərsiniz. İstifadəçi hesabınızı profil səhifəsindən özünüz silə bilərsiniz. Biznes hesabının silinməsi və digər sorğular üçün aşağıdakı e-poçt ünvanına yazın. Azərbaycan Respublikasının fərdi məlumatlar haqqında qanunvericiliyinə uyğun hərəkət etməyə çalışırıq.</p>

    <h2>8. Uşaqlar</h2>
    <p>Xidmət 13 yaşdan kiçik uşaqlar üçün nəzərdə tutulmayıb və onlardan bilərəkdən məlumat toplamırıq.</p>

    <h2>9. Dəyişikliklər</h2>
    <p>Bu siyasət vaxtaşırı yenilənə bilər. Yeni versiya bu səhifədə yuxarıdakı tarixlə dərc olunur.</p>

    <h2>10. Əlaqə</h2>
    <p>Suallar və sorğular üçün: <strong>bakumeetgroup@gmail.com</strong></p>
</div>
@endsection
