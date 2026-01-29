(function(){
    // Read heroes data from embedded JSON
    var dataEl = document.getElementById('home-heroes-data');
    if(!dataEl) return;
    var heroes = JSON.parse(dataEl.textContent || '[]');
    if(!heroes.length) return;

    var idx = 0;
    var heroEl = document.getElementById('main-hero');
    var heroTitle = document.getElementById('main-hero-title');
    var heroSub = document.getElementById('main-hero-sub');
    var intervalId = null;
    var delay = 6000; // rotate every 6 seconds to allow dramatic animation to complete

    var bg0 = document.getElementById('hero-bg-0');
    var bg1 = document.getElementById('hero-bg-1');
    var heroInner = heroEl ? heroEl.querySelector('.hero-inner') : null;
    var activeLayer = 0; // 0 or 1

    function applyHero(h){
        if(!heroEl || !bg0 || !bg1) return;
        var next = 1 - activeLayer;
        var nextEl = next === 0 ? bg0 : bg1;
        var prevEl = activeLayer === 0 ? bg0 : bg1;

        // hide current text instantly
        if(heroInner){
            heroInner.style.transition = 'none';
            heroInner.style.opacity = 0;
            void heroInner.offsetWidth;
        }

        // preload image to ensure visual sync between image and text
        var img = new Image();
        var done = false;
        var fallbackTimer = setTimeout(function(){ if(!done){ done = true; proceed(); } }, 1200);
        img.onload = function(){ if(done) return; done = true; clearTimeout(fallbackTimer); proceed(); };
        img.onerror = function(){ if(done) return; done = true; clearTimeout(fallbackTimer); proceed(); };
        img.src = h.img;

        function proceed(){
            // set background to next layer (now image is ready or timed out)
            nextEl.style.backgroundImage = "linear-gradient(rgba(5,9,18,0.35), rgba(5,9,18,0.35)), url('" + h.img + "')";

            // update text and fade it in together with image
            if(heroInner){
                // restore transition to desired timing
                heroInner.style.transition = 'opacity 2s cubic-bezier(0.22,0.9,0.35,1)';
                if(heroTitle) heroTitle.textContent = h.title || '';
                if(heroSub) heroSub.textContent = h.sub || '';
                heroInner.style.opacity = 1;
            }

            // crossfade image layer: ensure starting opacity then fade
            nextEl.style.opacity = 0;
            void nextEl.offsetWidth;
            nextEl.style.opacity = 1;

            // after the crossfade transition duration, hide previous layer and switch active
            setTimeout(function(){
                prevEl.style.opacity = 0;
                activeLayer = next;
            }, 2300);
        }
    }

    function updateSmallCards(startIndex){
        for(var k=0;k<4;k++){
            var slot = document.getElementById('small-hero-'+k);
            if(!slot) continue;
            var item = heroes[(startIndex + k) % heroes.length];
            // lazy set background (if not set or different)
            var cur = slot.getAttribute('data-current');
            if(cur !== item.img){
                // mark leaving briefly for smooth swap
                slot.classList.remove('entering');
                slot.classList.add('leaving');
                // small stagger so cards don't all change exactly together
                (function(s,it,k){
                    setTimeout(function(){
                        // update background and text
                        s.style.backgroundImage = "linear-gradient(180deg,rgba(0,0,0,0.08),rgba(0,0,0,0.45)), url('"+it.img+"')";
                        var inner = s.querySelector('.hero-card-inner');
                        if(inner){
                            var h3 = inner.querySelector('h3');
                            var p = inner.querySelector('p');
                            if(h3) h3.textContent = it.title || '';
                            if(p) p.textContent = it.sub || '';
                        }
                        s.setAttribute('data-current', it.img);
                        // trigger entering animation
                        s.classList.remove('leaving');
                        // force reflow then add entering to animate
                        void s.offsetWidth;
                        s.classList.add('entering');
                    }, 180 * k + 120); // stagger: 120ms, 300ms, 480ms, ... (more dramatic)
                })(slot, item, k);
            }
        }
    }

    function show(i){
        var h = heroes[i % heroes.length];
        applyHero(h);
        // small cards should show next 4 items after current big
        updateSmallCards(i + 1);
    }

    function start(){
        if(intervalId) return;
        intervalId = setInterval(function(){ idx = (idx + 1) % heroes.length; show(idx); }, delay);
    }
    function stop(){ if(intervalId){ clearInterval(intervalId); intervalId = null; } }

    // pause on hover
    if(heroEl){
        heroEl.addEventListener('mouseenter', stop);
        heroEl.addEventListener('mouseleave', start);
    }

    // initial
    show(idx);
    start();

})();
