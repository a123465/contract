<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>审核管理 - {{ config('app.name', '波斯圈') }}</title>
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
        .status-pending { background:#fef3c7; color:#92400e; }
        .status-auto-flagged { background:#ffedd5; color:#92400e; }
        .status-approved { background:#dcfce7; color:#166534; }
        .status-rejected, .status-removed { background:#fee2e2; color:#b91c1c; }
        .btn { display:inline-flex; align-items:center; justify-content:center; padding:8px 14px; border-radius:10px; text-decoration:none; font-size:13px; font-weight:600; border:1px solid transparent; transition:all .2s ease; }
        .btn-approve { background:#dcfce7; color:#166534; border-color:#86efac; }
        .btn-reject { background:#fee2e2; color:#b91c1c; border-color:#fca5a5; }
        .btn-remove { background:#f8fafc; color:#374151; border-color:#d1d5db; }
        .btn:hover { transform:translateY(-1px); }
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
                <h1>审核管理</h1>
                <div class="hint">仅管理员可见。下面列出了待审核帖子，您可以直接审批。</div>
            </div>
            <a href="{{ route('discovery') }}" class="back-link">返回发现页</a>
        </div>

        <div class="review-summary">
            <div>
                <strong>{{ $reviews->total() }}</strong>
                <span>待审核帖子</span>
            </div>
            <div>
                <strong>{{ $reviews->count() }}</strong>
                <span>当前页</span>
            </div>
            <div>
                <a href="{{ route('reviews.history') }}" class="btn btn-approve" style="padding:10px 16px;">查看历史记录</a>
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
                            <form action="{{ route('reviews.review', $review) }}" method="POST" style="display:inline-block;margin-bottom:8px;">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <input type="hidden" name="reason" value="审核通过，内容合规。">
                                <button type="submit" class="btn btn-approve">通过</button>
                            </form>
                            <form action="{{ route('reviews.review', $review) }}" method="POST" style="display:inline-block;margin-bottom:8px;">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <input type="hidden" name="reason" value="未通过审核，请修改后重新提交。">
                                <button type="submit" class="btn btn-reject">驳回</button>
                            </form>
                            <form action="{{ route('reviews.review', $review) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="status" value="removed">
                                <input type="hidden" name="reason" value="内容已被移除，不予展示。">
                                <button type="submit" class="btn btn-remove">移除</button>
                            </form>
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
