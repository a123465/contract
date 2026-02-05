<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>会员中心</title>
    <link rel="stylesheet" href="/build/assets/app.css">
    <style>
    :root {
        --bg: #f8fafc;
        --card: #ffffff;
        --accent: #2563eb;
        --accent-light: #3b82f6;
        --accent-dark: #1d4ed8;
        --muted: #6b7280;
        --success: #10b981;
        --success-light: #d1fae5;
        --warning: #f59e0b;
        --warning-light: #fef3c7;
        --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-premium: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    body {
        font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
        margin: 0;
        background: var(--bg);
        color: #1f2937;
        line-height: 1.6;
    }

    .hero-section {
        background: var(--gradient);
        color: white;
        padding: 60px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin: 0 0 16px 0;
        text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        letter-spacing: -0.02em;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
        margin: 0 0 32px 0;
        font-weight: 400;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .status-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
    }

    .status-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--success);
    }

    .status-card h2 {
        margin: 0 0 24px 0;
        font-size: 1.875rem;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge.active {
        background: var(--success-light);
        color: #065f46;
    }

    .status-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
        margin-top: 24px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
    }

    .plans-section {
        margin-bottom: 40px;
    }

    .plans-title {
        text-align: center;
        font-size: 2.25rem;
        font-weight: 800;
        color: #111827;
        margin: 0 0 16px 0;
    }

    .plans-subtitle {
        text-align: center;
        font-size: 1.125rem;
        color: var(--muted);
        margin: 0 0 48px 0;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 48px;
    }

    .plan-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 2px solid #e5e7eb;
        position: relative;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .plan-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .plan-card.selected {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .plan-card.premium {
        background: var(--gradient-premium);
        color: white;
        border-color: transparent;
    }

    .plan-card.premium .plan-price {
        color: white;
    }

    .plan-card.premium .feature-item {
        color: rgba(255, 255, 255, 0.9);
    }

    .plan-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .plan-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .plan-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--accent);
        margin: 0;
        display: flex;
        align-items: baseline;
        justify-content: center;
        gap: 4px;
    }

    .plan-price .currency {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .plan-price .period {
        font-size: 1rem;
        font-weight: 500;
        color: var(--muted);
    }

    .plan-features {
        list-style: none;
        padding: 0;
        margin: 24px 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 0.875rem;
        color: #374151;
    }

    .feature-item::before {
        content: '✓';
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background: var(--success);
        color: white;
        border-radius: 50%;
        font-size: 12px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .plan-radio {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 20px;
        height: 20px;
        accent-color: var(--accent);
    }

    .subscribe-section {
        text-align: center;
    }

    .btn-subscribe {
        background: var(--gradient);
        color: white;
        border: none;
        padding: 16px 48px;
        border-radius: 12px;
        font-size: 1.125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .btn-subscribe:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .btn-subscribe:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .login-prompt {
        text-align: center;
        background: white;
        border-radius: 16px;
        padding: 48px 32px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 0 auto;
    }

    .login-prompt h2 {
        margin: 0 0 16px 0;
        color: #111827;
        font-size: 1.875rem;
        font-weight: 700;
    }

    .login-prompt p {
        margin: 0 0 24px 0;
        color: var(--muted);
        font-size: 1.125rem;
    }

    .login-links {
        display: flex;
        gap: 16px;
        justify-content: center;
    }

    .btn-login, .btn-register {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-login {
        background: white;
        color: var(--accent);
        border: 2px solid var(--accent);
    }

    .btn-login:hover {
        background: var(--accent);
        color: white;
    }

    .btn-register {
        background: var(--accent);
        color: white;
        border: 2px solid var(--accent);
    }

    .btn-register:hover {
        background: var(--accent-dark);
        border-color: var(--accent-dark);
    }

    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-weight: 500;
    }

    .alert-success {
        background: var(--success-light);
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.25rem;
        }

        .plans-grid {
            grid-template-columns: 1fr;
        }

        .status-info {
            grid-template-columns: 1fr;
        }

        .login-links {
            flex-direction: column;
        }
    }
    </style>
</head>
<body>
    @include('partials.navbar')

    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">会员中心</h1>
            <p class="hero-subtitle">解锁更多精彩功能，成为我们的尊贵会员</p>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        @if($user && $membership && $membership->isActive())
            <div class="status-card">
                <h2>
                    <span>👑</span>
                    当前会员状态
                </h2>

                <div class="status-info">
                    <div class="info-item">
                        <span class="info-label">会员计划</span>
                        <span class="info-value">{{ ucfirst($membership->plan) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">状态</span>
                        <span class="status-badge active">{{ $membership->status }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">到期时间</span>
                        <span class="info-value">{{ $membership->expires_at ? $membership->expires_at->format('Y年m月d日') : '永久' }}</span>
                    </div>
                </div>
            </div>
        @elseif($user)
            <div class="plans-section">
                <h2 class="plans-title">选择您的会员计划</h2>
                <p class="plans-subtitle">加入会员，享受专属特权和无限可能</p>

                <form id="subscriptionForm" action="{{ route('membership.subscribe') }}" method="POST">
                    @csrf

                    <div class="plans-grid">
                        <div class="plan-card" onclick="selectPlan('basic')">
                            <input type="radio" name="plan" value="basic" class="plan-radio" checked>

                            <div class="plan-header">
                                <h3 class="plan-name">基础会员</h3>
                                <div class="plan-price">
                                    <span class="currency">¥</span>
                                    <span>10</span>
                                    <span class="period">/月</span>
                                </div>
                            </div>

                            <ul class="plan-features">
                                <li class="feature-item">无限发布旅行帖子</li>
                                <li class="feature-item">高级评论功能</li>
                                <li class="feature-item">优先内容展示</li>
                                <li class="feature-item">基础数据统计</li>
                                <li class="feature-item">专属会员标识</li>
                                <li class="feature-item">高级搜索功能</li>
                            </ul>
                        </div>

                        <!-- 暂时隐藏高级会员
                        <div class="plan-card premium" onclick="selectPlan('premium')">
                            <input type="radio" name="plan" value="premium" class="plan-radio">

                            <div class="plan-header">
                                <h3 class="plan-name">高级会员</h3>
                                <div class="plan-price">
                                    <span class="currency">¥</span>
                                    <span>20</span>
                                    <span class="period">/月</span>
                                </div>
                            </div>

                            <ul class="plan-features">
                                <li class="feature-item">所有基础会员特权</li>
                                <li class="feature-item">专属客服支持</li>
                                <li class="feature-item">高级数据分析</li>
                                <li class="feature-item">独家内容访问</li>
                                <li class="feature-item">定制化推荐</li>
                            </ul>
                        </div>
                        -->
                    </div>

                    <div class="subscribe-section">
                        <button type="submit" class="btn-subscribe" id="subscribeBtn">
                            立即订阅
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="login-prompt">
                <h2>🔐 请先登录</h2>
                <p>要查看会员信息并享受专属特权，请先登录您的账户</p>
                <div class="login-links">
                    <a href="{{ route('login') }}" class="btn-login">登录</a>
                    <a href="{{ route('register') }}" class="btn-register">注册</a>
                </div>
            </div>
        @endif
    </div>

    <script>
        function selectPlan(planType) {
            // 移除所有卡片的选中状态
            document.querySelectorAll('.plan-card').forEach(card => {
                card.classList.remove('selected');
            });

            // 选中对应的卡片
            const selectedCard = document.querySelector(`input[name="plan"][value="${planType}"]`).closest('.plan-card');
            selectedCard.classList.add('selected');

            // 选中对应的radio按钮
            document.querySelector(`input[name="plan"][value="${planType}"]`).checked = true;

            // 更新按钮文本
            const btn = document.getElementById('subscribeBtn');
            const planName = planType === 'basic' ? '基础会员' : '高级会员';
            btn.textContent = `订阅 ${planName}`;
        }

        // 初始化选中状态
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="plan"]:checked');
            if (checkedRadio) {
                selectPlan(checkedRadio.value);
            }
        });
    </script>
</body>
</html>