<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>发布旅行分享</title>
    <link rel="stylesheet" href="/build/assets/app.css">
    <style>
    :root{--bg:#f8fafc;--card:#ffffff;--accent:#2563eb;--muted:#6b7280}
    body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg)}
    .container{max-width:800px;margin:24px auto;padding:20px}
    .card{background:var(--card);border-radius:12px;padding:24px;margin-bottom:20px;box-shadow:0 6px 20px rgba(16,24,40,0.06)}
    .form-group{margin-bottom:20px}
    .form-label{display:block;font-weight:600;margin-bottom:8px;color:#374151}
    .form-input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px}
    .form-textarea{resize:vertical;min-height:120px}
    .form-select{padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff}
    .image-preview{margin-top:8px;max-width:200px;border-radius:8px;display:none}
    .category-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:12px;margin-top:8px}
    .category-option{border:2px solid #e5e7eb;border-radius:8px;padding:12px;text-align:center;cursor:pointer;transition:all 0.2s}
    .category-option:hover{border-color:var(--accent);background:#f0f4ff}
    .category-option.selected{border-color:var(--accent);background:#eff6ff;color:var(--accent);font-weight:600}
    .btn-submit{background:var(--accent);color:#fff;padding:12px 24px;border:0;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;width:100%}
    .btn-submit:hover{background:#1d4ed8}
    .alert{background:#fef3c7;color:#92400e;padding:12px;border-radius:8px;margin-bottom:16px;border:1px solid #fbbf24}
    </style>
</head>
<body>
    @include('partials.navbar')
    <div class="container">
        <h1 style="text-align:center;margin-bottom:32px">分享你的旅行故事</h1>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form id="postCreateForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="form-group">
                    <label class="form-label">标题 *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title') }}" placeholder="给你的旅行起个吸引人的标题" required>
                    @error('title')
                        <div style="color:#ef4444;font-size:14px;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">旅行分类 *</label>
                    <input type="hidden" name="category" id="selected-category" value="{{ old('category') }}">
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
                    <label class="form-label">旅行照片和视频</label>
                    <input id="mediaInput" type="file" name="media[]" accept="image/*,video/*" multiple class="form-input">
                    <div style="color:#6b7280;font-size:13px;margin-top:4px">支持 JPG、PNG、GIF 图片和 MP4、MOV、AVI 视频，单个文件不超过 10MB</div>
                    <div id="media-preview" style="margin-top:12px;display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px"></div>
                    <div id="media-message" style="color:#b91c1c;font-size:13px;margin-top:8px;display:none"></div>
                    @error('media.*')
                        <div style="color:#ef4444;font-size:14px;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">旅行故事 *</label>
                    <textarea name="content" class="form-input form-textarea" placeholder="分享你的旅行经历、攻略、感受..." required>{{ old('content') }}</textarea>
                    @error('content')
                        <div style="color:#ef4444;font-size:14px;margin-top:4px">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">发布分享</button>
            </div>
        </form>
    </div>

    <script>
    (function(fn){ if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn); else fn(); })(function(){
        // 分类选择
        document.querySelectorAll('.category-option').forEach(option => {
            option.addEventListener('click', function() {
                // 移除其他选中状态
                document.querySelectorAll('.category-option').forEach(opt => {
                    opt.classList.remove('selected');
                });

                // 添加当前选中状态
                this.classList.add('selected');

                // 设置隐藏字段值
                document.getElementById('selected-category').value = this.dataset.category;
            });
        });

        // 初始化选中状态
        const selectedCategory = document.getElementById('selected-category').value;
        if (selectedCategory) {
            const el = document.querySelector(`[data-category="${selectedCategory}"]`);
            if (el) el.classList.add('selected');
        }

        // 媒体文件预览与管理：支持删除已选文件，并在再次选择时保留之前的文件
        const mediaInput = document.getElementById('mediaInput');
        const previewContainer = document.getElementById('media-preview');
        const MAX_FILES = 9; // 最大允许的文件数量
        const messageElem = document.getElementById('media-message');
        let filesArray = [];

        function updateInputFiles() {
            // 将 filesArray 同步到实际的 file input（使用 DataTransfer）
            try {
                const dataTransfer = new DataTransfer();
                filesArray.forEach(f => dataTransfer.items.add(f));
                mediaInput.files = dataTransfer.files;
            } catch (err) {
                // 在不支持 DataTransfer 的环境中，表单提交将依赖于原生 input.files（删除将影响体验）
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
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    previewItem.appendChild(img);
                } else {
                    const video = document.createElement('video');
                    video.style.cssText = 'max-width:100%;max-height:100px;border-radius:4px';
                    video.controls = false;
                    video.muted = true;
                    video.preload = 'metadata';
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        video.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    previewItem.appendChild(video);

                    const playButton = document.createElement('div');
                    playButton.innerHTML = '▶️';
                    playButton.style.cssText = 'position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:24px;pointer-events:none';
                    previewItem.appendChild(playButton);
                }

                // 文件序号
                const fileNumber = document.createElement('div');
                fileNumber.textContent = index + 1;
                fileNumber.style.cssText = 'position:absolute;top:4px;left:4px;background:rgba(0,0,0,0.7);color:white;padding:2px 6px;border-radius:4px;font-size:12px';
                previewItem.appendChild(fileNumber);

                // 删除按钮
                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.textContent = '删除';
                delBtn.style.cssText = 'position:absolute;bottom:6px;right:6px;background:rgba(0,0,0,0.7);color:#fff;border:0;padding:6px 8px;border-radius:6px;cursor:pointer;font-size:12px';
                delBtn.addEventListener('click', function() {
                    filesArray.splice(index, 1);
                    updateInputFiles();
                    renderPreviews();
                });
                previewItem.appendChild(delBtn);

                previewContainer.appendChild(previewItem);
            });
        }

        mediaInput.addEventListener('change', function(e) {
            const newFiles = Array.from(e.target.files);

            if (filesArray.length >= MAX_FILES) {
                // 已达上限
                showMessage(`最多只能上传 ${MAX_FILES} 个文件`);
                // 清空 input 的临时选择，保持已选文件不变
                e.target.value = '';
                return;
            }

            // 计算还能添加多少
            const available = MAX_FILES - filesArray.length;
            let toAdd = [];

            for (let i = 0; i < newFiles.length && toAdd.length < available; i++) {
                const f = newFiles[i];
                const exists = filesArray.some(existing => existing.name === f.name && existing.size === f.size && existing.lastModified === f.lastModified);
                if (!exists) toAdd.push(f);
            }

            // 如果有超出的文件，提示用户
            if (newFiles.length > toAdd.length) {
                showMessage(`已达到最多上传数，已添加 ${toAdd.length} 个，最多允许 ${MAX_FILES} 个`);
            } else {
                hideMessage();
            }

            toAdd.forEach(f => filesArray.push(f));

            updateInputFiles();
            renderPreviews();
            // 清空 input 的临时选择，避免重复触发
            e.target.value = '';
        });

        // 页面初次加载时，如果服务端返回了旧的 files（通常不会），这里尝试渲染 input.files
        (function initFromInput() {
            if (mediaInput.files && mediaInput.files.length) {
                filesArray = Array.from(mediaInput.files).slice(0, MAX_FILES);
                if (mediaInput.files.length > MAX_FILES) showMessage(`已截取前 ${MAX_FILES} 个文件`);
                renderPreviews();
            }
        })();

        // 提交前的 sanity-check：打印调试信息并在 detect 到 filesArray 有内容但 input.files 为空时阻止提交
        const postCreateForm = document.getElementById('postCreateForm');
        if (postCreateForm) {
            postCreateForm.addEventListener('submit', async function(e){
                console.log('Submit debug -- filesArray.length:', filesArray.length, 'input.files.length:', mediaInput.files ? mediaInput.files.length : 0);

                // 如果 filesArray 有内容但 input.files 为空，或我们希望始终确保 filesArray 被发送，则使用 fetch+FormData 提交
                if (filesArray.length > 0) {
                    e.preventDefault();
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const formData = new FormData(postCreateForm);

                    // 删除任何可能存在的旧 media[] 字段（FormData.delete 支持删除所有相同名称）
                    formData.delete('media[]');

                    // 将 filesArray 的文件追加到 FormData
                    filesArray.forEach(f => formData.append('media[]', f));

                    try {
                        const resp = await fetch(postCreateForm.action, {
                            method: (postCreateForm.method || 'POST').toUpperCase(),
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
                            // 验证错误，解析并显示详细信息
                            let json;
                            try { json = await resp.json(); } catch(e){ json = null; }
                            console.warn('Validation failed', json);
                            const firstError = json && json.errors ? Object.values(json.errors).flat()[0] : (json && json.message ? json.message : '验证失败');
                            showMessage(firstError || '上传失败：验证错误');
                            return;
                        }

                        if (!resp.ok) throw resp;

                        // 请求成功但未重定向：刷新页面以显示新帖子/成功消息
                        window.location.reload();
                    } catch (err) {
                        console.error('AJAX upload failed', err);
                        // 如果是 Response 对象，尝试读取文本或 json
                        if (err instanceof Response) {
                            try {
                                const txt = await err.text();
                                console.error('Server response text:', txt);
                            } catch (e) {}
                        }
                        showMessage('上传失败，请稍后重试');
                    }

                    return false;
                }

                // 如果没有 filesArray，则允许常规表单提交（或触发后端验证）
            });
        }

        function showMessage(text) {
            if (!messageElem) return;
            messageElem.textContent = text;
            messageElem.style.display = 'block';
            // 自动 4 秒后隐藏
            clearTimeout(messageElem._hideTimeout);
            messageElem._hideTimeout = setTimeout(() => {
                hideMessage();
            }, 4000);
        }

        function hideMessage() {
            if (!messageElem) return;
            messageElem.textContent = '';
            messageElem.style.display = 'none';
        }
    });
    </script>
</body>
</html>