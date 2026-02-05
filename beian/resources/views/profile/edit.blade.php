<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>编辑资料</title>
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

            <div class="profile-meta">
                <div class="profile-title-section">
                    <h1>{{ $user->nickname ?? $user->username }} {{ $user->hometown ? '· '.$user->hometown : '' }}
                    @if($user->isMember())
                    <span class="member-badge" title="会员用户">👑</span>
                    @endif
                    </h1>
                </div>

                @if(!$user->isMember())
                <div class="membership-cta">
                    <a href="{{ route('membership') }}" class="btn btn-outline-premium" style="border:2px solid #f59e0b;background:#fff;color:#f59e0b;padding:10px 20px;text-decoration:none;border-radius:8px;font-weight:500;display:inline-block;position:relative;z-index:10;">成为会员</a>
                </div>
                @endif

                <div class="profile-info">
                    <div class="muted">{{ $user->occupation ?? '' }}</div>
                    <div class="bio">{{ $user->bio ?? '这位用户很懒，未填写简介。' }}</div>
                </div>

                @if($user->isMember())
                <div class="member-status">
                    <span class="member-label">会员用户</span>
                    <span class="member-plan">{{ ucfirst($user->membership->plan) }}会员</span>
                    @if($user->membership->expires_at)
                    <span class="member-expiry">到期: {{ $user->membership->expires_at->format('Y-m-d') }}</span>
                    @endif
                </div>
                @endif

                <div class="stat-list">
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->posts->count() }}</div>
                        <div class="stat-label">分享</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->likedPosts->count() }}</div>
                        <div class="stat-label">点赞</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->favoritedPosts->count() }}</div>
                        <div class="stat-label">收藏</div>
                    </div>
                    @if($user->isMember())
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->comments->count() }}</div>
                        <div class="stat-label">评论</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="profile-actions">
                <button type="button" class="btn btn-ghost" onclick="location.href='{{ route('profile') }}'">查看主页</button>
            </div>
        </div>
        <div class="settings-layout">
            <div class="main">
                <div class="card">
                    <h3 style="margin-top:0">账号信息设置</h3>
                    @if(session('success'))<div style="background:#ecfdf5;padding:8px;border-radius:6px;margin:8px 0;color:#065f46">{{ session('success') }}</div>@endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="birthday" id="birthday" value="{{ old('birthday', $user->birthday?->format('Y-m-d') ?? '') }}">

                        <div style="text-align:center;padding:12px 0">
                            <div id="avatar-upload-area" style="position:relative;display:inline-block;cursor:pointer;border-radius:9999px;overflow:hidden;">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar_url }}" alt="avatar" id="avatar-preview" style="width:96px;height:96px;border-radius:9999px;object-fit:cover;border:4px solid #fff;box-shadow:0 4px 12px rgba(16,24,40,0.08);transition:opacity 0.2s">
                                @else
                                    <div id="avatar-preview" style="width:96px;height:96px;border-radius:9999px;background:#eef2ff;color:#2563eb;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:28px;border:4px solid #fff;box-shadow:0 4px 12px rgba(16,24,40,0.08);transition:opacity 0.2s">{{ strtoupper(substr($user->username ?? 'U',0,1)) }}</div>
                                @endif
                                <!-- <div style="position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;color:white;font-size:12px;font-weight:500">
                                    点击更换头像
                                </div> -->
                            </div>
                            <input type="file" name="avatar" id="avatar-input" accept="image/*" style="display:none">
                            <div style="margin-top:8px;color:#6b7280;font-size:13px">点击头像区域选择图片，支持 JPG、PNG、GIF 格式，文件大小不超过 2MB</div>
                        </div>

                        <div style="padding:8px 0;border-top:1px solid #f3f4f6">
                            <div class="field-row">
                                <div class="field-label">昵称</div>
                                <div class="field-control">
                                    <input name="nickname" class="input" pattern="^[\u4e00-\u9fffA-Za-z0-9]{4,20}$" value="{{ old('nickname', $user->nickname) }}">
                                    <div id="nick-help" class="muted" style="font-size:13px;margin-top:6px">4～20 个字符，支持中英文、数字</div>
                                </div>
                            </div>

                            <div class="field-row">
                                <div class="field-label">简介</div>
                                <div class="field-control">
                                    <textarea name="bio" class="input" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                    <div class="muted" style="font-size:13px;margin-top:6px">1～140 个字符</div>
                                </div>
                            </div>

                        </div>

                        <h4 style="margin-top:18px">个人基本资料</h4>
                        <div style="border-top:1px solid #f3f4f6;margin-top:8px;padding-top:8px">
                            <div class="field-row">
                                <div class="field-label">性别</div>
                                <div class="field-control">
                                    <label style="margin-right:12px"><input type="radio" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}> 男</label>
                                    <label><input type="radio" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}> 女</label>
                                </div>
                            </div>

                            <div class="field-row">
                                <div class="field-label">生日</div>
                                <div class="field-control">
                                    <div class="birth-selectors">
                                        <select name="birth_year" class="input" style="width:120px">
                                            <option value="">年</option>
                                            @php $yNow = date('Y'); @endphp
                                            @for($y = $yNow; $y >= 1900; $y--)
                                                <option value="{{ $y }}" {{ (old('birth_year') ?: ($user->birthday?->format('Y') ?? '')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                        <select name="birth_month" class="input" style="width:90px">
                                            <option value="">月</option>
                                            @for($m=1;$m<=12;$m++)
                                                <option value="{{ $m }}" {{ (old('birth_month') ?: ($user->birthday?->format('n') ?? '')) == $m ? 'selected' : '' }}>{{ $m }}</option>
                                            @endfor
                                        </select>
                                        <select name="birth_day" class="input" style="width:90px">
                                            <option value="">日</option>
                                            @for($d=1;$d<=31;$d++)
                                                <option value="{{ $d }}" {{ (old('birth_day') ?: ($user->birthday?->format('j') ?? '')) == $d ? 'selected' : '' }}>{{ $d }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="field-row">
                                <div class="field-label">家乡</div>
                                <div class="field-control">
                                    <input name="hometown" class="input" value="{{ old('hometown', $user->hometown) }}" placeholder="例如：北京">
                                    <div class="muted" style="font-size:13px;margin-top:6px">可手动输入家乡，例如“北京市 朝阳区”</div>
                                </div>
                            </div>

                            <div style="margin-top:12px;display:flex;align-items:center;gap:8px">
                                <button type="submit" class="btn btn-primary">保存</button>
                                <a href="{{ route('profile') }}" class="btn" style="color:#6b7280">取消</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <aside class="aside">
                <div class="card">
                    <h4 style="margin-top:0">关于我</h4>
                    <div class="muted" style="margin-top:8px">昵称：{{ $user->nickname ?? '-' }}</div>
                    <div class="muted" style="margin-top:6px">账号：{{ $user->username }}</div>
                </div>
            </aside>
        </div>
    </div>

    <script>
    (function(){
        var form = document.querySelector('form[action="{{ route('profile.update') }}"]');
        if(!form) return;
        var nick = form.querySelector('input[name="nickname"]');
        var nickHelp = document.getElementById('nick-help');
        var nickOrig = nickHelp ? nickHelp.textContent : '';
        var nickRegex = /^[\u4e00-\u9fffA-Za-z0-9]{4,20}$/;
        var birthYear = form.querySelector('select[name="birth_year"]');
        var birthMonth = form.querySelector('select[name="birth_month"]');
        var birthDay = form.querySelector('select[name="birth_day"]');
        var birthdayHidden = document.getElementById('birthday');

        // Avatar upload handling
        var avatarUploadArea = document.getElementById('avatar-upload-area');
        var avatarInput = document.getElementById('avatar-input');
        var avatarPreview = document.getElementById('avatar-preview');

        if(avatarUploadArea && avatarInput) {
            avatarUploadArea.addEventListener('click', function() {
                avatarInput.click();
            });

            avatarUploadArea.addEventListener('mouseenter', function() {
                this.querySelector('div:last-child').style.opacity = '1';
                avatarPreview.style.opacity = '0.7';
            });

            avatarUploadArea.addEventListener('mouseleave', function() {
                this.querySelector('div:last-child').style.opacity = '0';
                avatarPreview.style.opacity = '1';
            });

            avatarInput.addEventListener('change', function(e) {
                var file = e.target.files[0];
                if(file) {
                    // Validate file type
                    var allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if(!allowedTypes.includes(file.type)) {
                        alert('请选择有效的图片文件（JPG、PNG、GIF）');
                        this.value = '';
                        return;
                    }

                    // Validate file size (2MB)
                    if(file.size > 2 * 1024 * 1024) {
                        alert('图片文件大小不能超过2MB');
                        this.value = '';
                        return;
                    }

                    // Preview image
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        if(avatarPreview.tagName === 'IMG') {
                            avatarPreview.src = e.target.result;
                        } else {
                            // Replace div with img
                            var img = document.createElement('img');
                            img.id = 'avatar-preview';
                            img.src = e.target.result;
                            img.style = avatarPreview.style.cssText;
                            avatarPreview.parentNode.replaceChild(img, avatarPreview);
                            avatarPreview = img;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        nick && nick.addEventListener('input', function(){
            if(!nickRegex.test(nick.value || '')){
                if(nickHelp){ nickHelp.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:6px"><circle cx="12" cy="12" r="10" fill="#ef4444"/><path d="M8 8 L16 16 M16 8 L8 16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg> 昵称需为 4-20 个字符，支持中英文、数字。'; nickHelp.style.color = '#b91c1c'; }
            } else { if(nickHelp){ nickHelp.textContent = nickOrig; nickHelp.style.color = ''; } }
        });

        form.addEventListener('submit', function(e){
            if(nick && !nickRegex.test(nick.value || '')){ e.preventDefault(); return; }
            // combine birth selects into single birthday field (YYYY-MM-DD) if all provided
            if(birthYear && birthMonth && birthDay && birthdayHidden){
                var y = (birthYear.value || '').trim();
                var m = (birthMonth.value || '').trim();
                var d = (birthDay.value || '').trim();
                if(y && m && d){
                    if(m.length === 1) m = '0' + m;
                    if(d.length === 1) d = '0' + d;
                    birthdayHidden.value = y + '-' + m + '-' + d;
                } else {
                    birthdayHidden.value = '';
                }
            }
        });
    })();
    </script>
    <style>
    .field-row{display:flex;align-items:flex-start;gap:16px;padding:14px 0;border-bottom:1px solid #f3f4f6}
    .field-label{width:120px;color:#6b7280;padding-top:6px}
    .field-control{flex:1}
    .field-control .input{background:#f3f4f6;border:0}
    @media (max-width:600px){
        .field-row{flex-direction:column;gap:8px}
        .field-label{width:100%;font-weight:500;color:#374151}
        .birth-selectors{display:flex;gap:8px;flex-wrap:wrap}
        .birth-selectors select{flex:1;min-width:80px}
        #avatar-upload-area img, #avatar-upload-area div{width:80px !important;height:80px !important;font-size:24px !important}
    }
    </style>
</body>
</html>
@include('partials.footer')
