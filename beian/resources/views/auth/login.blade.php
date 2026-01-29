<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>登录</title>
    <link rel="stylesheet" href="/build/assets/app.css">
    <style>
    :root{--bg:#f3f4f6;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .page-center{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .auth-card{width:100%;max-width:420px;background:var(--card);border-radius:12px;padding:24px;box-shadow:0 8px 24px rgba(16,24,40,0.08)}
    .auth-card h1{margin:0 0 12px;font-size:22px}
    .input{width:100%;padding:10px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px}
    .file-input{font-size:13px;color:var(--muted)}
    .button-primary{background:var(--accent);color:#fff;padding:10px 14px;border-radius:8px;border:0;cursor:pointer}
    .button-primary:hover{background:#1e40af}
    .avatar-placeholder{width:64px;height:64px;border-radius:9999px;background:#e9eefb;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid #e6eefc}
    .muted{color:var(--muted);font-size:13px}
    .form-group{margin-bottom:12px}
    .error-list{background:#fff1f2;color:#b91c1c;padding:8px;border-radius:6px}
    @media(min-width:640px){.auth-card{padding:28px}}
    </style>

</head>
<body class="page-center">
    @include('partials.navbar')
    <div class="auth-card">
        <h1 class="text-2xl font-semibold mb-4">登录</h1>

        @if($errors->any())
            <div class="error-list mb-4 text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-group">
                <label class="block text-sm font-medium">账号 (用户名)</label>
                    <input name="username" value="{{ old('username') }}" required class="input" />
                <div id="username-help" class="muted" style="font-size:13px;margin-top:6px">账号需为 8-16 位，仅限字母和数字，且同时包含字母和数字。</div>
                <div id="username-error" style="color:#b91c1c;font-size:13px;display:none;margin-top:6px"></div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium">密码</label>
                <input name="password" type="password" required class="input" />
            </div>

            <div class="row" style="margin-top:8px">
                <button type="submit" class="button-primary">登录</button>
                <a href="{{ route('register') }}" class="muted">没有账号？注册</a>
            </div>
        </form>
    </div>
    <script>
    (function(){
        var form = document.querySelector('form[action="{{ route('login.submit') }}"]');
        if(!form) return;
        var username = form.querySelector('input[name="username"]');
        var usernameError = document.getElementById('username-error');
    })();
    </script>
    
</body>
</html>
