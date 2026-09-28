{{-- resources/views/components/splash.blade.php --}}
<style>
#bk-splash{position:fixed;inset:0;z-index:99999;overflow:hidden;background:#F1E6DA;display:flex;align-items:center;justify-content:center}
#bk-splash-logo{position:relative;z-index:2;width:min(62vw,420px);height:auto;overflow:visible;opacity:0;transform:scale(.92)}
#bk-splash-page{position:absolute;z-index:1;left:50%;top:50%;width:26vw;max-width:170px;height:17vw;max-height:110px;background:#FBF6F0;border-radius:12px;transform:translate(-50%,-50%);opacity:0;box-shadow:0 10px 36px rgba(60,30,10,.16)}
#bk-l-terra{transform-box:fill-box;transform-origin:50% 100%}

#bk-splash.play #bk-splash-logo{animation:bkLogoIn .7s cubic-bezier(.2,.8,.2,1) forwards,bkLogoOut .5s 2.3s ease forwards}
#bk-splash.play #bk-l-terra{animation:bkFlap .5s .8s cubic-bezier(.4,0,.2,1) forwards}
#bk-splash.play #bk-splash-page{animation:bkPage 1.3s 1.05s cubic-bezier(.55,0,.25,1) forwards}
#bk-splash.done{opacity:0;visibility:hidden;transition:opacity .3s ease,visibility 0s .3s}

@keyframes bkLogoIn{to{opacity:1;transform:scale(1)}}
@keyframes bkFlap{0%{transform:translateY(0)}100%{transform:translateY(-6%)}}
@keyframes bkPage{
  0%{opacity:0;transform:translate(-50%,-50%) scale(.6)}
  12%{opacity:1;transform:translate(-50%,-50%) scale(1)}
  100%{opacity:1;width:100vw;height:100vh;max-width:none;max-height:none;border-radius:0;transform:translate(-50%,-50%) scale(1);box-shadow:none}
}
@keyframes bkLogoOut{to{opacity:0;transform:scale(.85)}}
@media (prefers-reduced-motion:reduce){#bk-splash{display:none!important}}

</style>

<script>
  // Splash sadece oturum basina 1 kez calissin (sayfa gecislerinde tekrar oynamasin)
  (function () {
    try {
      if (sessionStorage.getItem('bk_splash_seen')) {
        document.documentElement.classList.add('bk-no-splash');
      }
    } catch (e) {}
  })();
</script>
<style>.bk-no-splash #bk-splash{display:none!important}</style>

<div id="bk-splash" aria-hidden="true">
  <div id="bk-splash-page"></div>
  <svg id="bk-splash-logo" viewBox="244 298 512 404" xmlns="http://www.w3.org/2000/svg">
    <path id="bk-l-black" fill="#000000" d="M 740.976562 359.167969 C 729.625 328.074219 700.902344 307.980469 667.796875 307.980469 L 254.183594 307.980469 L 254.183594 692.019531 L 289.742188 692.019531 L 289.742188 363.621094 L 441.019531 491.09375 L 442.78125 489.617188 L 468.621094 467.84375 L 321.097656 343.539062 L 667.796875 343.539062 C 689.640625 343.539062 702.664062 357.914062 707.578125 371.367188 C 712.484375 384.816406 711.785156 404.195312 695.089844 418.269531 L 635.804688 468.21875 L 661.65625 489.988281 L 663.40625 491.464844 L 717.996094 445.460938 C 743.316406 424.132812 752.328125 390.253906 740.976562 359.167969"/>
    <path id="bk-l-terra" fill="#D06E51" d="M 740.535156 640.832031 C 729.179688 671.925781 700.449219 692.019531 667.351562 692.019531 L 415.699219 692.019531 L 415.699219 656.460938 L 667.351562 656.460938 C 689.1875 656.460938 702.21875 642.085938 707.125 628.632812 C 712.042969 615.183594 711.339844 595.796875 694.636719 581.722656 L 635.8125 532.152344 L 625.464844 523.433594 L 552.433594 584.96875 L 478.960938 523.058594 L 468.613281 531.78125 L 303.078125 671.269531 L 303.078125 624.777344 L 441.019531 508.535156 L 451.367188 499.8125 L 478.960938 476.566406 L 552.433594 538.476562 L 625.464844 476.941406 L 653.058594 500.1875 L 663.40625 508.90625 L 717.554688 554.539062 C 742.863281 575.863281 751.886719 609.746094 740.535156 640.832031"/>
  </svg>
</div>


<script>
  (function () {
    var el = document.getElementById('bk-splash');
    if (!el) return;
    if (document.documentElement.classList.contains('bk-no-splash')) { el.remove(); return; }
    try { sessionStorage.setItem('bk_splash_seen', '1'); } catch (e) {}
    requestAnimationFrame(function () { el.classList.add('play'); });
    // animasyon bitince tamamen kaldir (toplam ~2.9sn)
    setTimeout(function () { el.classList.add('done'); }, 2850);
    setTimeout(function () { el.remove(); }, 3300);
  })();
</script>
