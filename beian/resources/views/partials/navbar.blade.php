<nav class="global-nav">
    <style>
        /* fixed top navigation so it spans full width on all pages */
        .global-nav {
            background: #fff;
            border-bottom: 1px solid #e6e6e6;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999
        }

        .global-nav .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            gap: 12px
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: inherit
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            object-fit: contain
        }

        .brand-text {
            font-weight: 600;
            font-size: 16px
        }

        .nav-center {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px
        }

        .nav-links {
            display: flex;
            gap: 16px;
            list-style: none;
            margin: 0;
            padding: 0
        }

        .nav-links a {
            color: #111;
            text-decoration: none;
            padding: 6px 8px;
            border-radius: 6px
        }

        .nav-links a:hover {
            background: #f3f4f6
        }

        .nav-search {
            min-width: 220px
        }

        .nav-search-input {
            width: 100%;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid #e5e7eb
        }

        .nav-search-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            background: rgba(37, 99, 235, 0.1);
            transition: all 0.2s;
        }

        .nav-search-link:hover {
            background: rgba(37, 99, 235, 0.2);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .nav-form-inline {
            display: inline
        }

        .nav-actions {
            display: flex;
            gap: 8px
        }

        .nav-btn {
            padding: 6px 10px;
            border-radius: 8px;
            text-decoration: none;
            color: #111;
            border: 1px solid transparent
        }

        .nav-btn-primary {
            background: #2563eb;
            color: #fff
        }

        .nav-btn-ghost {
            background: #ef4444;
            color: #fff;
            border: 1px solid transparent
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: inherit
        }

        .nav-avatar {
            width: 36px;
            height: 36px;
            border-radius: 9999px;
            object-fit: cover
        }

        .nav-avatar.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eef2ff;
            color: #2563eb
        }

        .nav-username {
            font-size: 14px
        }

        .member-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            font-size: 10px;
            margin-left: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        @media (max-width:900px) {
            .nav-center {
                display: none
            }

            .nav-search {
                display: none
            }

            .nav-toggle {
                display: block
            }
        }

        /* mobile menu */
        .nav-toggle {
            display: none;
            background: transparent;
            border: 0;
            padding: 8px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .nav-toggle:focus {
            outline: 2px solid rgba(37, 99, 235, 0.12);
            outline-offset: 2px;
        }

        .nav-toggle .bar {
            display: block;
            width: 24px;
            height: 2px;
            background: #111;
            border-radius: 2px;
            margin: 5px 0;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform-origin: center;
        }

        /* animated open state */
        .global-nav.nav-open .nav-toggle .bar:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .global-nav.nav-open .nav-toggle .bar:nth-child(2) {
            opacity: 0;
            transform: scaleX(0.8);
        }

        .global-nav.nav-open .nav-toggle .bar:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .nav-mobile {
            display: none;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(10px);
            transform: translateY(-100%);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-height: 0;
            overflow: hidden;
        }

        .global-nav.nav-open .nav-mobile {
            display: block;
            transform: translateY(0);
            opacity: 1;
            max-height: 500px;
        }

        .nav-mobile-content {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px 16px;
        }

        .mobile-nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .mobile-nav-links li {
            display: flex;
        }

        .mobile-nav-links a {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 12px;
            background: #fff;
            color: #374151;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
        }

        .mobile-nav-links a:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .mobile-nav-links a:active {
            transform: translateY(0);
        }

        .mobile-user-section {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .mobile-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .mobile-avatar.placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-weight: 600;
            font-size: 18px;
        }

        .mobile-user-details {
            flex: 1;
        }

        .mobile-username {
            font-weight: 600;
            color: #111827;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .mobile-user-role {
            font-size: 13px;
            color: #6b7280;
        }

        .mobile-member-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            font-size: 12px;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
        }

        .mobile-actions {
            display: flex;
            gap: 8px;
        }

        .mobile-btn {
            flex: 1;
            padding: 12px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .mobile-btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .mobile-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        .mobile-btn-ghost {
            background: #ef4444;
            color: #fff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .mobile-btn-ghost:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }

        .mobile-auth-section {
            display: flex;
            gap: 12px;
        }

        .mobile-auth-btn {
            flex: 1;
            padding: 14px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .mobile-auth-btn.login {
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .mobile-auth-btn.login:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .mobile-auth-btn.register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .mobile-auth-btn.register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        }

        /* ensure toggle visible on small screens (override later defaults) */
        @media (max-width:900px) {
            .nav-toggle {
                display: block
            }

            .nav-center {
                display: none
            }

            .nav-search {
                display: none
            }
        }

        /* add top padding to body so fixed nav doesn't cover content */
        body {
            padding-top: 64px
        }
    </style>
    <div class="nav-inner">
        <div class="nav-left">
            <a href="{{ url('/') }}" class="brand">
                <img src="/build/assets/logo.png" alt="logo" class="brand-logo" onerror="this.style.display='none'">
                <span class="brand-text" style="color: #41c3cf;">波斯圈</span>
            </a>
        </div>

        <div class="nav-center">
            <ul class="nav-links">
                <li><a href="/">首页</a></li>
                <li><a href="{{ route('discovery') }}">发现</a></li>
                <li><a href="{{ route('posts.create') }}">发布</a></li>
                @auth
                @if(auth()->user()->isMember())
                <li><a href="{{ route('search') }}">搜索</a></li>
                @endif
                @endauth
                <li><a href="{{ route('profile') }}">我的</a></li>
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
                @if(optional(auth()->user())->isMember())
                <span class="member-badge" title="会员用户">👑</span>
                @endif
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
        <div class="nav-mobile-content">
            <!-- @auth
            <div class="mobile-user-section">
                <div class="mobile-user-info">
                    @if(optional(auth()->user())->avatar)
                    <img src="{{ optional(auth()->user())->avatar_url }}" alt="avatar" class="mobile-avatar" />
                    @else
                    <div class="mobile-avatar placeholder">{{ strtoupper(substr(optional(auth()->user())->username ?? 'U',0,1)) }}</div>
                    @endif
                    <div class="mobile-user-details">
                        <div class="mobile-username">{{ optional(auth()->user())->nickname ?? optional(auth()->user())->username }}</div>
                        <div class="mobile-user-role">
                            @if(optional(auth()->user())->isMember())
                            <span class="mobile-member-badge" title="会员用户">👑</span> 会员用户
                            @else
                            普通用户
                            @endif
                        </div>
                    </div>
                </div>
                 <div class="mobile-actions">
                    <a href="{{ route('profile') }}" class="mobile-btn mobile-btn-primary">个人主页</a>
                    <form method="POST" action="{{ route('logout') }}" style="flex: 1;">
                        @csrf
                        <button type="submit" class="mobile-btn mobile-btn-ghost" style="width: 100%; border: none; background: #ef4444; color: #fff;">登出</button>
                    </form>
                </div> 
            </div>
            @else
            <div class="mobile-user-section">
                <div class="mobile-auth-section">
                    <a href="{{ route('login') }}" class="mobile-auth-btn login">登录</a>
                    <a href="{{ route('register') }}" class="mobile-auth-btn register">注册</a>
                </div>
            </div>
            @endauth -->

            <ul class="mobile-nav-links">
                <li><a href="/">🏠 首页</a></li>
                <li><a href="{{ route('discovery') }}">🔍 发现</a></li>
                <li><a href="{{ route('posts.create') }}">📝 发布</a></li>
                @auth
                @if(auth()->user()->isMember())
                <li><a href="{{ route('search') }}">🔎 搜索</a></li>
                @endif
                @endauth
                <li><a href="{{ route('profile') }}">👤 我的</a></li>
            </ul>
        </div>
    </div>
    <script>
        function toggleNav() {
            var nav = document.querySelector('.global-nav');
            if (!nav) return;

            // 添加平滑滚动禁用
            if (!nav.classList.contains('nav-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }

            nav.classList.toggle('nav-open');
        }

        // 点击外部关闭菜单
        document.addEventListener('click', function(e) {
            var nav = document.querySelector('.global-nav');
            if (!nav) return;

            // 如果点击的是菜单外部且菜单是打开状态，则关闭菜单
            if (!nav.contains(e.target) && nav.classList.contains('nav-open')) {
                document.body.style.overflow = '';
                nav.classList.remove('nav-open');
            }
        });

        // 监听菜单状态变化，处理滚动
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    var nav = document.querySelector('.global-nav');
                    if (nav && nav.classList.contains('nav-open')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            });
        });

        // 开始观察
        var navElement = document.querySelector('.global-nav');
        if (navElement) {
            observer.observe(navElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        }

        // 页面加载完成后初始化
        document.addEventListener('DOMContentLoaded', function() {
            // 确保初始状态正确
            document.body.style.overflow = '';
        });
    </script>
</nav>
<script type="module" src="/build/assets/app-CWpXuHPD.js"></script>