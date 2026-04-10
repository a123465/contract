<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>发现 - 旅行分享</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
    :root{--bg:#f8fafc;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .container{max-width:1600px;margin:24px auto;padding:20px}
    .discovery-layout{display:grid;grid-template-columns:280px 1fr 320px;gap:24px}
    .main-content{background:var(--card);border-radius:12px;padding:24px;box-shadow:0 6px 20px rgba(16,24,40,0.06)}
    .content-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
    .content-title{font-size:24px;font-weight:700;color:#111;margin:0}
    .create-post-btn{background:var(--accent);color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:600}
    .create-post-btn:hover{background:#1d4ed8}
    .posts-list{display:flex;flex-direction:column;gap:20px}
    .post-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.1);transition:transform 0.2s;border:1px solid #f3f4f6}
    .post-card:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(0,0,0,0.15)}
    .post-card-link{text-decoration:none;color:inherit;display:block}
    .post-header{display:flex;gap:16px;padding:20px}
    .post-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
    .post-avatar-placeholder{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:18px;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
    .post-info{flex:1}
    .post-author{font-size:16px;font-weight:600;color:#111;margin-bottom:4px}
    .post-time{color:#6b7280;font-size:14px}
    .post-content-section{padding:0 20px 20px 84px}
    .post-title{font-size:20px;font-weight:600;margin-bottom:12px;line-height:1.4;color:#111}
    .post-excerpt{color:#374151;font-size:16px;margin-bottom:16px;line-height:1.6}
    .post-media{margin-bottom:16px}
    .post-image{max-width:100%;height:auto;border-radius:8px;max-height:300px;object-fit:cover}
    .post-stats{display:flex;gap:16px;padding:0 20px 20px 84px}
    .stat-item{display:flex;align-items:center;gap:6px;color:#6b7280;font-size:14px}
    .sidebar{background:var(--card);border-radius:12px;padding:20px;box-shadow:0 6px 20px rgba(16,24,40,0.06);height:fit-content}
    .sidebar-title{font-size:18px;font-weight:700;margin-bottom:16px;color:#111}
    .category-list{list-style:none;margin:0;padding:0}
    .category-item{margin-bottom:8px}
    .category-link{display:block;padding:12px 16px;border-radius:8px;text-decoration:none;color:#374151;font-weight:500;transition:all 0.2s}
    .category-link:hover{background:#f3f4f6}
    .category-link.active{background:var(--accent);color:#fff}
    .category-link.all{background:#10b981;color:#fff}
    .category-link.all:hover{background:#059669}
    .right-sidebar{background:var(--card);border-radius:12px;padding:20px;box-shadow:0 6px 20px rgba(16,24,40,0.06);height:fit-content}
    .tabs{display:flex;margin-bottom:20px;border-bottom:1px solid #e5e7eb}
    .tab-btn{flex:1;padding:12px;text-align:center;text-decoration:none;color:#6b7280;font-weight:500;border-bottom:2px solid transparent;transition:all 0.2s}
    .tab-btn.active{color:var(--accent);border-bottom-color:var(--accent)}
    .tab-content{display:none}
    .tab-content.active{display:block}
    .ranking-list{list-style:none;margin:0;padding:0}
    .ranking-item{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #f3f4f6}
    .ranking-item:last-child{border-bottom:0}
    .ranking-number{width:24px;height:24px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;flex-shrink:0}
    .ranking-content{flex:1;min-width:0}
    .ranking-title{font-size:14px;font-weight:500;color:#111;margin-bottom:4px;display:block;text-decoration:none;line-height:1.3}
    .ranking-title:hover{color:var(--accent)}
    .ranking-meta{color:#6b7280;font-size:12px}
    .suggested-users{margin-top:24px;padding-top:24px;border-top:1px solid #e5e7eb}
    .suggested-header{display:flex;align-items:space-between;margin-bottom:16px}
    .suggested-title{font-size:16px;font-weight:600;color:#111;margin:0}
    .refresh-btn{background:none;border:none;color:var(--accent);cursor:pointer;font-size:14px;padding:4px 8px;border-radius:4px;transition:all 0.2s}
    .refresh-btn:hover{background:#f0f4ff}
    .suggested-user{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid #f3f4f6}
    .suggested-user:last-child{border-bottom:0}
    .user-avatar{width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
    .user-avatar-placeholder{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:16px;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
    .user-info{flex:1}
    .user-name{font-size:14px;font-weight:600;color:#111;margin-bottom:2px}
    .user-stats{color:#6b7280;font-size:12px}
    .pagination{display:flex;justify-content:center;margin-top:24px}
    .pagination a{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:6px;text-decoration:none;color:#6b7280;border:1px solid #e5e7eb;margin:0 2px}
    .pagination a:hover{background:#f3f4f6}
    .pagination .active{background:var(--accent);color:#fff;border-color:var(--accent)}
    .empty-state{text-align:center;padding:60px 20px;color:var(--muted)}
    .empty-state-icon{font-size:48px;margin-bottom:16px}
    .empty-state-title{font-size:20px;font-weight:600;margin-bottom:8px;color:#374151}
    .empty-state-text{margin-bottom:24px}
    @media (max-width:1200px){.discovery-layout{grid-template-columns:1fr}.sidebar,.right-sidebar{display:none}}
    @media (max-width:768px){.posts-list{gap:16px}.post-header{padding:16px}.post-content-section{padding:0 16px 16px 68px}.post-stats{padding:0 16px 16px 68px}}
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <div class="discovery-layout">
            <!-- 左侧分类导航 -->
            <aside class="sidebar">
                <h2 class="sidebar-title">旅行分类</h2>
                <ul class="category-list">
                    @foreach($categories as $key => $label)
                        <li class="category-item">
                            <a href="{{ route('discovery', ['category' => $key]) }}"
                               class="category-link {{ ($currentCategory ?? 'all') === $key ? 'active' : '' }} {{ $key === 'all' ? 'all' : '' }}">
                                @if($key === 'all')
                                    📚 {{ $label }}
                                @elseif($key === '城市旅行')
                                    🏙️ {{ $label }}
                                @elseif($key === '户外冒险')
                                    🏔️ {{ $label }}
                                @elseif($key === '海滩度假')
                                    🏖️ {{ $label }}
                                @elseif($key === '文化体验')
                                    🏛️ {{ $label }}
                                @elseif($key === '美食探索')
                                    🍜 {{ $label }}
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <!-- 中间主要内容 -->
            <main class="main-content">
                <div class="content-header">
                    <h1 class="content-title">发现精彩旅行</h1>
                    @auth
                        <a href="{{ route('posts.create') }}" class="create-post-btn">✏️ 发布分享</a>
                    @endauth
                </div>

                <div class="posts-list">
                    @forelse($posts as $post)
                        <a href="{{ route('posts.show', $post) }}" class="post-card-link">
                            <div class="post-card">
                                <div class="post-header">
                                    @if($post->user->avatar)
                                        <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->nickname ?? $post->user->name }}" class="post-avatar">
                                    @else
                                        <div class="post-avatar-placeholder">
                                            {{ strtoupper(substr($post->user->nickname ?? $post->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="post-info">
                                        <div class="post-author">{{ $post->user->nickname ?? $post->user->name }} @if($post->user->isMember())<span class="member-badge" title="会员用户">👑</span>@endif</div>
                                        <div class="post-time">{{ $post->created_at->diffForHumans() }} · {{ $post->category }}</div>
                                    </div>
                                </div>

                                <div class="post-content-section">
                                    <h3 class="post-title">{{ $post->title }}</h3>
                                    <p class="post-excerpt">{{ Str::limit($post->content, 200) }}</p>

                                    @if($post->first_image)
                                        <div class="post-media">
                                            <img src="{{ $post->first_image->url }}" alt="{{ $post->title }}" class="post-image">
                                        </div>
                                    @endif
                                </div>

                                <div class="post-stats">
                                    <div class="stat-item">
                                        <span>❤️</span>
                                        <span>{{ $post->likes_count ?? $post->likes->count() }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span>⭐</span>
                                        <span>{{ $post->favorites_count ?? $post->favorites->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-icon">📝</div>
                            <div class="empty-state-title">暂无内容</div>
                            <div class="empty-state-text">还没有旅行分享，快来发布第一篇吧！</div>
                        </div>
                    @endforelse
                </div>

                <!-- 分页 -->
                @if($posts->hasPages())
                    <div class="pagination">
                        {{ $posts->links() }}
                    </div>
                @endif
            </main>

            <!-- 右侧边栏 -->
            <aside class="right-sidebar">
                <!-- Tab切换 -->
                <div class="tabs">
                    <a href="#likes" class="tab-btn active" data-tab="likes">🔥 点赞</a>
                    <a href="#favorites" class="tab-btn" data-tab="favorites">⭐ 收藏</a>
                </div>

                <!-- 点赞最多内容 -->
                <div id="likes" class="tab-content active">
                    <ul class="ranking-list">
                        @forelse($mostLikedPosts as $index => $post)
                            <li class="ranking-item">
                                <div class="ranking-number">{{ $index + 1 }}</div>
                                <div class="ranking-content">
                                    <a href="{{ route('posts.show', $post) }}" class="ranking-title">{{ Str::limit($post->title, 40) }}</a>
                                    <div class="ranking-meta">{{ $post->likes_count }} 点赞</div>
                                </div>
                            </li>
                        @empty
                            <li class="ranking-item">
                                <div class="ranking-content">
                                    <div class="ranking-meta">暂无数据</div>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- 收藏最多内容 -->
                <div id="favorites" class="tab-content">
                    <ul class="ranking-list">
                        @forelse($mostFavoritedPosts as $index => $post)
                            <li class="ranking-item">
                                <div class="ranking-number">{{ $index + 1 }}</div>
                                <div class="ranking-content">
                                    <a href="{{ route('posts.show', $post) }}" class="ranking-title">{{ Str::limit($post->title, 40) }}</a>
                                    <div class="ranking-meta">{{ $post->favorites_count }} 收藏</div>
                                </div>
                            </li>
                        @empty
                            <li class="ranking-item">
                                <div class="ranking-content">
                                    <div class="ranking-meta">暂无数据</div>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- 你可能感兴趣的人 -->
                <div class="suggested-users">
                    <div class="suggested-header">
                        <h3 class="suggested-title">👥 你可能感兴趣的人</h3>
                        <button class="refresh-btn" onclick="refreshSuggestions()">🔄 换一批</button>
                    </div>
                    <div id="suggested-users-list">
                        @forelse($suggestedUsers as $user)
                            <div class="suggested-user">
                                <a href="{{ route('profile') }}">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->nickname ?? $user->name }}" class="user-avatar">
                                    @else
                                        <div class="user-avatar-placeholder">
                                            {{ strtoupper(substr($user->nickname ?? $user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </a>
                                <div class="user-info">
                                    <div class="user-name">{{ $user->nickname ?? $user->name }}</div>
                                    <div class="user-stats">{{ $user->posts_count }} 篇分享</div>
                                </div>
                            </div>
                        @empty
                            <div class="suggested-user">
                                <div class="user-info">
                                    <div class="user-stats">暂无推荐用户</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
    // Tab切换功能
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            // 移除所有active状态
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // 添加当前active状态
            this.classList.add('active');
            const tabId = this.getAttribute('href');
            document.querySelector(tabId).classList.add('active');
        });
    });

    // 刷新建议用户功能
    function refreshSuggestions() {
        const refreshBtn = document.querySelector('.refresh-btn');
        refreshBtn.disabled = true;
        refreshBtn.textContent = '🔄 加载中...';

        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.suggestedUsers) {
                const container = document.getElementById('suggested-users-list');
                container.innerHTML = data.suggestedUsers.map(user => `
                    <div class="suggested-user">
                        <a href="/profile/${user.id}">
                            ${user.avatar ?
                                `<img src="${user.avatar_url}" alt="${user.nickname || user.name}" class="user-avatar">` :
                                `<div class="user-avatar-placeholder">${(user.nickname || user.name).charAt(0).toUpperCase()}</div>`
                            }
                        </a>
                        <div class="user-info">
                            <div class="user-name">${user.nickname || user.name}</div>
                            <div class="user-stats">${user.posts_count} 篇分享</div>
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Error refreshing suggestions:', error);
        })
        .finally(() => {
            refreshBtn.disabled = false;
            refreshBtn.textContent = '🔄 换一批';
        });
    }
    </script>
</body>
</html>
@include('partials.footer')