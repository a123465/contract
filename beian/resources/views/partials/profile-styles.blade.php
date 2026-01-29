<style>
body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:#f5f7fa;color:#111}
.page{max-width:1100px;margin:24px auto;padding:12px}
.profile-header{background:#fff;border-radius:16px;padding:32px;display:flex;gap:24px;align-items:flex-start;box-shadow:0 8px 32px rgba(16,24,40,0.08);position:relative;overflow:hidden;z-index:1}
.profile-header::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);opacity:0.03;border-radius:16px;z-index:1}
.avatar-large{width:140px;height:140px;border-radius:50%;object-fit:cover;border:4px solid #fff;box-shadow:0 8px 32px rgba(0,0,0,0.12)}
.avatar-placeholder{width:140px;height:140px;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:36px;border:4px solid #fff;box-shadow:0 8px 32px rgba(0,0,0,0.12)}
.profile-meta{flex:1;padding-top:8px}
.profile-meta h1{font-size:32px;font-weight:700;margin:0 0 8px 0;color:#111}
.profile-meta .muted{color:#6b7280;font-size:16px;margin-bottom:16px}
.profile-meta .bio{font-size:16px;line-height:1.6;color:#374151;margin-bottom:20px;max-width:600px}
.stat-list{display:flex;gap:24px}
.stat-item{text-align:center}
.stat-number{font-size:24px;font-weight:700;color:#111}
.stat-label{color:#6b7280;font-size:14px;margin-top:4px}
.profile-actions{position:absolute;top:32px;right:32px;display:flex;flex-direction:column;gap:12px;z-index:1000}
.layout{display:flex;gap:18px;margin-top:18px}
.main{flex:1}
.aside{width:300px}
.card{background:#fff;padding:24px;border-radius:16px;box-shadow:0 8px 32px rgba(16,24,40,0.08);border:1px solid #f3f4f6}
.info-row{display:flex;justify-content:space-between;align-items:center;padding:16px 0;border-bottom:1px solid #f3f4f6}
.info-row:last-child{border-bottom:0}
.info-row .muted{color:#6b7280;font-weight:500}
.info-row div:last-child{color:#111;font-weight:500}
.input{box-sizing:border-box;width:100%;max-width:100%;padding:10px;border:1px solid #e5e7eb;border-radius:8px}
.muted{color:#6b7280}
.row{display:flex;gap:12px}
.btn{padding:12px 20px;border-radius:10px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-weight:500;font-size:14px;transition:all 0.2s;cursor:pointer}
.btn-primary{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;border:0;box-shadow:0 4px 16px rgba(102,126,234,0.3)}
.btn-primary:hover{background:linear-gradient(135deg,#5a67d8 0%,#6b46c1 100%);transform:translateY(-1px);box-shadow:0 6px 20px rgba(102,126,234,0.4)}
.btn-ghost{background:#f8fafc;color:#374151;border:1px solid #e5e7eb}
.btn-ghost:hover{background:#f3f4f6;border-color:#d1d5db}
@media (max-width:900px){.layout{flex-direction:column}.aside{width:100%}.settings-sidebar{width:100%}}

/* settings-specific */
.settings-layout{display:flex;gap:18px;margin-top:18px}
.settings-sidebar{width:220px}
.settings-sidebar .menu{background:#fff;border-radius:10px;padding:12px;box-shadow:0 6px 18px rgba(16,24,40,0.06)}
.settings-sidebar .menu a{display:block;padding:10px 12px;border-radius:8px;color:#111;text-decoration:none}
.settings-sidebar .menu a.active{background:#f3f4f6}

/* navbar small helpers used by profile pages */
.muted-small{color:#9ca3af;font-size:13px}
</style>