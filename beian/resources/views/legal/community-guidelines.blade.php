<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>社区公约 - {{ config('app.name', '波斯圈') }}</title>
    <style>
        body { margin:0; font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; background:#f9f9f9; color:#111827; }
        .page { max-width:900px; margin:0 auto; padding:32px 16px; }
        .page h1, .page h2 { color:#111827; }
        .page p, .page li { line-height:1.75; font-size:15px; color:#444444; }
        .page a { color:#2563eb; text-decoration:underline; }
        .section { margin-top:32px; }
        .section ul { padding-left:20px; }
    </style>
</head>
<body>
    <div class="page">
        <h1>社区公约</h1>
        <p>本公约是对《用户协议》的补充，旨在明确平台社区的行为规范，维护旅行信息发布平台的健康秩序。</p>

        <div class="section">
            <h2>一、发布内容要求</h2>
            <ul>
                <li>发布内容应围绕旅行、景点、线路、住宿、美食等旅行信息；</li>
                <li>鼓励分享真实、文明、实用的旅行经验；</li>
                <li>禁止发布虚假、误导性、欺诈性内容；</li>
                <li>禁止发布涉及前置审批领域的新闻、医疗、教育、文化、视听、药品等内容。</li>
            </ul>
        </div>

        <div class="section">
            <h2>二、禁止行为</h2>
            <ul>
                <li>禁止发布危险行为、违法行为、赌博、毒品、涉政内容；</li>
                <li>禁止发布“喂老虎”等引导危险行为或鼓励野生动物近距离接触的内容；</li>
                <li>禁止发布侵犯他人隐私、肖像权、著作权的内容；</li>
                <li>禁止散布辱骂、人身攻击、骚扰、歧视等不文明信息；</li>
                <li>禁止重复发布垃圾广告、刷量和其他扰乱平台秩序的内容。</li>
            </ul>
        </div>

        <div class="section">
            <h2>三、用户责任</h2>
            <ul>
                <li>用户应对自己发布的内容负责，遵守国家法律法规及平台规则；</li>
                <li>用户应尊重其他用户的合理权利，避免发布无关或令人不适的内容；</li>
                <li>用户如发现违规内容，可通过平台反馈，平台将按照审核流程处理；</li>
                <li>平台对违规内容有权予以删除、屏蔽、限制发布或封禁账号。</li>
            </ul>
        </div>

        <div class="section">
            <h2>四、审核与管理</h2>
            <ul>
                <li>平台将实行人工审核或机器初审+人工复审机制，重点过滤危险、敏感、违规信息；</li>
                <li>对涉嫌违法违规或不符合旅行信息发布定位的内容，平台可直接删除并通知发布者；</li>
                <li>对于严重违规行为，平台保留终止服务、封禁账号和追究法律责任的权利。</li>
            </ul>
        </div>

        <div class="section">
            <h2>五、平台定位</h2>
            <p>波斯圈为信息发布平台，平台不作为内容生产者，仅提供信息发布工具和存储展示服务，鼓励用户发布真实旅行内容。</p>
        </div>

        <div class="section">
            <h2>六、解释权</h2>
            <p>本公约由平台负责解释和完善。如与国家法律法规冲突，以国家法律法规为准。</p>
        </div>
    </div>
    @include('partials.footer')
</body>
</html>
