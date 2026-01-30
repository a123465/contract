<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>账号安全</title>
    @include('partials.profile-styles')
</head>
<body>
    @include('partials.navbar')
    <div class="page">
        <div class="profile-header">
            @if($user->avatar)
                <img src="{{ $user->avatar_url }}" alt="avatar" class="avatar-large">
            @else
                <div class="avatar-placeholder">{{ strtoupper(substr($user->username ?? 'U',0,1)) }}</div>
            @endif
            <div>
                <h2 style="margin:0">{{ $user->nickname ?? $user->username }}</h2>
                <div class="muted" style="margin-top:6px">账号安全中心</div>
            </div>
            <div class="profile-actions">
                <button type="button" class="btn btn-ghost" onclick="location.href='{{ route('profile') }}'">查看主页</button>
            </div>
        </div>

        <div class="layout">
            <div class="main">
                <div class="card">
                    <h3 style="margin-top:0">修改密码</h3>
                    @if(session('success'))<div style="background:#ecfdf5;padding:8px;border-radius:6px;margin:8px 0;color:#065f46">{{ session('success') }}</div>@endif
                    <form id="change-password-form" action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        <div style="margin-top:8px"><input name="current_password" type="password" class="input" placeholder="当前密码" required></div>
                        <div style="margin-top:8px">
                            <input id="new-password" name="password" type="password" class="input" placeholder="新密码" required pattern="(?=.*[A-Za-z])(?=.*\\d).{8,16}">
                            <div id="pw-help" class="muted" style="font-size:13px;margin-top:6px">密码需为 8-16 位，且至少包含字母和数字，可包含特殊字符。</div>
                        </div>
                        <div style="margin-top:8px"><input id="new-password-confirm" name="password_confirmation" type="password" class="input" placeholder="确认新密码" required></div>
                        <div class="form-actions">
                            <button style="margin-top:10px" type="submit" class="btn btn-primary">保存密码</button>
                        </div>
                    </form>
                    <script>
                    (function(){
                        var form = document.getElementById('change-password-form');
                        if(!form) return;
                        var pw = document.getElementById('new-password');
                        var pwc = document.getElementById('new-password-confirm');
                        var pwHelp = document.getElementById('pw-help');
                        var pwOrig = pwHelp ? pwHelp.textContent : '';
                        var regex = /^(?=.*[A-Za-z])(?=.*\\d).{8,16}$/;

                        function validate(){
                            if(!pw) return true;
                            var ok = true;
                            if(!regex.test(pw.value || '')){ ok = false; if(pwHelp){ pwHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 密码需为 8-16 位，且至少包含字母和数字。'; pwHelp.style.color = '#b91c1c'; } }
                            else if(pw.value !== (pwc?.value || '')){ ok = false; if(pwHelp){ pwHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 两次输入的密码不一致'; pwHelp.style.color = '#b91c1c'; } }
                            if(ok && pwHelp){ pwHelp.textContent = pwOrig; pwHelp.style.color = ''; }
                            return ok;
                        }

                        pw && pw.addEventListener('input', validate);
                        pwc && pwc.addEventListener('input', validate);
                        form.addEventListener('submit', function(e){ if(!validate()) e.preventDefault(); });
                    })();
                    </script>
                </div>

                <div class="card" style="margin-top:16px">
                    <h3 style="margin-top:0">最近登录记录</h3>
                    <div style="margin-top:8px">
                        @if($records->isEmpty())
                            <div class="muted">暂无最近登录记录。</div>
                        @else
                            <ul style="list-style:none;padding:0;margin:0">
                                @foreach($records as $rec)
                                        <li style="padding:8px;border-bottom:1px solid #f3f4f6">
                                            <div style="font-size:13px">IP: {{ $rec->ip_address ?? '未知' }} · 上次活动: {{ date('Y-m-d H:i:s', $rec->last_activity) }}</div>
                                            <div class="muted" style="font-size:12px">{{ \Illuminate\Support\Str::limit($rec->user_agent, 120) }}</div>
                                        </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <aside class="aside">
                <div class="card">
                    <h4 style="margin-top:0">安全概览</h4>
                    <div style="margin-top:8px" class="muted">账号：{{ $user->username }}</div>
                    <div style="margin-top:6px" class="muted">绑定手机号：{{ $user->phone ?? '未绑定' }}</div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
@include('partials.footer')
