# BakuMeet Roadmap — Faz 6e ve Sonrası

## Vizyon
BakuMeet bir restaurant directory değil, bir discovery/recommendation
uygulaması. Ana soru: "Nereye gideyim?" — buna mümkün olduğunca kolay
cevap vermek. Şimdilik lokal kullanıcılara odaklanıyoruz (turist modu,
çoklu dil sonraki evrede).

## Öncelik Dışı (Şimdilik Yapılmayacak)
- Chatbot, gereksiz AI özellikleri
- Ödeme sistemi
- Karmaşık sosyal ağ
- Turist özellikleri, çoklu dil
- Gereksiz admin panelleri

## FAZ 6e — Geolocation / Yakınımdakiler
Fayda: "Bana en yakın nerede" sorusuna cevap, mesafeye göre sıralama
(500m/1km/3km/5km), mevcut mood/price/type filtreleriyle birlikte çalışır.
Zorluk: Medium — Katkı: High
Neden ilk: lat/long altyapısı zaten var (haritada kullanıldı), birçok
sonraki özelliğin (Wizard, Explore by Area) temeli.

## FAZ 7 — Açık mı? (Open Now / Çalışma Saatleri) ⭐
Yeni alan: opening_hours. Fayda: kapalı bir yere yönlendirme riskini
ortadan kaldırır — "nereye gideyim" sorusunun en kritik parçası.
Zorluk: Medium — Katkı: High
## FAZ 7b — İşletme Sahibi Paneli (Owner Dashboard) ⭐
İşletme sahiplerinin kendi mekanlarını yönetebileceği panel: çalışma
saatleri (opening_hours), fotoğraf, açıklama güncelleme. Faz 7'de
altyapı (opening_hours alanı + gösterim) hazırlandı, gerçek veri
girişi burada olacak. Rol sistemi (owner/admin) gerektirir.
Zorluk: Medium-Hard — Katkı: High (gerçek veri kaynağı)

## FAZ 8 — Tags / Özellikler ⭐
Wi-Fi, Laptop Friendly, Outdoor, Live Music, Open Late, Pet Friendly,
Family Friendly, Quiet, Good for Studying vb. Yeni tablo: tags +
establishment_tag pivot (Collection'a benzer yapı).
Fayda: "çalışabileceğim bir yer" gibi somut ihtiyaçla arama.
Zorluk: Medium — Katkı: High

## FAZ 9 — Bölgeye Göre Keşfet (Explore by Area)
Her semt için ayrı sayfa: işletmeler + istatistik + mini harita +
ilgili koleksiyonlar. Zorluk: Medium — Katkı: Medium-High

## FAZ 10 — Trending / Popüler
rating + review_count + favorite_count ağırlıklı skor (sadece puana
değil gerçek ilgiye göre). Zorluk: Easy-Medium — Katkı: Medium

## FAZ 11 — Recommendation Wizard ⭐⭐
Birkaç soru: ne yapmak istiyorsun / bütçe / nerede / yakın mı olsun →
uygun mekanları önerir. Tags, geolocation, price_range, mood — hepsi
hazır, wizard bunları birleştiren arayüz.
Zorluk: Medium-Hard — Katkı: High (en güçlü differentiator)

## FAZ 12 — Sürpriz Bana (Surprise Me) ⭐
Wizard'ın tek-tık versiyonu, filtrelere göre ağırlıklı rastgele öneri.
Zorluk: Easy — Katkı: Medium-High

## FAZ 13 — "Beğendiklerine Benzer" ⭐
Favoriler/yorumlara bakıp benzer mood/tag'li yerler önerme (kural
bazlı, henüz ML değil — basit versiyon).
Zorluk: Medium — Katkı: Medium-High

## FAZ 14 — Review Alt Puanları
Atmosphere / Food / Service / Value ayrı puanlar, genel rating bunların
ortalaması. Zorluk: Medium — Katkı: Medium

## FAZ 15 — Koleksiyonlar → Rotalar ⭐
Collection'lara sıra/adım eklenir (Cafe A → Cafe B → yürüyüş noktası).
Zorluk: Medium-Hard — Katkı: Medium-High

## FAZ 16 — Hızlı Karşılaştır
2-3 mekanı yan yana karşılaştırma (puan, fiyat, mesafe, tag).
Zorluk: Easy-Medium — Katkı: Medium

## FAZ 17 — Hava Durumuna Duyarlı Öneriler ⭐
Yağmurluysa kapalı/sakin, güneşliyse açık hava önerisi (basit weather
API). Zorluk: Medium — Katkı: Medium

## FAZ 18 — Paylaş
Basit link ile paylaşım (karmaşık sosyal ağ değil).
Zorluk: Easy — Katkı: Medium

## Backlog (Sırası Belirsiz, İleride)
- Grup modu / oylama (arkadaşlarla karar verme) — Hard
- Arama uyarıları (yeni eklenen yer bildirimleri) — Medium
- Gerçek görsel yükleme sistemi — ayrı faz olarak planlanacak
- Derin kişiselleştirme (ML tabanlı) — çok ileride
- Çoklu dil, turist modu, chatbot, ödeme — kapsam dışı
