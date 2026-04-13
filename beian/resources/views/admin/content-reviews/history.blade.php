<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>审核历史 - {{ config('app.name', '波斯圈') }}</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
        body { margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,sans-serif; background:#f8fafc; color:#0f172a; }
        .container { max-width:1180px; margin:0 auto; padding:28px 24px 40px; }
        .header { display:flex; flex-wrap:wrap; align-items:flex-start; justify-content:space-between; gap:18px; margin-bottom:22px; }
        .page-title { margin:0; font-size:2.3rem; letter-spacing:-0.03em; }
        .hint { color:#475569; max-width:640px; margin-top:10px; font-size:0.98rem; line-height:1.75; }
        .top-actions { display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:flex-end; }
        .back-link { text-decoration:none; color:#2563eb; font-weight:600; }
        .review-table { width:100%; border-collapse:separate; border-spacing:0; background:#fff; border-radius:24px; overflow:hidden; box-shadow:0 30px 70px rgba(15,23,42,0.08); }
        .review-table th, .review-table td { padding:18px 16px; vertical-align:top; }
        .review-table th { background:#f8fafc; color:#334155; font-weight:700; font-size:0.93rem; letter-spacing:0.02em; text-transform:uppercase; border-bottom:1px solid #e2e8f0; }
        .review-table tbody tr { border-bottom:1px solid #f1f5f9; }
        .review-table tbody tr:last-child td { border-bottom:0; }
        .review-table tbody tr:hover td { background:#f8fbff; }
        .status-badge { display:inline-flex; align-items:center; justify-content:center; padding:7px 12px; border-radius:999px; font-size:12px; font-weight:700; letter-spacing:0.01em; text-transform:capitalize; }
        .status-approved { background:#dcfce7; color:#166534; }
        .status-rejected, .status-removed { background:#fee2e2; color:#b91c1c; }
        .small-text { color:#64748b; font-size:0.88rem; line-height:1.6; }
        .pagination { margin-top:22px; display:flex; justify-content:center; }
        .review-summary { margin-bottom:24px; display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr)); gap:16px; }
        .stat-card { background:#fff; border:1px solid rgba(148,163,184,0.24); border-radius:20px; padding:20px 22px; box-shadow:0 20px 40px rgba(15,23,42,0.06); }
        .stat-card strong { display:block; font-size:1.85rem; line-height:1; color:#111827; }
        .stat-card span { margin-top:8px; display:block; color:#64748b; font-size:0.95rem; }
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <div class="header">
            <div>
                <h1 class="page-title">审核历史</h1>
                <div class="hint">展示已处理的帖子审核记录，便于管理员回溯审批结果。</div>
            </div>
            <div class="top-actions">
                <a href="{{ route('reviews.index') }}" class="back-link">返回待审列表</a>
            </div>
        </div>

        <div class="review-summary">
            <div class="stat-card">
                <strong>{{ $reviews->total() }}</strong>
                <span>历史记录</span>
            </div>
            <div class="stat-card">
                <strong>{{ $reviews->count() }}</strong>
                <span>当前页</span>
            </div>
        </div>

        <table class="review-table">
            <thead>
                <tr>
                    <th>帖子标题</th>
                    <th>作者</th>
                    <th>处理时间</th>
                    <th>结果</th>
                    <th>审核理由</th>
                    <th>审核员</th>
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
                        <td>{{ $review->resolved_at?->format('Y-m-d H:i') ?? $review->updated_at->format('Y-m-d H:i') }}</td>
                        <td><span class="status-badge status-{{ $review->status }}">{{ $review->status }}</span></td>
                        <td>{{ $review->reason ?? '无' }}</td>
                        <td>{{ optional($review->reviewer)->nickname ?? optional($review->reviewer)->username ?? '未知' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:24px; color:#64748b;">暂无审核历史记录。</td>
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
