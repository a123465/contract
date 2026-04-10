<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>高级搜索 - 会员专属</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
    :root{--bg:#f8fafc;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .container{max-width:1200px;margin:24px auto;padding:20px}
    .search-header{background:#fff;border-radius:16px;padding:32px;margin-bottom:24px;box-shadow:0 6px 20px rgba(16,24,40,0.06);text-align:center}
    .search-title{font-size:2rem;font-weight:700;margin:0 0 8px 0;color:#111}
    .search-subtitle{color:#6b7280;margin:0 0 24px 0}
    .search-form{display:flex;gap:16px;max-width:600px;margin:0 auto}
    .search-input{flex:1;padding:16px;border:2px solid #e5e7eb;border-radius:12px;font-size:16px}
    .search-input:focus{border-color:#2563eb;outline:none}
    .search-btn{background:#2563eb;color:#fff;border:0;padding:16px 32px;border-radius:12px;font-size:16px;font-weight:600;cursor:pointer}
    .search-btn:hover{background:#1d4ed8}
    .filters{margin-bottom:24px;display:flex;gap:16px;flex-wrap:wrap}
    .filter-btn{padding:8px 16px;border:2px solid #e5e7eb;border-radius:20px;background:#fff;color:#374151;cursor:pointer;font-size:14px}
    .filter-btn.active{border-color:#2563eb;color:#2563eb;font-weight:600}
    .filter-btn:hover{border-color:#2563eb}
    .results-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
    .results-count{color:#6b7280}
    .post-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px}
    .post-card{background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(16,24,40,0.08);transition:transform 0.2s}
    .post-card:hover{transform:translateY(-4px)}
    .post-image{height:200px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:48px}
    .post-content{padding:20px}
    .post-title{font-size:18px;font-weight:600;margin:0 0 8px 0;color:#111}
    .post-excerpt{color:#6b7280;font-size:14px;line-height:1.5;margin:0 0 12px 0}
    .post-meta{display:flex;align-items:center;gap:12px;font-size:12px;color:#9ca3af}
    .post-author{display:flex;align-items:center;gap:8px}
    .author-avatar{width:24px;height:24px;border-radius:50%;background:#e5e7eb;display:flex;align-items:center;justify-content:center;font-size:12px;color:#6b7280}
    .no-results{text-align:center;padding:64px 20px;color:#6b7280}
    .no-results-icon{font-size:64px;margin-bottom:16px}
    .member-badge{background:linear-gradient(135deg,#fbbf24,#f59e0b);color:#fff;padding:2px 8px;border-radius:12px;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px}
    @media (max-width:768px){.search-form{flex-direction:column}.post-grid{grid-template-columns:1fr}.filters{justify-content:center}}
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="container">
        <div class="search-header">
            <h1 class="search-title">🔍 高级搜索</h1>
            <p class="search-subtitle">会员专属功能，快速找到您感兴趣的内容</p>

            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input type="text" name="q" value="{{ $query }}" placeholder="搜索标题、内容或作者..." class="search-input" required>
                <button type="submit" class="search-btn">搜索</button>
            </form>
        </div>

        <div class="filters">
            <a href="{{ route('search', ['q' => $query, 'category' => 'all']) }}" class="filter-btn {{ $category == 'all' ? 'active' : '' }}">全部内容</a>
            <a href="{{ route('search', ['q' => $query, 'category' => '城市旅行']) }}" class="filter-btn {{ $category == '城市旅行' ? 'active' : '' }}">城市旅行</a>
            <a href="{{ route('search', ['q' => $query, 'category' => '户外冒险']) }}" class="filter-btn {{ $category == '户外冒险' ? 'active' : '' }}">户外冒险</a>
            <a href="{{ route('search', ['q' => $query, 'category' => '海滩度假']) }}" class="filter-btn {{ $category == '海滩度假' ? 'active' : '' }}">海滩度假</a>
            <a href="{{ route('search', ['q' => $query, 'category' => '文化体验']) }}" class="filter-btn {{ $category == '文化体验' ? 'active' : '' }}">文化体验</a>
            <a href="{{ route('search', ['q' => $query, 'category' => '美食探索']) }}" class="filter-btn {{ $category == '美食探索' ? 'active' : '' }}">美食探索</a>
        </div>

        <div class="results-header">
            <div class="results-count">
                @if($query)
                    搜索 "{{ $query }}" {{ $category != 'all' ? '在 ' . $categories[$category] . ' 中' : '' }} 找到 {{ $posts->total() }} 个结果
                @else
                    请输入搜索关键词
                @endif
            </div>
        </div>

        @if($posts->count() > 0)
            <div class="post-grid">
                @foreach($posts as $post)
                <div class="post-card">
                    <a href="{{ route('posts.show', $post) }}" style="text-decoration:none;color:inherit">
                        @if($post->media->first())
                            <div class="post-image" style="background-image:url('{{ asset('storage/' . $post->media->first()->file_path) }}');background-size:cover;background-position:center"></div>
                        @else
                            <div class="post-image">📷</div>
                        @endif

                        <div class="post-content">
                            <h3 class="post-title">{{ $post->title }}</h3>
                            <p class="post-excerpt">{{ Str::limit(strip_tags($post->content), 100) }}</p>

                            <div class="post-meta">
                                <div class="post-author">
                                    @if($post->user->avatar)
                                        <img src="{{ $post->user->avatar_url }}" alt="avatar" class="author-avatar" style="width:24px;height:24px;object-fit:cover">
                                    @else
                                        <div class="author-avatar">{{ strtoupper(substr($post->user->username ?? 'U',0,1)) }}</div>
                                    @endif
                                    <span>{{ $post->user->nickname ?? $post->user->username }}</span>
                                    @if($post->user->isMember())
                                    <span class="member-badge">会员</span>
                                    @endif
                                </div>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            {{ $posts->appends(['q' => $query, 'category' => $category])->links() }}
        @else
            @if($query)
                <div class="no-results">
                    <div class="no-results-icon">🔍</div>
                    <h3>没有找到相关内容</h3>
                    <p>尝试使用不同的关键词或分类</p>
                </div>
            @endif
        @endif
    </div>
</body>
</html>