<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function create()
    {
        return view('post.create');
    }

    public function edit(Post $post)
    {
        // 仅允许作者编辑
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        return view('post.edit', compact('post'));
    }

    public function store(Request $request)
    {
        // DEBUG: 记录上传文件信息，帮助定位 media.* 验证失败的问题
        try {
            $allFiles = $request->allFiles();
            $mediaFiles = $allFiles['media'] ?? null;
            $debugFiles = [];
            if (is_array($mediaFiles)) {
                foreach ($mediaFiles as $f) {
                    if ($f) {
                        $debugFiles[] = [
                            'name' => $f->getClientOriginalName(),
                            'size' => $f->getSize(),
                            'mime' => $f->getClientMimeType(),
                        ];
                    }
                }
            }
            Log::info('PostController@store upload debug', ['hasFile' => $request->hasFile('media'), 'media_count' => is_array($mediaFiles) ? count($mediaFiles) : 0, 'media_files' => $debugFiles]);
        } catch (\Throwable $e) {
            Log::warning('PostController@store upload debug failed to inspect files: ' . $e->getMessage());
        }

        // 如果请求体大小超过 PHP 配置的 post_max_size，PHP 会丢弃文件，导致上传为空。
        // 提前检测 CONTENT_LENGTH 并给出友好提示。
        try {
            $contentLength = isset($_SERVER['CONTENT_LENGTH']) ? (int) $_SERVER['CONTENT_LENGTH'] : 0;
            $postMax = $this->returnBytes(ini_get('post_max_size'));
            if ($contentLength > 0 && $postMax > 0 && $contentLength > $postMax) {
                if ($request->wantsJson()) {
                    return response()->json(['message' => '上传的文件太大，超过服务器允许的最大请求体(post_max_size)'], 422);
                }
                return back()->withErrors(['media' => '上传的文件太大，超过服务器允许的最大请求体(post_max_size)']);
            }
        } catch (\Throwable $e) {
            // 忽略检测错误，继续正常验证
        }

        // 如果文件存在但有上传错误，给出更明确的提示
        try {
            $allFiles = $request->allFiles();
            $mediaFiles = $allFiles['media'] ?? null;
            if (is_array($mediaFiles)) {
                foreach ($mediaFiles as $f) {
                    if ($f && $f->getError() !== UPLOAD_ERR_OK) {
                        $msg = match($f->getError()) {
                            UPLOAD_ERR_INI_SIZE => '上传文件超过 PHP 配置的 upload_max_filesize',
                            UPLOAD_ERR_FORM_SIZE => '上传文件超过表单允许的大小',
                            UPLOAD_ERR_PARTIAL => '文件只被部分上传',
                            UPLOAD_ERR_NO_FILE => '没有上传文件',
                            UPLOAD_ERR_NO_TMP_DIR => '服务器缺少临时文件夹',
                            UPLOAD_ERR_CANT_WRITE => '服务器无法写入上传文件到磁盘',
                            UPLOAD_ERR_EXTENSION => 'PHP 扩展中断了文件上传',
                            default => '文件上传失败，错误码: ' . $f->getError(),
                        };

                        if ($request->wantsJson()) {
                            return response()->json(['message' => $msg], 422);
                        }
                        return back()->withErrors(['media' => $msg]);
                    }
                }
            }
        } catch (\Throwable $e) {
            // 忽略
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|in:城市旅行,户外冒险,海滩度假,文化体验,美食探索',
            'media' => 'nullable|array|max:9', // 最多 9 个文件
            'media.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi|max:10240',
        ],[
            'media.max' => '最多只能上传 :max 个文件。',
            'media.*.mimes' => '媒体文件类型只支持 JPG/PNG/GIF/MP4/MOV/AVI。',
            'media.*.max' => '单个文件不能超过 10MB。',
        ]);

        // 检查非会员用户的帖子数量限制（每月10条）
        $user = Auth::user();
        if (!$user->isMember()) {
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $monthlyPostCount = $user->posts()
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            if ($monthlyPostCount >= 10) {
                return back()->withErrors(['general' => '免费用户每月最多只能发布10条帖子。如需发布更多内容，请升级为会员。']);
            }
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        if ($request->hasFile('media')) {
            $sortOrder = 0;
            foreach ($request->file('media') as $file) {
                $path = $file->store('posts', 'public');
                $mimeType = $file->getMimeType();
                $fileType = str_starts_with($mimeType, 'image/') ? 'image' : 'video';

                PostMedia::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $mimeType,
                    'file_type' => $fileType,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('discovery')->with('success', '旅行分享发布成功！');
    }

    public function update(Request $request, Post $post)
    {
        // DEBUG: 记录上传文件信息（编辑时）
        // DEBUG: 记录上传文件信息（编辑时）
        try {
            $allFiles = $request->allFiles();
            $mediaFiles = $allFiles['media'] ?? null;
            $debugFiles = [];
            if (is_array($mediaFiles)) {
                foreach ($mediaFiles as $f) {
                    if ($f) {
                        $debugFiles[] = [
                            'name' => $f->getClientOriginalName(),
                            'size' => $f->getSize(),
                            'mime' => $f->getClientMimeType(),
                        ];
                    }
                }
            }
            Log::info('PostController@update upload debug', ['hasFile' => $request->hasFile('media'), 'media_count' => is_array($mediaFiles) ? count($mediaFiles) : 0, 'media_files' => $debugFiles]);
        } catch (\Throwable $e) {
            Log::warning('PostController@update upload debug failed to inspect files: ' . $e->getMessage());
        }

        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|in:城市旅行,户外冒险,海滩度假,文化体验,美食探索',
            'media' => 'nullable|array|max:9',
            'media.*' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi|max:10240',
        ],[
            'media.max' => '最多只能上传 :max 个文件。',
            'media.*.mimes' => '媒体文件类型只支持 JPG/PNG/GIF/MP4/MOV/AVI。',
            'media.*.max' => '单个文件不能超过 10MB。',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        // 处理新上传的媒体（保留已有的媒体）
        if ($request->hasFile('media')) {
            $sortOrder = ($post->media()->max('sort_order') ?? -1) + 1;
            foreach ($request->file('media') as $file) {
                $path = $file->store('posts', 'public');
                $mimeType = $file->getMimeType();
                $fileType = str_starts_with($mimeType, 'image/') ? 'image' : 'video';

                PostMedia::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $mimeType,
                    'file_type' => $fileType,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('posts.show', $post)->with('success', '帖子已更新');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes', 'favorites']);

        return view('post.show', compact('post'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        return back()->with('success', '评论发表成功！');
    }

    public function toggleLike(Post $post)
    {
        $user = Auth::user();
        if ($post->isLikedBy($user)) {
            $user->likedPosts()->detach($post);
            $message = '取消点赞';
            $liked = false;
        } else {
            $user->likedPosts()->attach($post);
            $message = '点赞成功';
            $liked = true;
        }

        $likesCount = $post->likes()->count();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $likesCount,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleFavorite(Post $post)
    {
        $user = Auth::user();
        if ($post->isFavoritedBy($user)) {
            $user->favoritedPosts()->detach($post);
            $message = '取消收藏';
            $favorited = false;
        } else {
            $user->favoritedPosts()->attach($post);
            $message = '收藏成功';
            $favorited = true;
        }

        $favoritesCount = $post->favorites()->count();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'favorited' => $favorited,
                'favorites_count' => $favoritesCount,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        // 删除媒体文件
        foreach ($post->media as $media) {
            try {
                Storage::disk('public')->delete($media->file_path);
            } catch (\Exception $e) {
                // 忽略删除错误
            }
            $media->delete();
        }

        $post->delete();

        return redirect()->route('discovery')->with('success', '帖子已删除');
    }

    public function destroyMedia(Post $post, PostMedia $media)
    {
        // only allow owner to delete media
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        if ($media->post_id !== $post->id) {
            abort(404);
        }

        try {
            Storage::disk('public')->delete($media->file_path);
        } catch (\Exception $e) {
            // ignore
        }

        $media->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => '媒体已删除']);
        }

        return back()->with('success', '媒体已删除');
    }

    /**
     * Convert PHP size string like "10M" to bytes
     */
    private function returnBytes($val)
    {
        if (! $val) return 0;
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $num = (int)$val;
        switch($last) {
            case 'g':
                $num *= 1024;
            case 'm':
                $num *= 1024;
            case 'k':
                $num *= 1024;
        }
        return $num;
    }
}
