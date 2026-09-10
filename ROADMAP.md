# BakuMeet Roadmap v2 (Faz 18 sonrası)

Faz 6e-18 (keşif/öneri/sosyal özellikler) tamamlandı ve canlıda.
Bundan sonraki hedef: yeni özellik değil, ürünü sağlamlaştırmak,
sonra iş modeline (işletme paneli + görünürlük satışı) geçmek.

## AŞAMA A — Stabilizasyon (yeni özellik YOK)

### A1 — Feature Freeze
Yeni özellik fikirleri direkt kodlanmıyor, "Backlog" bölümüne yazılıyor.

### A2 — Deploy/Seed Temizliği ⭐ (öncelikli, somut hata)
railpack.json her deploy'da DemoDataSeeder'ı çalıştırıyor, bu da sabit
olarak Establishment #1'i hedefliyor. Gerçek işletmeler eklenince bu
anlamsızlaşır/zarar verebilir. Yapılacak: DemoDataSeeder'ı deploy
komutundan çıkar (görevini zaten yaptı). TagSeeder kalabilir (idempotent).

### A3 — Kritik Akış Testleri
15-20 senaryo, Laravel Feature Test: anasayfa, establishments listesi/
detay, /nearby, /wizard, /compare, /trending, /weather, favorite toggle,
review create/delete, auth, yetkisiz kullanıcı review/favorite yapamaz.

### A4 — Mobil UX Turu (henüz redesign değil)
3 akışı telefonda uçtan uca yürü:
1. Anasayfa → Öneri → Detay → Harita → Yol Tarifi → Paylaş
2. Wizard → Sonuç → Compare → Favori
3. Kayıt → Giriş → Review → Favori → Senin İçin
Takılma/gereksiz tıklama varsa mevcut tasarımla (renk değişmeden) düzelt.

## AŞAMA B — Redesign'e Hazırlık

### B1 — Kısmi Gerçek İçerik (15-20 mekan)
Redesign'i düzgün seed veriyle değil, gerçek/düzensiz veriyle (uzun
isim, eksik foto, farklı tag sayısı, farklı saat) yapmak daha sağlam
sonuç verir. 30-50'ye tamamlamadan önce ilk 15-20 gerçek mekanı ekle.

### B2 — Blade Component Temizliği
Establishment kartı ~9 view dosyasında (home, index, trending, wizard/
results, wizard/similar, compare, areas/show, surprise, weather) kopya
HTML olarak duruyor. Redesign'den önce tek bir <x-establishment-card>
component'ine çıkar — tema değişikliği tek dosyadan yapılabilsin.

## 🎨 AŞAMA C — Tasarım Yenileme (UI/UX Redesign)
A ve B bitince yapılır. Tasarımın kendisi ayrı AI'larla hazırlanacak,
implementasyon burada yapılacak. Owner Dashboard'dan ÖNCE olmalı —
yoksa dashboard iki kere tasarlanmış olur.

## AŞAMA D — Gerçek İş Modeli Altyapısı

### D1 — Görsel Yükleme Sistemi
Tek image URL alanından gerçek dosya upload/storage sistemine geçiş.
Owner Dashboard'dan önce şart.

### D2 — Owner/Business Dashboard
users tablosuna rol sistemi, işletme sahibi kendi Establishment
kaydını oluşturur/düzenler: fotoğraf, açıklama, çalışma saatleri
(Faz 7b burada gerçekleşir), tag, sosyal medya linkleri.

### D3 — Claim + Doğrulama
"Bu işletme benim" başvurusu → manuel admin onayı (başlangıçta basit).

### D4 — Analytics
Profil görüntülenme, favoriye eklenme, yol tarifi tıklama, paylaşım
sayacı, işletme sahibine gösterilir.

### D5 — Booster (Görünürlük Satışı) ⚠️ ayrı alt-proje
Ödeme altyapısı + faturalama + muhtemelen resmi işletme kaydı
gerektirir. Geldiğinde ayrıca planlanacak, diğer fazlar gibi hızlı değil.

## AŞAMA E — Saha
- E1: 20-30 gerçek işletmeyle görüşüp ücretsiz listeleme teklif et
- E2: 100-500 gerçek kullanıcı getir, ölç
- E3: Gerçek talep görülürse V2 fikirleri (rezervasyon, sadakat,
  ön sipariş) gündeme gelir — talep yoksa gündeme gelmez

## Backlog / Fikir Havuzu
(Feature freeze sonrası gelen fikirler buraya yazılır, hemen kodlanmaz)
- Faz 7b: opening_hours artık Owner Dashboard (D2) kapsamında ele alınıyor
- Hava durumu önerilerinde "outdoor seating" gibi daha net establishment kriterleri
