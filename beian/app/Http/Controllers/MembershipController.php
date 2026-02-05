<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $membership = $user ? $user->membership : null;

        return view('membership.index', compact('membership', 'user'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:basic,premium',
        ]);

        $user = Auth::user();

        // 简单模拟支付，这里假设支付成功
        // 在实际应用中，需要集成支付网关如Stripe

        $expiresAt = now()->addDays(30); // 30天会员

        Membership::updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan' => $request->plan,
                'status' => 'active',
                'expires_at' => $expiresAt,
            ]
        );

        return redirect()->route('membership')->with('success', '会员订阅成功！');
    }
}
