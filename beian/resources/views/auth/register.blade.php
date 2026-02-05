<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>注册</title>
    <link rel="stylesheet" href="/build/assets/app.css">
    <style>
    :root{--bg:#f3f4f6;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .page-center{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .auth-card{width:100%;max-width:420px;background:var(--card);border-radius:12px;padding:24px;box-shadow:0 8px 24px rgba(16,24,40,0.08)}
    .auth-card h1{margin:0 0 12px;font-size:22px}
    .input{width:90%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px}
    .file-input{font-size:13px;color:var(--muted)}
    .button-primary{background:var(--accent);color:#fff;padding:10px 14px;border-radius:8px;border:0;cursor:pointer}
    .button-primary:hover{background:#1e40af}
    .avatar-placeholder{width:64px;height:64px;border-radius:9999px;background:#e9eefb;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid #e6eefc}
    .muted{color:var(--muted);font-size:13px}
    .help-inline{display:inline-flex;align-items:center;gap:6px}
    .form-group{margin-bottom:12px}
    .error-list{background:#fff1f2;color:#b91c1c;padding:8px;border-radius:6px}
    @media(min-width:640px){.auth-card{padding:28px}}
    </style>
    
</head>
<body class="page-center">
    @include('partials.navbar')
    <div class="auth-card">
        <h1 class="text-2xl font-semibold mb-4">注册</h1>
        <form action="{{ route('register.submit') }}" method="POST" novalidate>
            @csrf

            @if($errors->any())
                <div class="form-group error-list">
                    <ul style="margin:0;padding-left:18px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label class="muted">账号</label>
                <input class="input" name="username" type="text" value="{{ old('username') }}" required>
                <div id="username-help" class="muted help-inline">账号 8-16 位，包含字母或数字</div>
            </div>

            <div class="form-group">
                <label class="muted">昵称</label>
                <input class="input" name="nickname" type="text" value="{{ old('nickname') }}">
                <div id="nick-help" class="muted help-inline">昵称 4～20 个字符，支持中英文、数字</div>
            </div>

            <div class="form-group">
                <label class="muted">密码</label>
                <input class="input" name="password" type="password" required>
                <div id="pw-help" class="muted help-inline">密码需为 8-16 位，包含字母和数字</div>
            </div>

            <div class="form-group">
                <label class="muted">确认密码</label>
                <input class="input" name="password_confirmation" type="password" required>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:14px">
                <button class="button-primary" type="submit">注册</button>
                <a href="{{ route('login') }}" class="muted" style="text-decoration:none">已有账号？登录</a>
            </div>
        </form>

        <script>
    (function(){
        var form = document.querySelector('form[action="{{ route('register.submit') }}"]');
        if(!form) return;
        
        var username = form.querySelector('input[name="username"]');
        var usernameHelp = document.getElementById('username-help');
        var usernameOrig = usernameHelp ? usernameHelp.textContent : '';
        var usernameRegex = /^(?=.*[A-Za-z0-9]).{8,16}$/;
        var nick = form.querySelector('input[name="nickname"]');
        var nickHelp = document.getElementById('nick-help');
        var nickOrig = nickHelp ? nickHelp.textContent : '';
        var nickRegex = /^[\u4e00-\u9fffA-Za-z0-9]{4,20}$/;

        var pw = form.querySelector('input[name="password"]');
        var pwConfirm = form.querySelector('input[name="password_confirmation"]');
        var pwHelp = document.getElementById('pw-help');
        var pwOrig = pwHelp ? pwHelp.textContent : '';
        var regex = /^(?=.*[A-Za-z])(?=.*\d).{8,16}$/;

        function validatePassword(){
            if(!pw) return true;
            var v = pw.value || '';
            if(!regex.test(v)){
                if(pwHelp){ pwHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 密码需为 8-16 位，且至少包含字母和数字。'; pwHelp.style.color = '#b91c1c'; }
                return false;
            }
            // if confirm mismatch shown earlier, leave validateConfirm to handle
            if(pwHelp){ pwHelp.textContent = pwOrig; pwHelp.style.color = ''; }
            return true;
        }

        function validateConfirm(){
            if(!pw || !pwConfirm) return true;
            if(pw.value !== pwConfirm.value){
                if(pwHelp){ pwHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 两次输入的密码不一致'; pwHelp.style.color = '#b91c1c'; }
                return false;
            }
            if(pwHelp){ pwHelp.textContent = pwOrig; pwHelp.style.color = ''; }
            return true;
        }

        pw && pw.addEventListener('input', function(){ validatePassword(); validateConfirm(); });
        pwConfirm && pwConfirm.addEventListener('input', validateConfirm);
        username && username.addEventListener('input', function(){
            if(!usernameRegex.test(username.value || '')){
                if(usernameHelp){ usernameHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 账号需为 8-16 位，且至少包含字母或数字。'; usernameHelp.style.color = '#b91c1c'; }
            } else { if(usernameHelp){ usernameHelp.textContent = usernameOrig; usernameHelp.style.color = ''; } }
        });

        nick && nick.addEventListener('input', function(){
                if(!nickRegex.test(nick.value || '')){
                if(nickHelp){ nickHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 昵称需为 4-20 个字符，支持中英文、数字。'; nickHelp.style.color = '#b91c1c'; }
            } else { if(nickHelp){ nickHelp.textContent = nickOrig; nickHelp.style.color = ''; } }
        });

        form.addEventListener('submit', function(e){
            var ok = validatePassword() & validateConfirm();
            if(username && !usernameRegex.test(username.value || '')) ok = false;
            if(nick && !nickRegex.test(nick.value || '')) ok = false;
            if(!ok){ e.preventDefault(); }
        });
    })();
    </script>
</body>
</html>
