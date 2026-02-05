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
                <div class="profile-title-section">
                    <h1>{{ $user->nickname ?? $user->username }} {{ $user->hometown ? '· '.$user->hometown : '' }}
                        @if($user->isMember())
                        <span class="member-badge" title="会员用户">👑</span>
                        @endif
                    </h1>
                </div>

                @if(!$user->isMember())
                <div class="membership-cta">
                    <a href="{{ route('membership') }}" class="btn btn-outline-premium" style="border:2px solid #f59e0b;background:#fff;color:#f59e0b;padding:10px 20px;text-decoration:none;border-radius:8px;font-weight:500;display:inline-block;position:relative;z-index:10;">成为会员</a>
                </div>
                @endif

                <div class="profile-info">
                    <div class="muted">{{ $user->occupation ?? '' }}</div>
                    <div class="bio">{{ $user->bio ?? '这位用户很懒，未填写简介。' }}</div>
                </div>

                @if($user->isMember())
                <div class="member-status">
                    <span class="member-label">会员用户</span>
                    <span class="member-plan">{{ ucfirst($user->membership->plan) }}会员</span>
                    @if($user->membership->expires_at)
                    <span class="member-expiry">到期: {{ $user->membership->expires_at->format('Y-m-d') }}</span>
                    @endif
                </div>
                @endif

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
                    @if($user->isMember())
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->comments->count() }}</div>
                        <div class="stat-label">评论</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">编辑资料</a>
                <a href="{{ route('profile.security') }}" class="btn btn-ghost">账号安全</a>
                @if($user->isMember())
                <a href="{{ route('membership') }}" class="btn btn-premium">会员中心</a>
                @endif
            </div>
        </div>

        <div class="layout">
            <div class="main">
                <div class="card">
                    <h3 style="margin-top:0">个人信息</h3>
                    <div class="info-row">
                        <div class="muted">生日</div>
                        <div>{{ $user->birthday?->format('Y-m-d') ?? '未填写' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="muted">手机号</div>
                        <div>{{ $user->phone ?? '未绑定' }}</div>
                    </div>
                    <div class="info-row" style="border-bottom:0">
                        <div class="muted">简介</div>
                        <div>{{ $user->bio ?? '无' }}</div>
                    </div>
                </div>

                @if($user->isMember())
                <div class="card membership-card">
                    <h3 style="margin-top:0;display:flex;align-items:center;gap:8px">
                        <span>👑</span>
                        会员状态
                    </h3>
                    <div class="membership-info">
                        <div class="membership-plan">
                            <strong>{{ ucfirst($user->membership->plan) }}会员</strong>
                        </div>
                        @if($user->membership->expires_at)
                        @php
                        $daysLeft = (int) now()->diffInDays($user->membership->expires_at, false);
                        @endphp
                        <div class="membership-expiry {{ $daysLeft <= 7 ? 'expiring-soon' : '' }}">
                            @if($daysLeft > 0)
                            剩余 <strong>{{ $daysLeft }}</strong> 天到期
                            @elseif($daysLeft == 0)
                            <strong>今日到期</strong>
                            @else
                            <strong>已过期</strong>
                            @endif
                        </div>
                        @else
                        <div class="membership-expiry">永久会员</div>
                        @endif
                        <div class="membership-benefits">
                            <h4>会员特权</h4>
                            <ul>
                                <li>✅ 无限发布旅行帖子</li>
                                <li>✅ 高级评论功能</li>
                                <li>✅ 优先内容展示</li>
                                <li>✅ 基础数据统计</li>
                                <li>✅ 专属会员标识</li>
                                <li>✅ 高级搜索功能</li>
                            </ul>
                        </div>
                        <a href="{{ route('membership') }}" class="btn btn-premium" style="width:95%;margin-top:16px">管理会员</a>
                    </div>
                </div>
                @endif
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