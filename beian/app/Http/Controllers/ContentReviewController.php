<?php

namespace App\Http\Controllers;

use App\Models\ContentReview;
use App\Models\Post;
use Illuminate\Http\Request;

class ContentReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store', 'review']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
            'reason' => 'nullable|string',
            'reporter_id' => 'nullable|integer',
        ]);

        $review = ContentReview::create([
            'reviewable_type' => $data['reviewable_type'],
            'reviewable_id' => $data['reviewable_id'],
            'reporter_id' => $data['reporter_id'] ?? auth()->id(),
            'reason' => $data['reason'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json($review, 201);
    }

    public function index(Request $request)
    {
        if (! auth()->user() || ! auth()->user()->isModerator()) {
            abort(403, '无权访问审核管理。');
        }

        $reviews = ContentReview::where('reviewable_type', Post::class)
            ->with(['reviewable.user', 'reporter', 'reviewer'])
            ->whereIn('status', ['pending', 'auto-flagged'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.content-reviews.index', compact('reviews'));
    }

    public function history(Request $request)
    {
        if (! auth()->user() || ! auth()->user()->isModerator()) {
            abort(403, '无权访问审核历史。');
        }

        $reviews = ContentReview::where('reviewable_type', Post::class)
            ->with(['reviewable.user', 'reporter', 'reviewer'])
            ->whereNotIn('status', ['pending', 'auto-flagged'])
            ->orderBy('resolved_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.content-reviews.history', compact('reviews'));
    }

    public function review(Request $request, ContentReview $review)
    {
        // 仅允许具有审核权限的用户执行审核
        if (! auth()->user() || ! auth()->user()->isModerator()) {
            abort(403, '无权执行此操作。');
        }

        $data = $request->validate([
            'status' => 'required|in:approved,rejected,removed',
            'reason' => 'nullable|string',
            'action' => 'nullable|array',
        ]);

        $review->update([
            'status' => $data['status'],
            'reason' => $data['reason'] ?? $review->reason,
            'action' => $data['action'] ?? null,
            'reviewer_id' => auth()->id(),
            'resolved_at' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json($review);
        }

        return redirect()->route('reviews.index')->with('success', '审核已处理。');
    }
}
