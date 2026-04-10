<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>隐私政策 - {{ config('app.name', '波斯圈') }}</title>
        <style>
            body { margin:0; font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; background:#f9f9f9; color:#1a1a1a; }
            .page { max-width:900px; margin:0 auto; padding:32px 16px; }
            .page h1, .page h2 { color:#111; }
            .page p, .page li { line-height:1.75; font-size:15px; color:#444; }
            .page a { color:#f53003; text-decoration:underline; }
            .section { margin-top:32px; }
            .section ul { padding-left:20px; }
        </style>
    </head>
    <body>
        <div class="page">
            <h1>隐私政策</h1>
            <p>欢迎使用 {{ config('app.name', '波斯圈') }}。我们高度重视用户个人信息保护，本隐私政策说明我们如何收集、使用、存储、分享和保护您的个人信息。若您使用本平台服务，即表示您已阅读、理解并同意本隐私政策。</p>

            <div class="section">
                <h2>一、我们收集的信息</h2>
                <p>我们可能会收集以下类型的信息：</p>
                <ul>
                    <li>注册信息：如用户名、昵称、邮箱、手机号码等；</li>
                    <li>身份信息：如实名认证信息、身份验证结果等；</li>
                    <li>发布信息：如您在平台发布的帖子、图片、视频等内容；</li>
                    <li>使用信息：如登录时间、浏览记录、发布行为、搜索行为等；</li>
                    <li>设备信息：如设备型号、操作系统、IP地址、浏览器类型、位置信息（仅在您授权时）等。</li>
                </ul>
            </div>

            <div class="section">
                <h2>二、信息用途</h2>
                <p>我们将收集到的信息用于以下用途：</p>
                <ul>
                    <li>提供和维护平台服务；</li>
                    <li>支持用户注册、登录、发布内容、浏览和搜索功能；</li>
                    <li>改善产品体验和功能优化；</li>
                    <li>实现实名认证、账户安全、反作弊和风险控制；</li>
                    <li>向您发送与服务相关的通知、公告和更新；</li>
                    <li>满足法律法规要求。</li>
                </ul>
            </div>

            <div class="section">
                <h2>三、信息共享与披露</h2>
                <p>我们承诺在下列情形之外不向第三方公开、共享您的个人信息：</p>
                <ul>
                    <li>获得您明确授权；</li>
                    <li>为提供服务所必需，如第三方支付、短信验证、客服支持等；</li>
                    <li>符合法律法规或司法机关要求；</li>
                    <li>为保护您或他人的合法权益、生命财产安全。</li>
                </ul>
            </div>

            <div class="section">
                <h2>四、信息存储与安全</h2>
                <p>我们采取合理的技术和管理措施保护您的个人信息安全，包括访问控制、加密传输、数据备份、权限审计等，防止信息泄露、丢失、损毁和被篡改。</p>
                <p>若发生数据泄露、损毁等安全事件，我们将按照法律法规要求及时通知用户并采取补救措施。</p>
            </div>

            <div class="section">
                <h2>五、用户权利</h2>
                <p>您有权根据法律规定行使以下权利：</p>
                <ul>
                    <li>访问和复制您的个人信息；</li>
                    <li>修改或更新不准确或不完整的信息；</li>
                    <li>删除您的个人信息（法律法规另有规定的除外）；</li>
                    <li>拒绝我们对部分个人信息的处理。</li>
                </ul>
                <p>如您需要行使上述权利，请通过本政策末尾提供的联系方式与我们联系。</p>
            </div>

            <div class="section">
                <h2>六、儿童信息保护</h2>
                <p>平台不针对未满18周岁人员提供用户注册服务。若发现未成年人在未经监护人同意的情况下提交个人信息，平台将采取措施停止相关服务并删除相关信息。</p>
            </div>

            <div class="section">
                <h2>七、我们如何处理发布内容</h2>
                <p>用户发布的帖子等内容属于用户生成内容。平台对用户内容实行审核管理，并保留显示、存储、引用和传播必要的权利。遇到违法违规内容时，平台有权依据本政策进行处理。</p>
            </div>

            <div class="section">
                <h2>八、联系我们</h2>
                <p>如果您对本隐私政策有任何疑问，请联系：<br>邮箱：a19168778773@163.com<br>电话：19168778773</p>
            </div>
        </div>
        @include('partials.footer')
    </body>
</html>
