<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>会员服务协议 - {{ config('app.name', '波斯圈') }}</title>
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
        <h1>会员服务协议</h1>
        <p>本协议适用于您使用 {{ config('app.name', '波斯圈') }} 会员服务的相关事项。平台提供的会员订阅服务为平台技术服务费，主要用于保障用户信息发布、内容展示、审核和系统维护。</p>

        <div class="section">
            <h2>一、服务内容</h2>
            <p>会员服务是平台向用户提供的技术服务，内容包括但不限于：</p>
            <ul>
                <li>持续稳定的内容发布通道；</li>
                <li>发布内容的存储与展示支持；</li>
                <li>内容审核与管理能力的保障；</li>
                <li>基础运营与系统维护服务。</li>
            </ul>
        </div>

        <div class="section">
            <h2>二、服务价格与支付</h2>
            <p>会员服务价格为 10 元/月，作为平台技术服务费收取。用户支付后即可继续使用本平台的发布与管理功能。</p>
            <p>支付方式包括平台支持的在线支付渠道，具体支付流程以平台页面说明为准。</p>
        </div>

        <div class="section">
            <h2>三、续费与取消</h2>
            <ul>
                <li>会员服务按月计费，用户可自主选择是否续费；</li>
                <li>若用户在下一个计费周期未续费，则会员服务自动停止，相关高级功能将恢复为普通用户权限；</li>
                <li>用户可随时关闭自动续费或停止订阅。</li>
            </ul>
        </div>

        <div class="section">
            <h2>四、退款政策</h2>
            <p>平台会员服务为技术服务性质，不支持已发生周期的退款。若因平台原因导致服务中断，平台可在合理范围内提供补偿或内部账户余额调整。</p>
            <p>如您对退款有疑问，请通过平台提供的客服或邮箱与我们联系。</p>
        </div>

        <div class="section">
            <h2>五、用户责任</h2>
            <ul>
                <li>用户应保证其发布内容合法合规、真实准确，不侵犯他人合法权益；</li>
                <li>不得发布含有危险行为、违法活动、敏感政治、医疗建议、涉赌涉毒等内容；</li>
                <li>会员服务费用仅用于技术能力支持，不保证内容推广效果；</li>
                <li>若用户违反平台规则，平台有权取消会员资格并处理违规内容。</li>
            </ul>
        </div>

        <div class="section">
            <h2>六、法律适用</h2>
            <p>本协议适用中华人民共和国法律，若发生争议，双方可协商解决；协商不成的，任一方可向平台所在地人民法院提起诉讼。</p>
        </div>

        <div class="section">
            <h2>七、联系我们</h2>
            <p>如您对本协议或会员服务有任何疑问，请联系：<br>邮箱：a19168778773@163.com<br>电话：19168778773</p>
        </div>
    </div>
    @include('partials.footer')
</body>
</html>
