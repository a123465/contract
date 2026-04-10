
<footer style="border-top:1px solid #e9e9e6;background:transparent;">
    <div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;padding:12px 16px;">
        <div style="display:flex;align-items:center;gap:8px;color:#6f6d6a;font-size:13px;flex-wrap:wrap;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="opacity:0.9">
                <path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z" fill="#f2f2f2" stroke="#d0d0d0"/>
                <path d="M9.5 10.5c.5 1 1.5 2 2.5 2s2-1 2.5-2" stroke="#6f6d6a" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
            <span style="color:#6f6d6a"><a href="https://beian.miit.gov.cn/" target="_blank">粤ICP备2025512979号-1</a></span>
            <a href="https://beian.miit.gov.cn" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;opacity:0.95;border-bottom:1px dashed rgba(0,0,0,0.05);padding-bottom:1px">查看备案</a>
            <span style="opacity:0.8;">|</span>
            <span>经营性网站</span>
            <span>资质申请中</span>
        </div>

        <div style="width:1px;height:18px;background:#e6e6e6;opacity:0.9"></div>

        <div style="color:#6f6d6a;font-size:13px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            <span>深圳市波斯圈信息技术服务有限公司</span>
            <span>地址：深圳市南山区南山大道1088号南园枫叶大厦26D</span>
            <span>电话：19168778773</span>
            <span>邮箱：a19168778773@163.com</span>
            <span>&copy; {{ date('Y') }} {{ config('app.name', '深圳市波斯圈信息技术服务有限公司') }}</span>
            <span style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                <a href="{{ route('about') }}" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;opacity:0.95;border-bottom:1px dashed rgba(0,0,0,0.05);padding-bottom:1px">关于我们</a>
                <a href="{{ route('privacy.policy') }}" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;opacity:0.95;border-bottom:1px dashed rgba(0,0,0,0.05);padding-bottom:1px">《隐私政策》</a>
                <a href="{{ route('user.agreement') }}" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;opacity:0.95;border-bottom:1px dashed rgba(0,0,0,0.05);padding-bottom:1px">《用户协议》</a>
                <a href="{{ route('membership.service') }}" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;opacity:0.95;border-bottom:1px dashed rgba(0,0,0,0.05);padding-bottom:1px">《会员服务协议》</a>
                <a href="{{ route('community.guidelines') }}" target="_blank" rel="noopener noreferrer" style="color:inherit;text-decoration:none;opacity:0.95;border-bottom:1px dashed rgba(0,0,0,0.05);padding-bottom:1px">《社区公约》</a>
            </span>
        </div>
    </div>
</footer>

