<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>首页</title>
    <link rel="stylesheet" href="/build/assets/app.css">
    <style>
    :root{--bg:#f8fafc;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .container{max-width:920px;margin:24px auto;padding:20px}
    .card{background:var(--card);border-radius:12px;padding:20px;box-shadow:0 6px 20px rgba(16,24,40,0.06)}
    .row{display:flex;align-items:center;gap:16px}
    .avatar-placeholder{width:64px;height:64px;border-radius:9999px;background:#e9eefb;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid #e6eefc}
    .user-title{font-size:18px;font-weight:600}
    .muted{color:var(--muted);font-size:13px}
    .btn-logout{background:#ef4444;color:#fff;padding:8px 10px;border-radius:8px;border:0;cursor:pointer}
    .hero{height:68vh;min-height:420px;position:relative;display:flex;align-items:center;justify-content:center;color:#fff;overflow:hidden}
    .hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;transition:opacity 2.2s cubic-bezier(0.22,0.9,0.35,1);will-change:opacity;}
    .hero-bg[style]{background-repeat:no-repeat}
    .hero-inner{position:relative;z-index:3;max-width:980px;padding:40px;text-align:center;transition:opacity 2s cubic-bezier(0.22,0.9,0.35,1)}
    .hero-title{font-size:44px;margin:0;font-weight:800;letter-spacing:1px;text-shadow:0 6px 18px rgba(5,9,18,0.6)}
    .hero-sub{margin-top:12px;font-size:18px;opacity:0.95;text-shadow:0 4px 12px rgba(5,9,18,0.45)}
    .hero-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:18px;margin-top:12px}
    .hero-card{position:relative;height:260px;border-radius:12px;overflow:hidden;background-size:cover;background-position:center;display:flex;align-items:flex-end;color:#fff}
    .hero-card-inner{padding:16px;background:linear-gradient(180deg,transparent,rgba(0,0,0,0.45));width:100%}
    .hero-card h3{margin:0;font-size:18px;font-weight:700}
    .hero-card p{margin:6px 0 0;font-size:13px;opacity:0.95}
    /* Dramatic small-card entrance: slower translate + scale + deeper shadow */
    .hero-card{transform:translateY(14px) scale(0.99);opacity:0.94;transition:transform 900ms cubic-bezier(0.22,0.9,0.35,1),opacity 640ms ease,box-shadow 640ms ease}
    .hero-card.entering{transform:translateY(0) scale(1);opacity:1;box-shadow:0 18px 48px rgba(16,24,40,0.18)}
    .hero-card.leaving{transform:translateY(-12px) scale(0.98);opacity:0.75}
    .hero-card:hover{transform:translateY(0) scale(1.03);box-shadow:0 20px 60px rgba(16,24,40,0.2)}
    .hero.fade-out .hero-inner{opacity:0;transition:opacity .32s ease}
    .hero-inner{transition:opacity .4s ease}
    .hero-card{transition:opacity .36s ease, transform .36s ease}
    </style>
</head>
<body>
    @include('partials.navbar')
    <section id="main-hero" class="hero">
        <div id="hero-bg-0" class="hero-bg" style="background-image:linear-gradient(rgba(5,9,18,0.35), rgba(5,9,18,0.35)), url('{{ $rotating[0]['img'] ?? asset('images/antarctica.webp') }}'); opacity:1"></div>
        <div id="hero-bg-1" class="hero-bg" style="background-image:linear-gradient(rgba(5,9,18,0.35), rgba(5,9,18,0.35)), url('{{ $rotating[1]['img'] ?? asset('images/great-wall.jpg') }}'); opacity:0"></div>
        <div class="hero-inner">
            <h1 id="main-hero-title" class="hero-title">{{ $rotating[0]['title'] ?? '生机昂然的南极洛' }}</h1>
            <p id="main-hero-sub" class="hero-sub">{{ $rotating[0]['sub'] ?? '探索极地的美与生命力 — 欢迎来到我们的世界' }}</p>
        </div>
    </section>
    @php
        // 国内推荐路线（请把这些图片放在 public/images/ 下）
        $heroes = [
            ['img' => asset('images/great-wall.jpg'), 'title' => '长城（古道长行）', 'sub' => '沿着古老的城墙徒步，感受历史与山河的交融'],
            ['img' => asset('images/tiger-leaping-gorge.jpg'), 'title' => '虎跳峡', 'sub' => '滔滔江水与峡谷壁立，充满挑战的峡谷徒步'],
            ['img' => asset('images/dao-cheng-yading.jpg'), 'title' => '稻城亚丁', 'sub' => '雪山、草甸与湖泊构成的绝美高原徒步胜地'],
            ['img' => asset('images/huangshan.jpg'), 'title' => '黄山云海步道', 'sub' => '奇松怪石与云海日出，是摄影与徒步的经典线路'],
        ];

        // 合并大图（南极洛）到循环数组的开头
        $rotating = array_merge([
            ['img' => asset('images/antarctica.webp'), 'title' => '生机昂然的南极洛', 'sub' => '探索极地的美与生命力 — 欢迎来到我们的世界']
        ], $heroes);
    @endphp

    <section class="hero-grid-section" style="padding:28px 12px">
        <div class="container" style="max-width:1200px">
            <div class="hero-grid">
                {{-- 小卡只显示 4 个（包含南极洛），初始显示 rotating[0..3] --}}
                @for($i = 0; $i < 4; $i++)
                    @php $item = $rotating[($i + 1) % count($rotating)]; @endphp
                    <div id="small-hero-{{ $i }}" class="hero-card" data-img="{{ $item['img'] }}" style="background-image:linear-gradient(180deg,rgba(0,0,0,0.08),rgba(0,0,0,0.45)), url('{{ $item['img'] }}')">
                        <div class="hero-card-inner">
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['sub'] }}</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- 传递数据给外部脚本 --}}
    <script id="home-heroes-data" type="application/json">{!! json_encode($rotating) !!}</script>
    <script src="{{ asset('js/home-hero.js') }}" defer></script>

    <!-- <div class="container">
        <div class="card">
            <div class="row">
            <div class="avatar-placeholder">
                @auth
                    @if(optional(auth()->user())->avatar)
                        <img src="{{ optional(auth()->user())->avatar_url }}" alt="avatar" class="w-full h-full object-cover" />
                    @else
                        <div class="text-gray-500">头像</div>
                    @endif
                @else
                    <div class="text-gray-500">头像</div>
                @endauth
            </div>
            <div>
                @auth
                    <div class="user-title">{{ optional(auth()->user())->nickname ?? optional(auth()->user())->name ?? optional(auth()->user())->username }}</div>
                    <div class="muted">{{ optional(auth()->user())->email }}</div>
                @else
                    <div class="user-title">访客</div>
                    <div class="muted">未登录</div>
                @endauth
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}" style="margin-left:auto">
                    @csrf
                    <button class="btn-logout">登出</button>
                </form>
            @endauth
            </div>

            <div style="margin-top:18px">
                <h2 style="font-size:20px;margin:0 0 8px">欢迎</h2>
                <p class="muted" style="margin:0">这是登录后的首页示例。</p>
            </div>
        </div>
    </div> -->
    @include('partials.footer')
</body>
</html>
