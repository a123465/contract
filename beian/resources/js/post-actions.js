(function(){
    function initAjaxActions(){
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrf = csrfMeta ? csrfMeta.getAttribute('content') : null;
        if (!csrf) return;

        document.querySelectorAll('form.ajax-action').forEach(form => {
            // avoid adding twice
            if (form._ajaxBound) return;
            form._ajaxBound = true;

            form.addEventListener('submit', function(e){
                e.preventDefault();
                const action = form.action;
                const btn = form.querySelector('button');

                if (!btn) return;

                // 防止重复点击：禁用按钮并显示 spinner
                btn.disabled = true;
                btn.setAttribute('aria-busy','true');
                const spinner = document.createElement('span');
                spinner.className = 'ajax-spinner';
                btn.appendChild(spinner);

                // 发送 AJAX 请求
                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                }).then(resp => {
                    if (resp.status === 401) {
                        // 未登录，跳转到登录页
                        window.location.href = '/login';
                        return;
                    }
                    if (!resp.ok) throw resp;
                    return resp.json();
                }).then(data => {
                    if (!data) return;
                    // 移除 spinner
                    spinner.remove();
                    btn.removeAttribute('aria-busy');
                    btn.disabled = false;

                    // 处理点赞响应
                    if (data.liked !== undefined) {
                        if (data.liked) btn.classList.add('liked'); else btn.classList.remove('liked');
                        btn.innerHTML = '❤️ ' + (data.likes_count ?? '0');
                    }
                    // 处理收藏响应
                    if (data.favorited !== undefined) {
                        if (data.favorited) btn.classList.add('favorited'); else btn.classList.remove('favorited');
                        btn.innerHTML = '⭐ ' + (data.favorites_count ?? '0');
                    }
                }).catch(err => {
                    console.error('AJAX action error', err);
                    // 恢复状态
                    spinner.remove();
                    btn.removeAttribute('aria-busy');
                    btn.disabled = false;
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAjaxActions);
    } else {
        initAjaxActions();
    }
})();
