<style>
body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:#f5f7fa;color:#111}
.page{max-width:1100px;margin:24px auto;padding:12px}
.profile-header{background:#fff;border-radius:16px;padding:32px;gap:24px;align-items:flex-start;justify-content:center;box-shadow:0 8px 32px rgba(16,24,40,0.08);position:relative;overflow:hidden;z-index:1}
.profile-header::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);opacity:0.03;border-radius:16px;z-index:1}
.avatar-large{width:140px;height:140px;border-radius:50%;object-fit:cover;border:4px solid #fff;box-shadow:0 8px 32px rgba(0,0,0,0.12)}
.avatar-placeholder{width:140px;height:140px;border-radius:50%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:36px;border:4px solid #fff;box-shadow:0 8px 32px rgba(0,0,0,0.12)}
.profile-meta{flex:1;padding-top:8px}
.profile-meta h1{font-size:32px;font-weight:700;margin:0 0 8px 0;color:#111}
.member-badge{display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;background:linear-gradient(135deg,#fbbf24,#f59e0b);border-radius:50%;font-size:14px;margin-left:8px;box-shadow:0 2px 8px rgba(245,158,11,0.3);vertical-align:middle}
.profile-title-section{display:flex;align-items:center;margin-bottom:16px}
.membership-cta{margin-bottom:20px}
.profile-info{margin-bottom:20px}
.member-status{display:flex;align-items:center;gap:12px;margin-bottom:16px;padding:8px 16px;background:linear-gradient(135deg,rgba(251,191,36,0.1),rgba(245,158,11,0.1));border-radius:20px;border:1px solid rgba(251,191,36,0.2)}
.member-label{font-size:12px;font-weight:600;color:#92400e;background:#fbbf24;color:#fff;padding:2px 8px;border-radius:12px;text-transform:uppercase;letter-spacing:0.5px}
.member-plan{font-size:14px;font-weight:600;color:#92400e}
.member-expiry{font-size:12px;color:#a16207}
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
@media (max-width:900px){.layout{flex-direction:column}.aside{width:100%}.settings-sidebar{width:100%}.profile-header{justify-content:center;padding:24px 20px}.profile-meta{margin-top:0}.profile-actions{position:fixed;margin-top:83px;display:flex;flex-direction:column;justify-content:center;gap:8px}.settings-layout{flex-direction:column}.profile-title-section{justify-content:flex-start}.membership-cta{text-align:left}}
@media (max-width:600px){.profile-header{flex-direction:row !important;justify-content:center;text-align:left;padding:16px 12px}.avatar-large{width:80px;height:80px;}.profile-meta{flex:1;margin-top:0}.profile-title-section{flex-direction:row;justify-content:space-between;align-items:flex-start;margin-bottom:8px}.profile-title-section h1{font-size:18px;margin:0}.member-badge{margin-left:8px}.membership-cta-mobile{margin-top:8px}.profile-info{text-align:left;margin-bottom:16px}.member-status{text-align:left;margin-bottom:16px}.stat-list{justify-content:flex-start}}

/* settings-specific */
.settings-layout{display:flex;gap:18px;margin-top:18px}
.settings-sidebar{width:220px}
.settings-sidebar .menu{background:#fff;border-radius:10px;padding:12px;box-shadow:0 6px 18px rgba(16,24,40,0.06)}
.settings-sidebar .menu a{display:block;padding:10px 12px;border-radius:8px;color:#111;text-decoration:none}
.settings-sidebar .menu a.active{background:#f3f4f6}

/* navbar small helpers used by profile pages */
.muted-small{color:#9ca3af;font-size:13px}

/* membership styles */
.btn-small{padding:4px 12px;font-size:12px;border-radius:6px}
.btn-outline-premium{background:#fff;color:#f59e0b;border:2px solid #f59e0b}
.btn-outline-premium:hover{background:#fef3c7;border-color:#d97706;color:#d97706}
.btn-premium{background:linear-gradient(135deg,#fbbf24,#f59e0b);color:#fff;border:0}
.btn-premium:hover{background:linear-gradient(135deg,#f59e0b,#d97706)}
.membership-card{background:linear-gradient(135deg,rgba(251,191,36,0.1),rgba(245,158,11,0.05));border:1px solid rgba(251,191,36,0.2)}
.membership-card.non-member{background:linear-gradient(135deg,rgba(37,99,235,0.1),rgba(59,130,246,0.05));border:1px solid rgba(37,99,235,0.2)}
.membership-info{display:flex;flex-direction:column;gap:16px}
.membership-plan{font-size:18px;color:#92400e}
.membership-expiry{font-size:14px;color:#a16207;margin-top:4px}
.membership-expiry.expiring-soon{color:#dc2626;font-weight:600}
.membership-description{color:#374151;font-size:16px;line-height:1.5}
.membership-benefits h4{margin:0 0 12px 0;font-size:16px;color:#111}
.membership-benefits ul{list-style:none;padding:0;margin:0}
.membership-benefits li{display:flex;align-items:center;gap:8px;font-size:14px;color:#374151;margin-bottom:6px}
.membership-benefits li:last-child{margin-bottom:0}
.membership-price{text-align:center;padding:16px;background:#f9fafb;border-radius:8px;margin-top:8px}
.membership-price .price{font-size:32px;font-weight:800;color:#f59e0b}
.membership-price .price .period{font-size:16px;font-weight:500;color:#d97706}
.membership-price .price-description{font-size:14px;color:#6b7280;margin-top:4px}
</style>