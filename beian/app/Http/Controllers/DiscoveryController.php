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
        $postsQuery = Post::with(['user', 'media', 'likes', 'favorites'])
            ->approved()
            ->orderBy('posts.created_at', 'desc');

        if ($currentCategory && $currentCategory !== 'all') {
            $postsQuery->where('posts.category', $currentCategory);
        }

        $posts = $postsQuery->paginate(12)->withQueryString();

        // 点赞最多的前10条
        $mostLikedPosts = Post::with(['user', 'media'])
            ->approved()
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(10)
            ->get();

        // 收藏最多的前10条
        $mostFavoritedPosts = Post::with(['user', 'media'])
            ->approved()
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

    public function search(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category', 'all');

        $postsQuery = Post::with(['user', 'media', 'likes', 'favorites'])
            ->approved();

        if ($query) {
            $postsQuery->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhereHas('user', function($userQuery) use ($query) {
                      $userQuery->where('username', 'like', "%{$query}%")
                               ->orWhere('nickname', 'like', "%{$query}%");
                  });
            });
        }

        if ($category && $category !== 'all') {
            $postsQuery->where('category', $category);
        }

        $posts = $postsQuery->latest()->paginate(12)->withQueryString();

        $categories = [
            'all' => '全部内容',
            '城市旅行' => '城市旅行',
            '户外冒险' => '户外冒险',
            '海滩度假' => '海滩度假',
            '文化体验' => '文化体验',
            '美食探索' => '美食探索',
        ];

        return view('search', compact('posts', 'categories', 'query', 'category'));
    }
}
