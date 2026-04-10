<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $post->title }} - 旅行分享</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
    :root{--bg:#f8fafc;--card:#ffffff;--accent:#2563eb;--muted:#6b7280;--success:#10b981;--danger:#ef4444}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .container{max-width:800px;margin:24px auto;padding:20px}
    .post-header{background:var(--card);border-radius:12px;padding:24px;margin-bottom:20px;box-shadow:0 6px 20px rgba(16,24,40,0.06)}
    .post-title{font-size:28px;font-weight:700;margin-bottom:12px;color:#111}
    .post-meta{display:flex;align-items:center;gap:16px;margin-bottom:16px;color:var(--muted);font-size:14px}
    .author-info{display:flex;align-items:center;gap:12px;padding:12px 16px;background:#f8fafc;border-radius:12px;border:1px solid #e5e7eb}
    .author-avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
    .author-avatar-placeholder{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;border:2px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
    .author-details{flex:1}
    .author-name{font-size:16px;font-weight:600;color:#111;margin-bottom:2px}
    .author-meta{color:#6b7280;font-size:13px;display:flex;gap:12px}
    .post-category{background:#eef2ff;color:var(--accent);padding:4px 8px;border-radius:6px;font-size:12px;font-weight:500}
    .post-image{max-width:100%;height:auto;border-radius:8px;margin-bottom:20px}
    .post-content{line-height:1.7;font-size:16px;margin-bottom:24px}
    .post-actions{display:flex;gap:12px;margin-bottom:24px}
    .action-btn{display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;border:1px solid #e5e7eb;background:#fff;color:#111;text-decoration:none;font-size:14px}
    .action-btn:hover{background:#f9fafb}
    .action-btn.liked{background:#fef2f2;color:var(--danger);border-color:var(--danger)}
    .action-btn.favorited{background:#fefce8;color:#f59e0b;border-color:#f59e0b}
    .alert{background:#fef3c7;color:#92400e;padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid #fbbf24}
    /* 固定主媒体区域高度，防止切换时页面跳动 */
    #media-main{height:420px;max-height:600px;border-radius:8px;overflow:hidden;background:#000;display:flex;align-items:center;justify-content:center}
    @media (max-width:640px){#media-main{height:280px}}
    /* AJAX 操作 loading spinner（已移至全局样式） */
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <article class="post-header">
            <h1 class="post-title">{{ $post->title }}</h1>
            @if(Auth::check() && Auth::id() === $post->user_id && !$post->isApproved())
                <div class="alert">
                    当前帖子尚未通过审核：{{ match($post->review_status) {
                        'rejected' => '已驳回，请检查内容并修改后重新提交。',
                        'auto-flagged' => '已被系统自动标记，请等待人工复审。',
                        'removed' => '内容已被移除，无法展示。',
                        default => '审核中，审核通过后将会对外展示。',
                    } }}
                </div>
            @endif
            <div class="author-info">
                @if($post->user->avatar)
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->nickname ?? $post->user->name }}" class="author-avatar">
                @else
                    <div class="author-avatar-placeholder">
                        {{ strtoupper(substr($post->user->nickname ?? $post->user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="author-details">
                    <div class="author-name">{{ $post->user->nickname ?? $post->user->name }} @if($post->user->isMember())<span class="member-badge" title="会员用户">👑</span>@endif</div>
                    <div class="author-meta">
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                        <span class="post-category">{{ $post->category }}</span>
                    </div>
                </div>
            </div>
            <script>
            (function(fn){ if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn); else fn(); })(function(){
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!csrf) return;

                document.querySelectorAll('form.ajax-action').forEach(form => {
                    form.addEventListener('submit', function(e){
                        e.preventDefault();
                        const action = form.action;
                        const btn = form.querySelector('button');

                        // 防止重复点击：禁用按钮并显示 spinner
                        btn.disabled = true;
                        btn.setAttribute('aria-busy','true');
                        const spinner = document.createElement('span');
                        spinner.className = 'ajax-spinner';
                        btn.appendChild(spinner);

                        // 发送 AJAX 请求
                        fetch(action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        }).then(resp => {
                            if (resp.status === 401) {
                                // 未登录，跳转到登录页
                                window.location.href = '{{ route('login') }}';
                                return;
                            }
                            if (!resp.ok) throw resp;
                            return resp.json();
                        }).then(data => {
                            if (!data) return;
                            // 移除 spinner
                            spinner.remove();
                            btn.removeAttribute('aria-busy');
                            btn.disabled = false;

                            // 处理点赞响应
                            if (data.liked !== undefined) {
                                if (data.liked) btn.classList.add('liked'); else btn.classList.remove('liked');
                                btn.innerHTML = '❤️ ' + (data.likes_count ?? '0');
                            }
                            // 处理收藏响应
                            if (data.favorited !== undefined) {
                                if (data.favorited) btn.classList.add('favorited'); else btn.classList.remove('favorited');
                                btn.innerHTML = '⭐ ' + (data.favorites_count ?? '0');
                            }
                        }).catch(err => {
                            console.error('AJAX action error', err);
                            // 恢复状态
                            spinner.remove();
                            btn.removeAttribute('aria-busy');
                            btn.disabled = false;
                        });
                    });
                });
            });
            </script>

            <script>
            // 绑定确认删除（使用全局 UI.confirm）
            document.addEventListener('DOMContentLoaded', function(){
                document.querySelectorAll('form.confirm-delete').forEach(form => {
                    form.addEventListener('submit', async function(e){
                        e.preventDefault();
                        const ok = window.UI ? await window.UI.confirm('确定要删除这篇帖子吗？此操作不可恢复。') : confirm('确定要删除这篇帖子吗？此操作不可恢复。');
                        if (!ok) return;
                        // 提交表单
                        form.submit();
                    });
                });
            });
            </script>

            @if($post->media->count() > 0)
                <div class="media-gallery" style="margin-bottom:20px">
                    <div id="media-main">
                        <!-- 主媒体容器，由 JS 控制显示 -->
                    </div>

                    <div style="display:flex;justify-content:center;gap:12px;margin-top:8px;align-items:center">
                        <button id="media-prev" type="button" class="action-btn">‹</button>
                        <div id="media-thumbs" style="display:flex;gap:8px;overflow-x:auto;padding:6px 4px"></div>
                        <button id="media-next" type="button" class="action-btn">›</button>
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        // 媒体数组（由后端渲染 URL）
                        const media = [
                            @foreach($post->media as $media)
                                {
                                    url: '{{ $media->url }}',
                                    type: '{{ $media->file_type }}',
                                    mime: '{{ $media->mime_type }}'
                                },
                            @endforeach
                        ];

                        let index = 0;
                        const main = document.getElementById('media-main');
                        const thumbs = document.getElementById('media-thumbs');
                        const prevBtn = document.getElementById('media-prev');
                        const nextBtn = document.getElementById('media-next');

                        function renderMain() {
                            main.innerHTML = '';
                            const item = media[index];
                            if (!item) return;

                            if (item.type === 'image') {
                                const img = document.createElement('img');
                                img.src = item.url;
                                img.alt = '{{ $post->title }}';
                                img.style.cssText = 'width:auto;height:100%;max-width:100%;object-fit:contain;display:block';
                                main.appendChild(img);
                            } else {
                                const video = document.createElement('video');
                                video.src = item.url;
                                video.controls = true;
                                video.style.cssText = 'width:auto;height:100%;max-width:100%;object-fit:contain;display:block;background:#000';
                                main.appendChild(video);
                            }
                        }

                        function renderThumbs() {
                            thumbs.innerHTML = '';
                            media.forEach((m, i) => {
                                const box = document.createElement('div');
                                box.style.cssText = 'width:80px;height:60px;border-radius:6px;overflow:hidden;border:2px solid transparent;cursor:pointer;flex:0 0 auto;background:#fafafa;display:flex;align-items:center;justify-content:center';
                                if (i === index) box.style.borderColor = '#2563eb';

                                if (m.type === 'image') {
                                    const img = document.createElement('img');
                                    img.src = m.url;
                                    img.style.cssText = 'width:100%;height:100%;object-fit:cover;display:block';
                                    box.appendChild(img);
                                } else {
                                    const vid = document.createElement('div');
                                    vid.textContent = '🎞️';
                                    vid.style.cssText = 'font-size:20px';
                                    box.appendChild(vid);
                                }

                                box.addEventListener('click', function() {
                                    index = i;
                                    renderMain();
                                    renderThumbs();
                                });

                                thumbs.appendChild(box);
                            });
                        }

                        prevBtn.addEventListener('click', function() {
                            index = (index - 1 + media.length) % media.length;
                            renderMain();
                            renderThumbs();
                        });

                        nextBtn.addEventListener('click', function() {
                            index = (index + 1) % media.length;
                            renderMain();
                            renderThumbs();
                        });

                        // 初始化
                        renderMain();
                        renderThumbs();
                    });
                    </script>
                </div>
            @endif

            <div class="post-content">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="post-actions">
                @auth
                    <form method="POST" action="{{ route('posts.like', $post) }}" class="ajax-action ajax-like" style="display:inline">
                        @csrf
                        <button type="submit" class="action-btn {{ $post->isLikedBy(auth()->user()) ? 'liked' : '' }}">
                            ❤️ {{ $post->likes->count() }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('posts.favorite', $post) }}" class="ajax-action ajax-fav" style="display:inline">
                        @csrf
                        <button type="submit" class="action-btn {{ $post->isFavoritedBy(auth()->user()) ? 'favorited' : '' }}">
                            ⭐ {{ $post->favorites->count() }}
                        </button>
                    </form>
                    @if(auth()->check() && auth()->id() === $post->user_id)
                        <a href="{{ route('posts.edit', $post) }}" class="action-btn" style="margin-left:8px">编辑</a>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="confirm-delete" style="display:inline;margin-left:8px">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" style="background:#ef4444;color:#fff;border-color:#ef4444">删除</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="action-btn">
                        ❤️ {{ $post->likes->count() }}
                    </a>
                    <a href="{{ route('login') }}" class="action-btn">
                        ⭐ {{ $post->favorites->count() }}
                    </a>
                @endauth
            </div>
        </article>
    </div>
</body>
</html>
@include('partials.footer')