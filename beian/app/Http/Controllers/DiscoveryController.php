<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DiscoveryController extends Controller
{
    public function index(Request $request)
    {
        // 获取当前选中的分类
        $currentCategory = $request->get('category');

        // 按时间排序的帖子（支持分类筛选）
        $postsQuery = Post::with(['user', 'media', 'likes', 'favorites']);

        if ($currentCategory && $currentCategory !== 'all') {
            $postsQuery->where('category', $currentCategory);
        }

        $posts = $postsQuery->latest()->paginate(12);

        // 点赞最多的前10条
        $mostLikedPosts = Post::with(['user', 'media'])
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(10)
            ->get();

        // 收藏最多的前10条
        $mostFavoritedPosts = Post::with(['user', 'media'])
            ->withCount('favorites')
            ->orderBy('favorites_count', 'desc')
            ->take(10)
            ->get();

        // 你可能感兴趣的人（随机选择）
        $suggestedUsers = \App\Models\User::whereHas('posts')
            ->withCount('posts')
            ->inRandomOrder()
            ->take(8)
            ->get();

        // 分类数据
        $categories = [
            'all' => '全部内容',
            '城市旅行' => '城市旅行',
            '户外冒险' => '户外冒险',
            '海滩度假' => '海滩度假',
            '文化体验' => '文化体验',
            '美食探索' => '美食探索',
        ];

        // 如果是AJAX请求，返回JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'suggestedUsers' => $suggestedUsers->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'nickname' => $user->nickname,
                        'avatar' => $user->avatar,
                        'avatar_url' => $user->avatar_url,
                        'posts_count' => $user->posts_count,
                    ];
                })
            ]);
        }

        return view('discovery', compact('posts', 'mostLikedPosts', 'mostFavoritedPosts', 'suggestedUsers', 'categories', 'currentCategory'));
    }
}
