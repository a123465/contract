<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>审核管理 - {{ config('app.name', '波斯圈') }}</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
        body { margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,sans-serif; background:#f8fafc; color:#0f172a; }
        .container { max-width:1180px; margin:0 auto; padding:28px 24px 40px; }
        .header { display:flex; flex-wrap:wrap; align-items:flex-start; justify-content:space-between; gap:18px; margin-bottom:22px; }
        .page-title { margin:0; font-size:2.3rem; letter-spacing:-0.03em; }
        .hint { color:#475569; max-width:640px; margin-top:10px; font-size:0.98rem; line-height:1.75; }
        .top-actions { display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:flex-end; }
        .back-link { text-decoration:none; color:#2563eb; font-weight:600; }
        .notification-banner { display:flex; align-items:center; gap:12px; padding:16px 18px; border-radius:18px; background:#eff6ff; border:1px solid #bae6fd; color:#0f172a; box-shadow:0 18px 40px rgba(15,23,42,0.08); margin-bottom:20px; }
        .notification-banner strong { font-weight:700; }
        .panel { display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:16px; margin-bottom:24px; }
        .stat-card { background:#fff; border:1px solid rgba(148,163,184,0.24); border-radius:20px; padding:20px 22px; box-shadow:0 20px 40px rgba(15,23,42,0.06); }
        .stat-card strong { display:block; font-size:1.85rem; line-height:1; color:#111827; }
        .stat-card span { margin-top:8px; display:block; color:#64748b; font-size:0.95rem; }
        .review-table { width:100%; border-collapse:separate; border-spacing:0; background:#fff; border-radius:24px; overflow:hidden; box-shadow:0 30px 70px rgba(15,23,42,0.08); }
        .review-table th, .review-table td { padding:18px 16px; vertical-align:top; }
        .review-table th { background:#f8fafc; color:#334155; font-weight:700; font-size:0.93rem; letter-spacing:0.02em; text-transform:uppercase; border-bottom:1px solid #e2e8f0; }
        .review-table tbody tr { border-bottom:1px solid #f1f5f9; }
        .review-table tbody tr:last-child td { border-bottom:0; }
        .review-table tbody tr:hover td { background:#f8fbff; }
        .status-badge { display:inline-flex; align-items:center; justify-content:center; padding:7px 12px; border-radius:999px; font-size:12px; font-weight:700; letter-spacing:0.01em; text-transform:capitalize; }
        .status-pending { background:#fef3c7; color:#92400e; }
        .status-auto-flagged { background:#ffe7d9; color:#b45309; }
        .status-approved { background:#dcfce7; color:#166534; }
        .status-rejected, .status-removed { background:#fee2e2; color:#b91c1c; }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:12px 16px; border-radius:14px; text-decoration:none; font-size:0.95rem; font-weight:700; border:1px solid transparent; transition:all .2s ease; cursor:pointer; }
        .btn-approve { background:#ecfdf5; color:#166534; border-color:#86efac; }
        .btn-approve:hover { background:#d1fae5; }
        .btn-reject { background:#fee2e2; color:#b91c1c; border-color:#fca5a5; }
        .btn-reject:hover { background:#fecaca; }
        .btn-remove { background:#f8fafc; color:#334155; border-color:#cbd5e1; }
        .btn-remove:hover { background:#e2e8f0; }
        .small-text { color:#64748b; font-size:0.88rem; line-height:1.6; }
        .pagination { margin-top:22px; display:flex; justify-content:center; }
        .action-buttons { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:8px; }
        .review-actions form { width:100%; }
        .post-link { color:#0f172a; font-weight:700; text-decoration:none; }
        .post-link:hover { color:#2563eb; }
        .empty-state { text-align:center; padding:48px 20px; color:#64748b; }
        .empty-state-title { font-size:1.25rem; margin-bottom:8px; color:#1f2937; }
        @media (max-width:900px) { .action-buttons { grid-template-columns:1fr; } }
        @media (max-width:760px) { .header { flex-direction:column; align-items:flex-start; } .top-actions { justify-content:flex-start; width:100%; } }
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <div class="header">
            <div>
                <h1 class="page-title">审核管理</h1>
                <div class="hint">仅管理员可见。下面列出了待审核帖子，您可以快速查看、审批或进入历史记录。</div>
            </div>
            <div class="top-actions">
                <a href="{{ route('discovery') }}" class="back-link">返回发现页</a>
                <a href="{{ route('reviews.history') }}" class="btn btn-approve">查看历史记录</a>
            </div>
        </div>

        @if(session('success'))
            <div class="notification-banner">
                <strong>操作成功</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="panel">
            <div class="stat-card">
                <strong>{{ $reviews->total() }}</strong>
                <span>待审核帖子</span>
            </div>
            <div class="stat-card">
                <strong>{{ $reviews->count() }}</strong>
                <span>当前页</span>
            </div>
            <div class="stat-card" style="background:#eff6ff; border-color:#bfdbfe;">
                <strong>审核效率</strong>
                <span>请优先处理最早的待审核内容。</span>
            </div>
        </div>

        <table class="review-table">
            <thead>
                <tr>
                    <th>帖子标题</th>
                    <th>作者</th>
                    <th>提交时间</th>
                    <th>当前状态</th>
                    <th>审核理由 / 记录</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>
                            @if($review->reviewable)
                                <a href="{{ route('posts.show', $review->reviewable) }}" target="_blank" style="color:#111;text-decoration:none;">{{ $review->reviewable->title }}</a>
                                <div class="small-text">分类: {{ $review->reviewable->category }}</div>
                            @else
                                <span style="color:#9ca3af;">已删除帖子</span>
                            @endif
                        </td>
                        <td>
                            {{ optional($review->reviewable?->user)->nickname ?? optional($review->reporter)->nickname ?? '未知' }}
                            <div class="small-text">ID: {{ $review->reviewable?->user_id ?? $review->reporter_id ?? '-' }}</div>
                        </td>
                        <td>{{ $review->created_at->format('Y-m-d H:i') }}</td>
                        <td><span class="status-badge status-{{ $review->status }}">{{ $review->status }}</span></td>
                        <td>
                            <div>{{ $review->reason ?? '无' }}</div>
                            @if($review->reviewer)
                                <div class="small-text">审核员: {{ $review->reviewer->nickname ?? $review->reviewer->username }}</div>
                                <div class="small-text">已处理: {{ $review->resolved_at?->format('Y-m-d H:i') }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons review-actions">
                                <form action="{{ route('reviews.review', $review) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <input type="hidden" name="reason" value="审核通过，内容合规。">
                                    <button type="submit" class="btn btn-approve">通过</button>
                                </form>
                                <form action="{{ route('reviews.review', $review) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <input type="hidden" name="reason" value="未通过审核，请修改后重新提交。">
                                    <button type="submit" class="btn btn-reject">驳回</button>
                                </form>
                                <form action="{{ route('reviews.review', $review) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="removed">
                                    <input type="hidden" name="reason" value="内容已被移除，不予展示。">
                                    <button type="submit" class="btn btn-remove">移除</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:24px; color:#64748b;">当前暂无待审核帖子。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $reviews->links() }}
        </div>
    </div>
</body>
</html>
