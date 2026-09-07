# BakuMeet Projesi - Devir Dokümanı

Bu dokümanı yeni bir AI sohbetine (ChatGPT, Gemini, Claude vb.) yapıştır ve
"Bu projeye kaldığım yerden devam ettir, yeni değişiklik yapmadan önce
mutlaka bu bağlamı oku" diye başla.

## Kullanıcı Ortamı
- Kullanıcı SADECE Android telefon kullanıyor, laptop/bilgisayarı YOK
- Kod ortamı: Termux, proje klasörü ~/BakuMeet
- Editör: nano (grafik arayüz yok)
- Kullanıcı Türkçe konuşuyor, yanıtlar Türkçe olmalı
- Komutları açıklayarak, adım adım anlat

## Proje Fikri
"BakuMeet" — Bakü'deki restoran ve kafeleri, konum ve ruh haline
(romantik, sakin, canlı, lüks, bütçedostu) göre öneren Laravel uygulaması.
(Not: Antikafe kapsam dışı bırakıldı, ileride eklenebilir)

## Teknik Kararlar
- Backend: Laravel
- Veritabanı: Production'da PostgreSQL (Railway), geliştirmede SQLite kullanıldı
- Mimari: Repository Pattern + Service Layer (Controller → Service → Repository → Model)
- Tek "Establishment" modeli, type enum (restaurant/cafe) — ileride bar/anti_cafe eklenebilir

## DURUM: TÜM FAZLAR TAMAMLANDI ✅ — PROJE CANLIDA

**Live URL:** https://bakumeet-production.up.railway.app

### Faz 1 — Temel Mimari ✅
Establishment modeli, migration, Repository Interface + Eloquent Repository,
Service, Controller, Routes, Views (index+show), Seeder (10 örnek işletme)

### Faz 2 — Filtreleme ✅
filterByLocation() ve filterByMood() metodları, filtre formu (dropdown)

### Faz 3 — Harita ✅
Leaflet.js (Google Maps değil — ücretsiz, kota sınırsız), /establishments/map/view,
renkli pinler (kırmızı=restoran, yeşil=kafe), popup detayları

### Faz 4 — Kullanıcı Etkileşimi ✅
- Laravel Breeze (auth: register/login/logout)
- Review sistemi (yorum + 1-5 puan), auth-korumalı
- Favoriler (many-to-many pivot tablo, toggle sistemi)

### Faz 5 — Deploy ✅
- Görsel placeholder sistemi (resim yoksa emoji+renkli kutu)
- Railway'e deploy edildi (GitHub bağlantılı, CI/CD otomatik)
- PostgreSQL veritabanı eklendi (production)
- Public domain: bakumeet-production.up.railway.app

## ÖNEMLİ NOTLAR (İleride Devam Edilirse)

1. **APP_KEY, APP_URL vb.** Railway "Variables" sekmesinde manuel girilmiş
   (.env gitignore'da olduğu için GitHub'dan taşınmaz)

2. **PHP versiyonu:** composer.json ve nixpacks.toml'da PHP 8.4 pinlenmiş
   (Railway varsayılanı 8.3 idi, proje 8.4+ istiyor)

3. **Procfile YOK** — silindi çünkü nixpacks.toml ile çakışıyordu
   (Procfile'da eski Heroku komutu vardı: vendor/bin/heroku-php-apache2)

4. **preDeployCommand:** sadece `php artisan migrate --force` olmalı.
   Seed data eklemek gerekirse GEÇİCİ olarak `&& php artisan db:seed --force`
   eklenip, bir deploy sonrası MUTLAKA geri kaldırılmalı (yoksa duplicate veri)

5. **CI/CD çalışıyor:** main branch'e push = otomatik Railway deploy.
   Eğer bir noktada otomatik deploy durursa, Railway servisinin bir commit'e
   "pinlenmiş" olabileceğini kontrol et (Settings → Source)

6. Category/Mood için ayrı tablo yapılmadı, hâlâ establishments tablosunda
   string sütun olarak duruyor — ileride refactor edilebilir

## OLASI SIRADAKI ADIMLAR (Opsiyonel)
- Anti-cafe/Bar türü eklenmesi (mimari hazır, sadece type enum'a ekleme yeterli)
- Gerçek görsel yükleme sistemi (şu an placeholder emoji kullanılıyor)
- Category/Mood için ayrı tablolara geçiş (refactor)
