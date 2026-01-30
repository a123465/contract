<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>个人主页</title>
    @include('partials.profile-styles')
</head>
<body>
    @include('partials.navbar')
    <div class="page">
        <div class="profile-header">
            @if($user->avatar)
                <img src="{{ $user->avatar_url }}" alt="avatar" class="avatar-large">
            @else
                <div class="avatar-placeholder">{{ strtoupper(substr($user->username ?? 'U',0,1)) }}</div>
            @endif

            <div class="profile-meta">
                <h1>{{ $user->nickname ?? $user->username }}</h1>
                <div class="muted">{{ $user->occupation ?? '' }} {{ $user->hometown ? '· '.$user->hometown : '' }}</div>
                <div class="bio">{{ $user->bio ?? '这位用户很懒，未填写简介。' }}</div>
                <div class="stat-list">
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->posts->count() }}</div>
                        <div class="stat-label">分享</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->likedPosts->count() }}</div>
                        <div class="stat-label">点赞</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->favoritedPosts->count() }}</div>
                        <div class="stat-label">收藏</div>
                    </div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">编辑资料</a>
                <a href="{{ route('profile.security') }}" class="btn btn-ghost">账号安全</a>
            </div>
        </div>

        <div class="layout">
            <div class="main">
                <div class="card">
                    <h3 style="margin-top:0">个人信息</h3>
                    <div class="info-row"><div class="muted">生日</div><div>{{ $user->birthday?->format('Y-m-d') ?? '未填写' }}</div></div>
                    <div class="info-row"><div class="muted">手机号</div><div>{{ $user->phone ?? '未绑定' }}</div></div>
                    <div class="info-row" style="border-bottom:0"><div class="muted">简介</div><div>{{ $user->bio ?? '无' }}</div></div>
                </div>
            </div>

            <aside class="aside">
                <div class="card">
                    <h4 style="margin-top:0">关于我</h4>
                    <div class="muted" style="margin-top:8px">昵称：{{ $user->nickname ?? '-' }}</div>
                    <div class="muted" style="margin-top:6px">账号：{{ $user->username }}</div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
@include('partials.footer')
