<nav class="global-nav">
    <style>
    /* fixed top navigation so it spans full width on all pages */
    .global-nav{background:#fff;border-bottom:1px solid #e6e6e6;position:fixed;top:0;left:0;right:0;z-index:999}
    .global-nav .nav-inner{max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;padding:10px 16px;gap:12px}
    .nav-left{display:flex;align-items:center;gap:10px}
    .brand{display:flex;align-items:center;gap:8px;text-decoration:none;color:inherit}
    .brand-logo{width:36px;height:36px;object-fit:contain}
    .brand-text{font-weight:600;font-size:16px}
    .nav-center{flex:1;display:flex;align-items:center;justify-content:center;gap:20px}
    .nav-links{display:flex;gap:16px;list-style:none;margin:0;padding:0}
    .nav-links a{color:#111;text-decoration:none;padding:6px 8px;border-radius:6px}
    .nav-links a:hover{background:#f3f4f6}
    .nav-search{min-width:220px}
    .nav-search-input{width:100%;padding:8px 10px;border-radius:999px;border:1px solid #e5e7eb}
    .nav-right{display:flex;align-items:center;gap:8px}
    .nav-form-inline{display:inline}
    .nav-actions{display:flex;gap:8px}
    .nav-btn{padding:6px 10px;border-radius:8px;text-decoration:none;color:#111;border:1px solid transparent}
    .nav-btn-primary{background:#2563eb;color:#fff}
    .nav-btn-ghost{background:#ef4444;color:#fff;border:1px solid transparent}
    .nav-user{display:flex;align-items:center;gap:8px;text-decoration:none;color:inherit}
    .nav-avatar{width:36px;height:36px;border-radius:9999px;object-fit:cover}
    .nav-avatar.placeholder{display:flex;align-items:center;justify-content:center;background:#eef2ff;color:#2563eb}
    .nav-username{font-size:14px}
    @media (max-width:900px){.nav-center{display:none}.nav-search{display:none}.nav-toggle{display:block}}

    /* mobile menu */
    .nav-toggle{display:none;background:transparent;border:0;padding:6px;border-radius:8px;cursor:pointer}
    .nav-toggle:focus{outline:2px solid rgba(37,99,235,0.12);outline-offset:2px}
    .nav-toggle .bar{display:block;width:22px;height:2px;background:#111;border-radius:2px;margin:4px 0;transition:transform 250ms cubic-bezier(.2,.8,.2,1),opacity 200ms ease}
    /* animated open state */
    .global-nav.nav-open .nav-toggle .bar:nth-child(1){transform:translateY(6px) rotate(45deg)}
    .global-nav.nav-open .nav-toggle .bar:nth-child(2){opacity:0;transform:scaleX(0.6)}
    .global-nav.nav-open .nav-toggle .bar:nth-child(3){transform:translateY(-6px) rotate(-45deg)}
    .nav-mobile{display:none;background:#fff;border-top:1px solid #eee}
    .global-nav.nav-open .nav-mobile{display:block}
    /* ensure toggle visible on small screens (override later defaults) */
    @media (max-width:900px){
        .nav-toggle{display:block}
        .nav-center{display:none}
        .nav-search{display:none}
    }

    /* add top padding to body so fixed nav doesn't cover content */
    body{padding-top:64px}
    </style>
    <div class="nav-inner">
        <div class="nav-left">
            <a href="{{ url('/') }}" class="brand">
                <img src="/build/assets/logo.png" alt="logo" class="brand-logo" onerror="this.style.display='none'">
                <span class="brand-text">Journey</span>
            </a>
        </div>

        <div class="nav-center">
            <ul class="nav-links">
                <li><a href="/">首页</a></li>
                <li><a href="{{ route('discovery') }}">发现</a></li>
                <li><a href="{{ route('posts.create') }}">发布</a></li>
                <li><a href="/profile">我的</a></li>
            </ul>
            <!-- <div class="nav-search">
                <form action="/search" method="GET">
                    <input name="q" type="search" placeholder="搜索..." class="nav-search-input" />
                </form>
            </div> -->
        </div>

        <div class="nav-right">
            <button class="nav-toggle" aria-label="菜单" onclick="toggleNav()">
                <span class="bar" aria-hidden="true"></span>
                <span class="bar" aria-hidden="true"></span>
                <span class="bar" aria-hidden="true"></span>
            </button>
            @auth
                <a href="{{ route('profile') }}" class="nav-user">
                    @if(optional(auth()->user())->avatar)
                        <img src="{{ optional(auth()->user())->avatar_url }}" alt="avatar" class="nav-avatar" />
                    @else
                        <div class="nav-avatar placeholder">{{ strtoupper(substr(optional(auth()->user())->username ?? 'U',0,1)) }}</div>
                    @endif
                    <span class="nav-username">{{ optional(auth()->user())->nickname ?? optional(auth()->user())->username }}</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="nav-form-inline">
                    @csrf
                    <button type="submit" class="nav-btn nav-btn-ghost">登出</button>
                </form>
            @else
                <div class="nav-actions">
                    <a href="{{ route('login') }}" class="nav-btn">登录</a>
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">注册</a>
                </div>
            @endauth
        </div>
    </div>
    <div class="nav-mobile" id="nav-mobile">
        <div style="max-width:1100px;margin:0 auto;padding:12px 16px;">
            <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:8px;">
                <li><a href="/">首页</a></li>
                <li><a href="{{ route('discovery') }}">发现</a></li>
                <li><a href="{{ route('posts.create') }}">发布</a></li>
                <li><a href="/profile">我的</a></li>
            </ul>
            <!-- <div style="margin-top:10px">
                <form action="/search" method="GET">
                    <input name="q" type="search" placeholder="搜索..." style="width:100%;padding:8px 10px;border-radius:8px;border:1px solid #e5e7eb" />
                </form>
            </div> -->
            <div style="margin-top:12px;">
                @auth
                    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;color:inherit">
                        @if(optional(auth()->user())->avatar)
                            <img src="{{ optional(auth()->user())->avatar_url }}" alt="avatar" style="width:36px;height:36px;border-radius:9999px;object-fit:cover" />
                        @else
                            <div style="width:36px;height:36px;border-radius:9999px;background:#eef2ff;color:#2563eb;display:flex;align-items:center;justify-content:center">{{ strtoupper(substr(optional(auth()->user())->username ?? 'U',0,1)) }}</div>
                        @endif
                        <span>{{ optional(auth()->user())->nickname ?? optional(auth()->user())->username }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;margin-left:8px">
                        @csrf
                        <button type="submit" class="nav-btn nav-btn-ghost">登出</button>
                    </form>
                @else
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('login') }}" class="nav-btn">登录</a>
                        <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">注册</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <script>
    function toggleNav(){
        var nav = document.querySelector('.global-nav');
        if(!nav) return;
        nav.classList.toggle('nav-open');
    }
    // optional: close mobile menu when clicking outside
    document.addEventListener('click', function(e){
        var nav = document.querySelector('.global-nav');
        if(!nav) return;
        if(!nav.contains(e.target) && nav.classList.contains('nav-open')){
            nav.classList.remove('nav-open');
        }
    });
    </script>
</nav>
<script type="module" src="/build/assets/app-CWpXuHPD.js"></script>
