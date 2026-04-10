<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>用户协议 - {{ config('app.name', '波斯圈') }}</title>
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
            <h1>用户协议</h1>
            <p>欢迎使用 {{ config('app.name', '波斯圈') }}。本协议是您与本平台之间关于注册、登录、发布内容、会员服务及其他平台功能使用的法律协议。波斯圈为旅行信息发布平台，平台本身不创作内容，所有信息均由用户发布。</p>

            <div class="section">
                <h2>一、协议范围</h2>
                <p>本协议适用于您注册、登录、使用本平台提供的服务。服务内容包括但不限于信息发布、内容展示、搜索发现、内容审核和信息管理等。</p>
            </div>

            <div class="section">
                <h2>二、账号注册与使用</h2>
                <ul>
                    <li>您应提供真实、准确、完整的注册信息，并及时更新；</li>
                    <li>账号和密码由您自行保管，因保管不当造成的损失由您自行承担；</li>
                    <li>未经授权不得冒用他人账号或分享账号给他人使用；</li>
                    <li>账号仅可用于合法的旅行信息发布与浏览，不得用于发布广告、诈骗或其他违规用途。</li>
                </ul>
            </div>

            <div class="section">
                <h2>三、内容发布规则</h2>
                <ul>
                    <li>发布内容应围绕旅行信息、路线、景点、住宿、美食、交通、游记等旅行相关主题；</li>
                    <li>禁止发布危险行为、违法活动、涉政、涉赌、涉毒、医疗诊断、教育考试、出版发行等前置审批内容；</li>
                    <li>禁止发布侵犯他人肖像权、隐私权、著作权等权利的内容；</li>
                    <li>禁止发布虚假、误导性内容和商业刷量信息；</li>
                    <li>平台有权对涉嫌违规内容进行审核、屏蔽、删除或限制发布。</li>
                </ul>
            </div>

            <div class="section">
                <h2>四、会员服务与技术服务费</h2>
                <p>平台提供的会员订阅服务作为技术服务费收取，用于保障内容发布、信息存储、审核管理和系统维护。会员服务详情请参阅 <a href="{{ route('membership.service') }}">《会员服务协议》</a>。</p>
                <ul>
                    <li>会员费用为平台技术服务费，不构成内容创作或传播的保证；</li>
                    <li>会员续费不影响用户发布内容的合法性要求；</li>
                    <li>若用户违反平台规则，平台有权取消会员服务并采取相应处理措施。</li>
                </ul>
            </div>

            <div class="section">
                <h2>五、知识产权</h2>
                <p>您在平台发布的内容仍由您或相关权利人享有权利，但您同意授予平台必要权利以展示、存储和传播该内容。平台对自身界面、设计、功能及内容拥有所有权或许可权。</p>
            </div>

            <div class="section">
                <h2>六、免责声明</h2>
                <p>平台将尽力提供稳定服务，但不对因网络、系统、第三方服务等不可控因素导致的中断、错误或信息丢失承担全部责任。对于因您违反本协议或发布违规内容所引发的损失，平台不承担责任。</p>
            </div>

            <div class="section">
                <h2>七、协议修改</h2>
                <p>平台有权根据法律法规或服务需要修订本协议。修改后，我们会通过适当方式告知您。若您继续使用服务，则视为您已接受修订后的条款。</p>
            </div>

            <div class="section">
                <h2>八、法律适用</h2>
                <p>本协议适用中华人民共和国法律。若发生争议，双方可协商解决；协商不成的，任一方可向平台所在地人民法院提起诉讼。</p>
            </div>
        </div>
        @include('partials.footer')
    </body>
</html>
