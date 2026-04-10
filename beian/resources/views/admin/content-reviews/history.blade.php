<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>审核历史 - {{ config('app.name', '波斯圈') }}</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
        body { margin:0; font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial,sans-serif; background:#f3f4f6; color:#111; }
        .container { max-width:1140px; margin:0 auto; padding:24px; }
        .header { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:24px; }
        .header h1 { margin:0; font-size:2rem; }
        .header .hint { color:#6b7280; }
        .review-table { width:100%; border-collapse:collapse; background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; }
        .review-table th, .review-table td { padding:16px 14px; text-align:left; border-bottom:1px solid #f3f4f6; }
        .review-table th { background:#f8fafc; color:#334155; font-weight:700; font-size:14px; }
        .review-table tr:last-child td { border-bottom:0; }
        .status-badge { display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; }
        .status-approved { background:#dcfce7; color:#166534; }
        .status-rejected, .status-removed { background:#fee2e2; color:#b91c1c; }
        .small-text { color:#64748b; font-size:13px; }
        .pagination { margin-top:20px; display:flex; justify-content:center; }
        .review-summary { margin-bottom:16px; display:flex; gap:16px; flex-wrap:wrap; }
        .review-summary div { background:#fff; padding:16px 18px; border-radius:16px; border:1px solid #e5e7eb; box-shadow:0 8px 24px rgba(15,23,42,0.04); }
        .review-summary strong { display:block; font-size:1.5rem; }
        .review-summary span { color:#64748b; margin-top:4px; display:block; }
        .back-link { text-decoration:none; color:#2563eb; }
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <div class="header">
            <div>
                <h1>审核历史</h1>
                <div class="hint">展示已处理的帖子审核记录，便于管理员回溯审批结果。</div>
            </div>
            <a href="{{ route('reviews.index') }}" class="back-link">返回待审列表</a>
        </div>

        <div class="review-summary">
            <div>
                <strong>{{ $reviews->total() }}</strong>
                <span>历史记录</span>
            </div>
            <div>
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
