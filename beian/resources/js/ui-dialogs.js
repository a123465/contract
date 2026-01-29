(function(){
    // 非模块化，挂到 window.UI
    function ensureDOM(){
        if (window._UI_INITED) return;
        window._UI_INITED = true;

        // Modal
        const modal = document.createElement('div');
        modal.id = 'ui-modal';
        modal.className = 'ui-modal';
        modal.innerHTML = `
            <div class="ui-modal-backdrop"></div>
            <div class="ui-modal-dialog" role="dialog" aria-modal="true">
                <div id="ui-modal-message" class="ui-modal-message"></div>
                <div class="ui-modal-actions">
                    <button id="ui-modal-cancel" class="ui-btn ui-btn-cancel">取消</button>
                    <button id="ui-modal-confirm" class="ui-btn ui-btn-confirm">确定</button>
                </div>
            </div>`;
        document.body.appendChild(modal);

        // Toast container
        const toastWrap = document.createElement('div');
        toastWrap.id = 'ui-toast-wrap';
        toastWrap.className = 'ui-toast-wrap';
        document.body.appendChild(toastWrap);
    }

    function confirmDialog(message, opts){
        ensureDOM();
        opts = opts || {};
        return new Promise((resolve) => {
            const modal = document.getElementById('ui-modal');
            const msg = document.getElementById('ui-modal-message');
            const btnOk = document.getElementById('ui-modal-confirm');
            const btnCancel = document.getElementById('ui-modal-cancel');

            msg.textContent = message;
            modal.classList.add('ui-modal-open');

            function cleanup(){
                btnOk.removeEventListener('click', onOk);
                btnCancel.removeEventListener('click', onCancel);
                document.querySelector('.ui-modal-backdrop').removeEventListener('click', onCancel);
                modal.classList.remove('ui-modal-open');
            }
            function onOk(){ cleanup(); resolve(true); }
            function onCancel(){ cleanup(); resolve(false); }

            btnOk.addEventListener('click', onOk);
            btnCancel.addEventListener('click', onCancel);

            // backdrop click closes as cancel
            document.querySelector('.ui-modal-backdrop').addEventListener('click', onCancel);
        });
    }

    function showToast(message, type){
        ensureDOM();
        const wrap = document.getElementById('ui-toast-wrap');
        const item = document.createElement('div');
        item.className = 'ui-toast' + (type === 'success' ? ' ui-toast--success' : '') + (type === 'error' ? ' ui-toast--error' : '');
        item.textContent = message;
        wrap.appendChild(item);
        // trigger animation
        requestAnimationFrame(() => item.classList.add('ui-toast--show'));
        setTimeout(()=>{
            item.classList.remove('ui-toast--show');
            setTimeout(()=> item.remove(), 300);
        }, 3500);
    }

    window.UI = {
        confirm: confirmDialog,
        toast: showToast
    };
})();
