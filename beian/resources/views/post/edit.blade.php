<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>编辑旅行分享</title>
    <link rel="stylesheet" href="/build/assets/app.css">
    <style>
        .container{max-width:960px;margin:24px auto;padding:0 16px}
        .card{background:#fff;border-radius:8px;padding:18px;box-shadow:0 1px 3px rgba(0,0,0,0.06);margin-bottom:18px}
        .form-group{margin-bottom:14px}
        .form-label{display:block;font-weight:600;margin-bottom:8px}
        .form-input{width:100%;padding:8px 10px;border:1px solid #e5e7eb;border-radius:6px}
        .form-textarea{min-height:140px}
        .btn-submit{background:#0ea5a4;color:#fff;border:0;padding:10px 14px;border-radius:6px;cursor:pointer}
        .btn-submit[style]{/* keep inline overrides */}
        .existing-item img,.existing-item video{width:100%;height:100%;object-fit:cover;display:block}
        #media-preview img,#media-preview video{width:100%;height:100px;object-fit:cover;border-radius:4px}
        .category-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:12px;margin-top:8px}
        .category-option{border:2px solid #e5e7eb;border-radius:8px;padding:12px;text-align:center;cursor:pointer;transition:all 0.15s;background:#fff}
        .category-option:hover{border-color:#2563eb;background:#f0f4ff}
        .category-option.selected{border-color:#2563eb;background:#eff6ff;color:#2563eb;font-weight:600}
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <h1 style="text-align:center;margin-bottom:32px">编辑你的旅行分享</h1>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form id="postEditForm" action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="form-group">
                    <label class="form-label">标题 *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $post->title) }}" placeholder="给你的旅行起个吸引人的标题" required>
                    @error('title')
                        <div style="color:#ef4444;font-size:14px;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">旅行分类 *</label>
                    <input type="hidden" name="category" id="selected-category" value="{{ old('category', $post->category) }}">
                    <div class="category-grid">
                        <div class="category-option" data-category="城市旅行">
                            🏙️ 城市旅行
                        </div>
                        <div class="category-option" data-category="户外冒险">
                            🏔️ 户外冒险
                        </div>
                        <div class="category-option" data-category="海滩度假">
                            🏖️ 海滩度假
                        </div>
                        <div class="category-option" data-category="文化体验">
                            🏛️ 文化体验
                        </div>
                        <div class="category-option" data-category="美食探索">
                            🍜 美食探索
                        </div>
                    </div>
                    @error('category')
                        <div style="color:#ef4444;font-size:14px;margin-top:8px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">已有媒体</label>
                    <div id="existing-media" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:12px;margin-bottom:12px">
                        @foreach($post->media as $m)
                            <div class="existing-item" data-id="{{ $m->id }}" style="position:relative;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;background:#f9fafb;min-height:80px;display:flex;align-items:center;justify-content:center;padding:6px">
                                @if($m->file_type === 'image')
                                    <img src="{{ $m->url }}" style="width:100%;height:100%;object-fit:cover;display:block" />
                                @else
                                    <div style="font-size:24px">🎞️</div>
                                @endif
                                <button type="button" class="btn-delete-existing" data-id="{{ $m->id }}" data-url="{{ route('posts.media.destroy', [$post, $m]) }}" style="position:absolute;top:6px;right:6px;background:rgba(0,0,0,0.6);color:#fff;border:0;padding:6px 8px;border-radius:6px;cursor:pointer">删除</button>
                            </div>
                        @endforeach
                    </div>

                    <label class="form-label">新增旅行照片和视频（添加会附加到现有媒体）</label>
                    <input id="mediaInput" type="file" name="media[]" accept="image/*,video/*" multiple class="form-input">
                    <div style="color:#6b7280;font-size:13px;margin-top:4px">支持 JPG、PNG、GIF 图片和 MP4、MOV、AVI 视频，单个文件不超过 10MB；新增文件将附加到已有媒体，总数上限 9 个。</div>
                    <div id="media-preview" style="margin-top:12px;display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px"></div>
                    <div id="media-message" style="color:#b91c1c;font-size:13px;margin-top:8px;display:none"></div>
                    @error('media.*')
                        <div style="color:#ef4444;font-size:14px;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">旅行故事 *</label>
                    <textarea name="content" class="form-input form-textarea" placeholder="分享你的旅行经历、攻略、感受..." required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div style="color:#ef4444;font-size:14px;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">保存修改</button>
            </div>
        </form>
    </div>

    <script>
    (function(fn){ if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn); else fn(); })(function(){
        // 使用与 create.blade.php 相同的分类选择与媒体预览脚本
        document.querySelectorAll('.category-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.category-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selected-category').value = this.dataset.category;
            });
        });

        const selectedCategory = document.getElementById('selected-category').value;
        if (selectedCategory) {
            const el = document.querySelector(`[data-category="${selectedCategory}"]`);
            if (el) el.classList.add('selected');
        }

        // 编辑页：删除帖子使用友好模态确认
        document.querySelectorAll('form.confirm-delete').forEach(form => {
            form.addEventListener('submit', async function(e){
                e.preventDefault();
                const ok = window.UI ? await window.UI.confirm('确定要删除这篇帖子吗？此操作不可恢复。') : confirm('确定要删除这篇帖子吗？此操作不可恢复。');
                if (!ok) return;
                form.submit();
            });
        });

        // 媒体预览（基于 create 的逻辑），并处理已有媒体的删除
        const mediaInput = document.getElementById('mediaInput');
        const previewContainer = document.getElementById('media-preview');
        const existingContainer = document.getElementById('existing-media');
        const MAX_FILES = 9;
        const messageElem = document.getElementById('media-message');
        let filesArray = [];
        // 已存在媒体数量
        let existingCount = existingContainer ? existingContainer.querySelectorAll('.existing-item').length : 0;

        function updateInputFiles() {
            try {
                const dataTransfer = new DataTransfer();
                filesArray.forEach(f => dataTransfer.items.add(f));
                mediaInput.files = dataTransfer.files;
            } catch (err) {
                console.warn('updateInputFiles: DataTransfer not supported', err);
            }
        }

        function renderPreviews() {
            previewContainer.innerHTML = '';
            filesArray.forEach((file, index) => {
                const fileType = file.type.startsWith('image/') ? 'image' : 'video';
                const previewItem = document.createElement('div');
                previewItem.style.cssText = 'position:relative;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;background:#f9fafb;min-height:100px;display:flex;align-items:center;justify-content:center;padding:6px';

                if (fileType === 'image') {
                    const img = document.createElement('img');
                    img.style.cssText = 'max-width:100%;max-height:100px;border-radius:4px';
                    const reader = new FileReader();
                    reader.onload = function(e) { img.src = e.target.result; };
                    reader.readAsDataURL(file);
                    previewItem.appendChild(img);
                } else {
                    const video = document.createElement('video');
                    video.style.cssText = 'max-width:100%;max-height:100px;border-radius:4px';
                    video.controls = false; video.muted = true; video.preload = 'metadata';
                    const reader = new FileReader();
                    reader.onload = function(e) { video.src = e.target.result; };
                    reader.readAsDataURL(file);
                    previewItem.appendChild(video);
                    const playButton = document.createElement('div'); playButton.innerHTML = '▶️'; playButton.style.cssText = 'position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:24px;pointer-events:none'; previewItem.appendChild(playButton);
                }

                const fileNumber = document.createElement('div'); fileNumber.textContent = index + 1; fileNumber.style.cssText = 'position:absolute;top:4px;left:4px;background:rgba(0,0,0,0.7);color:white;padding:2px 6px;border-radius:4px;font-size:12px'; previewItem.appendChild(fileNumber);

                const delBtn = document.createElement('button'); delBtn.type = 'button'; delBtn.textContent = '删除'; delBtn.style.cssText = 'position:absolute;bottom:6px;right:6px;background:rgba(0,0,0,0.7);color:#fff;border:0;padding:6px 8px;border-radius:6px;cursor:pointer;font-size:12px';
                delBtn.addEventListener('click', function() { filesArray.splice(index,1); updateInputFiles(); renderPreviews(); });
                previewItem.appendChild(delBtn);

                previewContainer.appendChild(previewItem);
            });
        }

        mediaInput.addEventListener('change', function(e){
            const newFiles = Array.from(e.target.files);
            if (existingCount + filesArray.length >= MAX_FILES) { showMessage(`最多只能上传 ${MAX_FILES} 个文件`); e.target.value = ''; return; }
            const available = MAX_FILES - existingCount - filesArray.length; let toAdd = [];
            for (let i=0;i<newFiles.length && toAdd.length<available;i++){ const f=newFiles[i]; const exists = filesArray.some(existing=>existing.name===f.name&&existing.size===f.size&&existing.lastModified===f.lastModified); if(!exists) toAdd.push(f); }
            if (newFiles.length>toAdd.length) showMessage(`已达到最多上传数，已添加 ${toAdd.length} 个，最多允许 ${MAX_FILES} 个（含已有媒体）`); else hideMessage();
            toAdd.forEach(f=>filesArray.push(f)); updateInputFiles(); renderPreviews(); e.target.value='';
        });

        (function initFromInput(){ if (mediaInput.files && mediaInput.files.length){ filesArray = Array.from(mediaInput.files).slice(0, MAX_FILES); if (mediaInput.files.length>MAX_FILES) showMessage(`已截取前 ${MAX_FILES} 个文件`); renderPreviews(); }})();

        function showMessage(text){ if(!messageElem) return; messageElem.textContent = text; messageElem.style.display='block'; clearTimeout(messageElem._hideTimeout); messageElem._hideTimeout = setTimeout(()=>hideMessage(),4000); }
        function hideMessage(){ if(!messageElem) return; messageElem.textContent=''; messageElem.style.display='none'; }

        // 删除已有媒体（AJAX）
        if (existingContainer) {
            existingContainer.querySelectorAll('.btn-delete-existing').forEach(btn => {
                btn.addEventListener('click', async function(){
                    const confirmed = window.UI ? await window.UI.confirm('确定要删除此媒体吗？') : confirm('确定要删除此媒体吗？');
                    if (!confirmed) return;
                    const url = btn.dataset.url;
                    const mediaId = btn.dataset.id;
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (!csrf) {
                        if (window.UI) window.UI.toast('无法获得 CSRF token，删除失败', 'error'); else alert('无法获得 CSRF token，删除失败');
                        return;
                    }

                    btn.disabled = true;
                    try {
                        const resp = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            credentials: 'same-origin'
                        });
                        if (!resp.ok) throw resp;
                        const data = await resp.json();
                        const item = existingContainer.querySelector(`.existing-item[data-id="${mediaId}"]`);
                        if (item) item.remove();
                        existingCount = Math.max(0, existingCount - 1);
                        if (window.UI) window.UI.toast(data?.message ?? '媒体已删除', 'success');
                        hideMessage();
                    } catch (err) {
                        console.error('删除媒体失败', err);
                        if (window.UI) window.UI.toast('删除失败', 'error'); else alert('删除失败');
                        btn.disabled = false;
                    }
                });
            });
        }
        // 提交前调试与校验
        const postEditForm = document.getElementById('postEditForm');
        if (postEditForm) {
            postEditForm.addEventListener('submit', async function(e){
                console.log('Edit submit debug -- existingCount:', existingCount, 'filesArray.length:', filesArray.length, 'input.files.length:', mediaInput.files ? mediaInput.files.length : 0);

                // 如果有新增文件，使用 fetch+FormData 提交以确保文件发送
                if (filesArray.length > 0) {
                    e.preventDefault();
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const formData = new FormData(postEditForm);
                    // 删除旧的 media[] 字段
                    formData.delete('media[]');
                    filesArray.forEach(f => formData.append('media[]', f));

                    try {
                        const resp = await fetch(postEditForm.action, {
                            method: (postEditForm.method || 'POST').toUpperCase(),
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData,
                            credentials: 'same-origin',
                            redirect: 'follow'
                        });

                        if (resp.redirected) {
                            window.location = resp.url;
                            return;
                        }

                        if (resp.status === 422) {
                            let json;
                            try { json = await resp.json(); } catch(e){ json = null; }
                            console.warn('Validation failed', json);
                            const firstError = json && json.errors ? Object.values(json.errors).flat()[0] : (json && json.message ? json.message : '验证失败');
                            showMessage(firstError || '上传失败：验证错误');
                            return;
                        }

                        if (!resp.ok) throw resp;
                        window.location.reload();
                    } catch (err) {
                        console.error('AJAX edit upload failed', err);
                        if (err instanceof Response) {
                            try { const txt = await err.text(); console.error('Server response text:', txt); } catch(e) {}
                        }
                        showMessage('上传失败，请稍后重试');
                    }

                    return false;
                }

                // 没有新增文件：让表单默认提交（例如仅修改文本）
            });
        }
    });
    </script>
</body>
</html>
@include('partials.footer')