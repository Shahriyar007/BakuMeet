// BakuMeet Service Worker
// Amaç: PWA kalite kriterini (Lighthouse) geçmek ve temel çevrimdışı
// destek sağlamak. Dinamik veri içeren sayfalar (restoran listeleri,
// arama sonuçları vb.) kasıtlı olarak önbelleğe alınmıyor; sadece
// statik varlıklar (ikonlar, manifest) ve en son ziyaret edilen sayfa
// önbelleğe alınıyor.

const CACHE_NAME = 'bakumeet-v1';

// Uygulama kurulurken önbelleğe alınacak temel dosyalar.
const PRECACHE_URLS = [
  '/manifest.json',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
];

// Kurulum: temel dosyaları önbelleğe al.
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(PRECACHE_URLS))
  );
  self.skipWaiting();
});

// Aktivasyon: eski sürüm önbelleklerini temizle.
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys
          .filter((key) => key !== CACHE_NAME)
          .map((key) => caches.delete(key))
      )
    )
  );
  self.clients.claim();
});

// Fetch: sadece GET isteklerine dokun. Ağ öncelikli, ağ başarısız
// olursa önbellekten dön; hiçbiri yoksa tarayıcının kendi hata
// sayfasına düş. Dinamik sayfa istekleri (API, form gönderimleri vb.)
// bu stratejiden etkilenmez çünkü sadece başarılı GET yanıtları
// önbelleğe eklenir ve önbellek yalnızca ağ hatasında devreye girer.
self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') {
    return;
  }

  event.respondWith(
    fetch(event.request)
      .then((response) => {
        const responseClone = response.clone();
        caches.open(CACHE_NAME).then((cache) => {
          cache.put(event.request, responseClone);
        });
        return response;
      })
      .catch(() => caches.match(event.request))
  );
});
