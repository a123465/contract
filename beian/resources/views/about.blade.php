<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>关于我们 - {{ config('app.name', '波斯圈') }}</title>
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <style>
        body { margin:0; font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; background:#f9faf9; color:#111827; }
        .page { max-width:960px; margin:0 auto; padding:32px 16px; }
        .page h1 { margin-bottom:18px; font-size:2.25rem; }
        .page p, .page li { color:#374151; line-height:1.8; font-size:15px; }
        .section { margin-top:30px; }
        .section ul { padding-left:20px; }
        .note { margin-top:18px; padding:18px; border-left:4px solid #2563eb; background:#eff6ff; color:#1e3a8a; }
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="page">
        <h1>关于我们</h1>
        <p><strong>波斯圈</strong>是一个面向旅行爱好者的信息发布与分享平台。平台本身不创作内容，所有游记、路线、经验和建议均由用户自主发布，平台仅提供信息展示、存储和管理服务。</p>
        <p>我们坚持“用户发布为主，平台支持为辅”的定位，专注于旅行信息发布场景，保留用户注册、发布帖子、点赞、收藏、个人主页等基础功能，避免复杂社区社交关系链。</p>
        <div class="note">平台运行中的付费项目为平台技术服务费，用于支持信息发布服务、内容管理、系统维护和合规运营。</div>

        <div class="section">
            <h2>我们的服务核心</h2>
            <ul>
                <li>提供安全稳定的旅行信息发布入口；</li>
                <li>展示用户原创旅行内容；</li>
                <li>保障用户内容存储与规范管理；</li>
                <li>通过审核机制提升信息质量，避免危险和违规内容；</li>
                <li>不作为新闻、医疗、教育、出版等前置审批领域平台。</li>
            </ul>
        </div>

        <div class="section">
            <h2>合规与审核</h2>
            <p>平台已建立基本的内容审核流程，重点审核旅行相关信息和用户发布内容，禁止涉及危险行为、违法违规、敏感话题、前置审批领域内容。</p>
            <p>如需了解平台详细规则，可访问：<a href="{{ route('user.agreement') }}">《用户协议》</a>、<a href="{{ route('privacy.policy') }}">《隐私政策》</a>、<a href="{{ route('membership.service') }}">《会员服务协议》</a> 和 <a href="{{ route('community.guidelines') }}">《社区公约》</a>。</p>
        </div>
    </div>
    @include('partials.footer')
</body>
</html>
