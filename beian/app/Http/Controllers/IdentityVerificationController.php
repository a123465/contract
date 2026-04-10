<?php

namespace App\Http\Controllers;

use App\Models\IdentityVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdentityVerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 用户提交实名认证申请（内部流程，不使用第三方）
    public function submit(Request $request)
    {
        $data = $request->validate([
            'real_name' => 'required|string',
            'id_number' => 'required|string',
            'documents.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $user = $request->user();

        // 存储上传文档到受限路径
        $stored = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('identity/'. $user->id, 'private');
                $stored[] = $path;
            }
        }

        // 创建 verification 记录
        $verification = IdentityVerification::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'submitted_data' => [
                'real_name' => $data['real_name'],
                'id_number_hash' => sha1($data['id_number']),
            ],
            'documents' => $stored,
        ]);

        // 更新用户状态为 verifying 并保存原始（加密）字段
        $user->update([
            'real_name' => $data['real_name'],
            'id_number' => $data['id_number'],
            'id_documents' => $stored,
            'id_status' => 'verifying',
        ]);

        return response()->json(['message' => '提交成功，等待人工审核。', 'verification_id' => $verification->id], 201);
    }

    // 用户查看自己的最后一次实名认证状态
    public function status(Request $request)
    {
        $user = $request->user();
        $latest = IdentityVerification::where('user_id', $user->id)->latest()->first();
        return response()->json($latest);
    }

    // 审核员查看待审列表
    public function pending(Request $request)
    {
        if (! $request->user()->isModerator()) abort(403);
        $list = IdentityVerification::where('status', 'pending')->with('user')->paginate(20);
        return response()->json($list);
    }

    // 审核员对申请进行人工复核（通过或驳回）
    public function review(Request $request, IdentityVerification $verification)
    {
        if (! $request->user()->isModerator()) abort(403);

        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
            'review_reason' => 'nullable|string',
        ]);

        $verification->update([
            'status' => $data['status'] === 'approved' ? 'approved' : 'rejected',
            'reviewer_id' => $request->user()->id,
            'review_reason' => $data['review_reason'] ?? null,
            'reviewed_at' => now(),
        ]);

        $user = $verification->user;
        if ($data['status'] === 'approved') {
            $user->update([
                'id_status' => 'verified',
                'id_verified_at' => now(),
            ]);
        } else {
            $user->update([
                'id_status' => 'rejected',
                'id_reject_reason' => $data['review_reason'] ?? null,
            ]);
        }

        return response()->json(['message' => '审核已记录。', 'verification' => $verification]);
    }
}
