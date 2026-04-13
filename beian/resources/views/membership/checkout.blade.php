<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>会员支付</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            background: #f8fafc;
            color: #111827;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .checkout-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
            padding: 32px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08);
        }

        .checkout-title {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 16px 0;
        }

        .checkout-description {
            margin: 0 0 24px 0;
            color: #475569;
            line-height: 1.75;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 16px;
            padding: 20px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .summary-row strong {
            font-size: 1rem;
        }

        .radio-group {
            display: grid;
            gap: 16px;
            margin-bottom: 24px;
        }

        .radio-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 20px;
            border: 1px solid #d1d5db;
            border-radius: 16px;
            background: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .radio-card input {
            accent-color: #2563eb;
        }

        .radio-card:hover {
            border-color: #2563eb;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #2563eb;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: transparent;
            color: #374151;
            border: 1px solid #cbd5e1;
            padding: 14px 26px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="container">
        <div class="checkout-card">
            <h1 class="checkout-title">确认支付</h1>
            <p class="checkout-description">请选择支付方式并完成本次会员订阅。支付完成后，您的会员权限将立即生效。</p>

            <div class="summary-row">
                <div>
                    <div>订阅计划</div>
                    <strong>{{ $plan === 'premium' ? '高级会员（20 元/月）' : '基础会员（10 元/月）' }}</strong>
                </div>
                <div>
                    <div>当前用户</div>
                    <strong>{{ $user->nickname ?? $user->username }}</strong>
                </div>
            </div>

            <form action="{{ route('membership.complete') }}" method="POST">
                @csrf
                <input type="hidden" name="plan" value="{{ $plan }}">

                <div class="radio-group">
                    <label class="radio-card">
                        <input type="radio" name="payment_method" value="wechat" checked>
                        <div>
                            <strong>微信支付</strong>
                            <div style="color:#6b7280;">适用于大多数微信用户，扫码即可完成支付。</div>
                        </div>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="payment_method" value="alipay">
                        <div>
                            <strong>支付宝</strong>
                            <div style="color:#6b7280;">支持支付宝账号支付。</div>
                        </div>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        <div>
                            <strong>银行卡在线支付</strong>
                            <div style="color:#6b7280;">请根据实际页面提示完成付款。</div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn-primary">前往支付</button>
                <a href="{{ route('membership') }}" class="btn-secondary" style="margin-left: 12px;">返回会员页</a>
            </form>
        </div>
    </div>
</body>
</html>
