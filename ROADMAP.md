# BakuMeet Roadmap v2 (Faz 18 sonrası)

Faz 6e-18 (keşif/öneri/sosyal özellikler) tamamlandı ve canlıda.
Bundan sonraki hedef: yeni özellik değil, ürünü sağlamlaştırmak,
sonra iş modeline (işletme paneli) geçmek.

Prensip: her zamanki gibi önce özellik/fonksiyon, sonra tasarım.
Bu yüzden Owner Dashboard da mevcut sade stille, organik/adım adım
inşa edilecek — redesign EN SONA, her şey bittikten sonra yapılacak.

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

## AŞAMA B — Gerçek İçerik

### B1 — Kısmi Gerçek İçerik (15-20 mekan)
Uydurma seed veri yerine gerçek Bakü mekanları: isim, konum, saat,
fiyat, foto, tag. 30-50'ye tamamlamadan önce ilk 15-20 tanesi.

## AŞAMA C — Gerçek İş Modeli Altyapısı (organik, sade stille)

### C1 — Görsel Yükleme Sistemi
Tek image URL alanından gerçek dosya upload/storage sistemine geçiş.
Owner Dashboard'dan önce şart.

### C2 — Owner/Business Dashboard (adım adım, fikir geldikçe)
users tablosuna rol sistemi, işletme sahibi kendi Establishment
kaydını oluşturur/düzenler: fotoğraf, açıklama, çalışma saatleri
(Faz 7b burada gerçekleşir), tag, sosyal medya linkleri. Ne
ekranlar/formlar gerekeceği şimdiden tam belli değil — diğer tüm
fazlarda olduğu gibi kullanırken ihtiyaç çıktıkça inşa edilecek.

### C3 — Claim + Doğrulama
"Bu işletme benim" başvurusu → manuel admin onayı (başlangıçta basit).

### C4 — Analytics
Profil görüntülenme, favoriye eklenme, yol tarifi tıklama, paylaşım
sayacı, işletme sahibine gösterilir.

## AŞAMA D — Tasarıma Hazırlık (her şey netleştikten sonra)

### D1 — Blade Component Temizliği
Establishment kartı artık ~9+ view dosyasında (home, index, trending,
wizard/results, wizard/similar, compare, areas/show, surprise, weather,
+ Owner Dashboard sayfaları) kopya HTML olarak duruyor. Redesign'den
önce tek bir <x-establishment-card> component'ine çıkar.

## 🎨 AŞAMA E — Tasarım Yenileme (UI/UX Redesign)
C aşaması (Owner Dashboard dahil her şey) bitince yapılır — artık
tasarlanacak her ekran belli, hiçbir şey iki kere tasarlanmaz.
Tasarımın kendisi ayrı AI'larla hazırlanacak, implementasyon burada
yapılacak.

## AŞAMA F — Saha
- F1: 20-30 gerçek işletmeyle görüşüp ücretsiz listeleme teklif et
- F2: 100-500 gerçek kullanıcı getir, ölç
- F3: Gerçek talep görülürse V2 fikirleri gündeme gelir

## Backlog / Fikir Havuzu
(Feature freeze sonrası gelen fikirler buraya yazılır, hemen kodlanmaz)
- Booster (görünürlük satışı): ödeme altyapısı + faturalama + muhtemelen
  resmi işletme kaydı gerektiren ayrı bir alt-proje, talep/ihtiyaç
  netleşince ayrıca planlanacak
- Hava durumu önerilerinde "outdoor seating" gibi daha net establishment kriterleri
- Rezervasyon, sadakat programı, ön sipariş — sadece gerçek kullanıcı talebi görülürse
