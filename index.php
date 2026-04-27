<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
$csrf_token = generate_csrf_token();
$persian_months = [
    1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
    4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
    7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
    10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
];
$page_title    = get_setting('display_page_title', 'باشگاه مشتریان');
$card_title    = get_setting('display_card_title', 'ثبت‌نام و مراجعه مشتری');
$card_subtitle = get_setting('display_card_subtitle', 'شماره موبایل را وارد کنید');
$btn_main      = get_setting('display_btn_main', 'ثبت مراجعه و ارسال پیامک');
$btn_second    = get_setting('display_btn_secondary', 'ثبت مراجعه و دریافت امتیاز (بدون پیامک)');
$shop_name     = htmlspecialchars(get_setting('shop_name'));
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> | <?= $shop_name ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
</head>
<body>

<header class="topbar">
    <div class="topbar-brand">
        <div class="topbar-logo">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" /></svg>
        </div>
        <div>
            <div class="topbar-title"><?= $shop_name ?></div>
            <div class="topbar-subtitle"><?= $page_title ?></div>
        </div>
    </div>
    <div class="topbar-divider"></div>
    <span class="topbar-badge">ثبت مراجعه</span>
    <div class="topbar-spacer"></div>
    <div class="topbar-status"><span class="status-dot"></span><span>آنلاین</span></div>
</header>

<div id="toastContainer"></div>

<div class="main-wrapper">
    <div class="main-card">
        <div class="card-header">
            <div class="card-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" /></svg>
            </div>
            <div>
                <h1><?= htmlspecialchars($card_title) ?></h1>
                <p><?= htmlspecialchars($card_subtitle) ?></p>
            </div>
        </div>

        <div class="form-body">
            <form id="registerForm" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                <div class="form-section">
                    <div class="section-label">شماره موبایل</div>
                    <div class="mobile-digits" id="mobileDigits">
                        <input type="text" class="digit-box prefix-box" value="09" readonly tabindex="-1">
                        <div class="digit-separator">-</div>
                        <?php for($i=3;$i<=11;$i++): ?>
                            <input type="text" class="digit-box" id="digit_<?=$i?>" maxlength="1" inputmode="numeric" autocomplete="off">
                            <?php if($i<11): ?><div class="digit-separator">-</div><?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <input type="hidden" name="mobile" id="mobile">
                </div>

                <div class="form-section">
                    <div class="section-label">مشخصات فردی</div>
                    <div class="row-2col">
                        <div class="field-group">
                            <label class="field-label">نام</label>
                            <input type="text" name="first_name" id="first_name" class="input-field" placeholder="نام مشتری">
                        </div>
                        <div class="field-group">
                            <label class="field-label">نام خانوادگی</label>
                            <input type="text" name="last_name" id="last_name" class="input-field" placeholder="نام خانوادگی">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">جنسیت</label>
                        <div class="gender-options">
                            <div class="gender-option"><input type="radio" name="gender" id="gender_male" value="male"><label for="gender_male"><span class="gender-icon">👨</span>مرد</label></div>
                            <div class="gender-option"><input type="radio" name="gender" id="gender_female" value="female"><label for="gender_female"><span class="gender-icon">👩</span>زن</label></div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-label">تاریخ تولد <span style="font-weight:400;color:var(--text-muted);">اختیاری</span></div>
                    <div class="row-3col">
                        <div class="field-group">
                            <label class="field-label">روز</label>
                            <select name="birth_day" id="birth_day" class="input-field"><option value="">—</option><?php for($d=1;$d<=31;$d++): ?><option value="<?=$d?>"><?=$d?></option><?php endfor; ?></select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">ماه</label>
                            <select name="birth_month" id="birth_month" class="input-field"><option value="">—</option><?php foreach($persian_months as $num=>$name): ?><option value="<?=$num?>"><?=$name?></option><?php endforeach; ?></select>
                        </div>
                        <div class="field-group">
                            <label class="field-label">سال</label>
                            <input type="text" name="birth_year" id="birth_year" list="yearList" class="input-field" placeholder="—" autocomplete="off" inputmode="numeric">
                            <datalist id="yearList"><?php for($y=1430;$y>=1300;$y--): ?><option value="<?=$y?>"><?php endfor; ?></datalist>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div style="padding:0 26px 26px;">
            <div class="btn-group">
                <button type="submit" id="submitBtn" class="btn-main" form="registerForm">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span><?= $btn_main ?></span>
                </button>
                <button type="button" id="btnNoSms" class="btn-secondary">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" /></svg>
                    <span><?= $btn_second ?></span>
                </button>
            </div>
        </div>

        <div class="card-footer">
            <span>سیستم باشگاه مشتریان — نسخه ۱.۰</span>
            <span><?= jdate('Y') ?></span>
        </div>
    </div>
</div>

<!-- پنل اسلاید -->
<div id="repeatModal" class="slide-overlay">
    <div class="slide-panel">
        <div class="slide-header">
            <div class="slide-header-top">
                <div class="slide-header-title-area">
                    <div class="slide-avatar" id="slideAvatar">م</div>
                    <div><h3 id="modalTitle">مشتری</h3><p>مشخصات و تاریخچه</p></div>
                </div>
                <button class="btn-close-panel" id="btnCloseModal"><svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
            <div class="slide-info-bar" id="slideInfoBar"></div>
        </div>

        <div class="slide-body">
            <div class="stats-grid" id="statsGrid"></div>

            <div class="visits-section">
                <div class="visits-title">📋 تاریخچه فعالیت‌ها</div>
                <div class="visits-wrapper">
                    <table class="visits">
                        <thead><tr><th>تاریخ و ساعت</th><th>نوع</th><th>امتیاز</th><th>توضیح</th></tr></thead>
                        <tbody id="timelineTableBody"></tbody>
                    </table>
                </div>
                <div class="pagination-bar" id="paginationBar"></div>
            </div>

            <div class="divider-section"></div>

            <div class="action-list">
                <button id="btnUseAllPoints" class="btn-action btn-use"><span class="icon">🎁</span> استفاده از کل امتیازات</button>
                <button id="btnDeleteCustomer" class="btn-action btn-delete"><span class="icon">⛔</span> حذف از باشگاه</button>
                <button id="btnResendSMS" class="btn-action btn-sms"><span class="icon">✉️</span> ارسال پیامک مجدد</button>
                <div class="divider-section" style="margin:6px 0"></div>
                <button id="btnCloseSlide" class="btn-action btn-close-slide"><span class="icon">✕</span> بستن</button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/modal_confirm.php'; ?>

<script>
const csrfToken = '<?= $csrf_token ?>';
const submitBtn = document.getElementById('submitBtn');
const btnNoSms  = document.getElementById('btnNoSms');
const overlay   = document.getElementById('repeatModal');

let currentMobile = null, currentCustomerId = null, currentPage = 1;

// ===== مدیریت ورود شماره (مشابه sample.php) =====
const digitInputs = document.querySelectorAll('.digit-box:not(.prefix-box)');
const mobileHidden = document.getElementById('mobile');

function updateMobileValue() {
    let val = '09';
    digitInputs.forEach(d => val += d.value);
    mobileHidden.value = val;
}

digitInputs.forEach((inp, idx) => {
    inp.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 1) {
            this.classList.add('filled');
            if (idx < digitInputs.length - 1) digitInputs[idx + 1].focus();
        } else {
            this.classList.remove('filled');
        }
        updateMobileValue();
    });
    inp.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && idx > 0) {
            digitInputs[idx - 1].focus();
            digitInputs[idx - 1].value = '';
            digitInputs[idx - 1].classList.remove('filled');
            updateMobileValue();
        }
    });
    inp.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
        let remaining = paste.length;
        for (let i = idx; i < digitInputs.length && remaining > 0; i++) {
            digitInputs[i].value = paste[paste.length - remaining];
            digitInputs[i].classList.add('filled');
            remaining--;
        }
        if (idx + paste.length <= digitInputs.length) {
            const lastFilled = Math.min(idx + paste.length - 1, digitInputs.length - 1);
            digitInputs[lastFilled].focus();
        }
        updateMobileValue();
    });
});
setTimeout(() => { if(digitInputs[0]) digitInputs[0].focus(); }, 200);

// ===== Toast =====
function showToast(msg, type) {
    const container = document.getElementById('toastContainer');
    const icons = {success:'✅', error:'❌', warning:'⚠️', info:'ℹ️'};
    const toast = document.createElement('div');
    toast.className = `toast-item toast-${type}`;
    toast.innerHTML = `<span>${icons[type]||'🔔'}</span><span>${msg}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.add('removing');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// ===== پنل اسلاید =====
function closeModal() {
    overlay.classList.remove('active');
    currentMobile = null;
    currentCustomerId = null;
    currentPage = 1;
    submitBtn.disabled = false;
    btnNoSms.disabled = false;
    // reset button texts
    submitBtn.innerHTML = document.querySelector('#submitBtn svg').outerHTML + '<span><?= addslashes($btn_main) ?></span>';
    btnNoSms.innerHTML = document.querySelector('#btnNoSms svg').outerHTML + '<span><?= addslashes($btn_second) ?></span>';
}

document.getElementById('btnCloseModal').addEventListener('click', closeModal);
document.getElementById('btnCloseSlide').addEventListener('click', closeModal);
overlay.addEventListener('click', (e) => { if(e.target === overlay) closeModal(); });
document.addEventListener('keydown', (e) => { if(e.key === 'Escape' && overlay.classList.contains('active')) closeModal(); });

async function loadModal(mobile, page = 1) {
    const res = await fetch('api/check_mobile.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `mobile=${encodeURIComponent(mobile)}&csrf_token=${csrfToken}&page=${page}`
    });
    const data = await res.json();
    if (!data.exists) return;

    currentMobile = mobile;
    currentCustomerId = data.customer_id;
    currentPage = data.pagination.current_page;

    document.getElementById('slideAvatar').textContent = (data.full_name || 'م').charAt(0);
    document.getElementById('modalTitle').textContent = `${data.title} ${data.full_name}`;
    document.getElementById('slideInfoBar').innerHTML = `
        <span class="info-chip"><span class="chip-icon">📱</span>${data.mobile}</span>
        <span class="info-chip"><span class="chip-icon">📅</span>عضویت: ${data.membership_date}</span>
        <span class="info-chip"><span class="chip-icon">🕒</span>آخرین: ${data.last_visit}</span>
        <span class="info-chip chip-accent"><span class="chip-icon">${data.gender==='male'?'👨':'👩'}</span>${data.gender==='male'?'مرد':(data.gender==='female'?'زن':'نامشخص')}</span>
    `;

    document.getElementById('statsGrid').innerHTML = `
        <div class="stat-card stat-yellow"><div class="stat-number">${data.total_points}</div><div class="stat-label">⭐ امتیاز</div></div>
        <div class="stat-card stat-green"><div class="stat-number">${Number(data.rial_value).toLocaleString()}</div><div class="stat-label">💵 تومان</div></div>
        <div class="stat-card stat-purple"><div class="stat-number">${data.discount_percent}٪</div><div class="stat-label">🎯 تخفیف</div></div>
    `;

    renderTimeline(data.timeline);
    updatePagination(data.pagination);

    overlay.classList.add('active');
}

function renderTimeline(items) {
    const tbody = document.getElementById('timelineTableBody');
    if (!items || items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="empty-state">موردی یافت نشد</td></tr>';
        return;
    }
    tbody.innerHTML = '';
    items.forEach(item => {
        let typeLabel = '', typeClass = '';
        if (item.type === 'visit') { typeLabel = '🟢 مراجعه'; typeClass = 'earn'; }
        else if (item.type === 'earn') { typeLabel = '💚 کسب امتیاز'; typeClass = 'earn'; }
        else { typeLabel = '🔴 مصرف امتیاز'; typeClass = 'use'; }
        tbody.innerHTML += `<tr>
            <td>${item.event_date_shamsi}</td>
            <td><span class="pt-badge">${typeLabel}</span></td>
            <td>${item.points}</td>
            <td>${item.description||''}</td>
        </tr>`;
    });
}

function updatePagination(pg) {
    const bar = document.getElementById('paginationBar');
    if (pg.last_page <= 1) { bar.innerHTML = ''; return; }
    bar.innerHTML = `
        <button class="btn-page" onclick="changePage(${pg.current_page - 1})" ${pg.current_page<=1?'disabled':''}>قبلی</button>
        <span>صفحه ${pg.current_page} از ${pg.last_page}</span>
        <button class="btn-page" onclick="changePage(${pg.current_page + 1})" ${pg.current_page>=pg.last_page?'disabled':''}>بعدی</button>
    `;
}

async function changePage(page) {
    if (!currentMobile) return;
    const res = await fetch('api/check_mobile.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `mobile=${encodeURIComponent(currentMobile)}&csrf_token=${csrfToken}&page=${page}`
    });
    const data = await res.json();
    if (data.exists) {
        currentPage = data.pagination.current_page;
        renderTimeline(data.timeline);
        updatePagination(data.pagination);
    }
}

// ===== عملیات پنل =====
async function modalAction(action) {
    const res = await fetch('api/modal_actions.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `action=${action}&customer_id=${currentCustomerId}&csrf_token=${csrfToken}`
    });
    return await res.json();
}

document.getElementById('btnUseAllPoints').addEventListener('click', () => {
    appConfirm('استفاده از کل امتیازات', 'آیا از مصرف کل امتیازات اطمینان دارید؟', async () => {
        const r = await modalAction('use_points');
        if (r.success) { showToast(r.message, 'success'); closeModal(); }
        else showToast(r.message, 'error');
    });
});

document.getElementById('btnDeleteCustomer').addEventListener('click', () => {
    appConfirm('حذف از باشگاه', 'آیا از غیرفعال‌سازی این مشتری اطمینان دارید؟', async () => {
        const r = await modalAction('deactivate');
        if (r.success) { showToast(r.message, 'success'); closeModal(); }
        else showToast(r.message, 'error');
    });
});

document.getElementById('btnResendSMS').addEventListener('click', () => {
    appConfirm('ارسال پیامک', 'آیا مایل به ارسال پیامک مجدد هستید؟', async () => {
        const r = await modalAction('resend_sms');
        if (r.success) showToast('پیامک با موفقیت ارسال شد', 'success');
        else showToast(r.message, 'error');
    });
});

// ===== ثبت‌نام و مراجعه =====
async function registerVisit(mobile, repeated, sendSms) {
    const btn = sendSms ? submitBtn : btnNoSms;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin" width="18" height="18" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> <span>در حال ثبت...</span>';

    const first = document.getElementById('first_name').value.trim();
    const last  = document.getElementById('last_name').value.trim();
    const genderEl = document.querySelector('input[name="gender"]:checked');
    const gender = genderEl ? genderEl.value : '';
    const day   = document.getElementById('birth_day').value;
    const month = document.getElementById('birth_month').value;
    const year  = document.getElementById('birth_year').value.trim();
    const shamsiDate = (year && month && day) ? `${year}-${month}-${day}` : '';

    const params = new URLSearchParams();
    params.append('mobile', mobile);
    params.append('first_name', first);
    params.append('last_name', last);
    params.append('gender', gender);
    params.append('birth_date_shamsi', shamsiDate);
    params.append('is_repeated', repeated ? '1' : '0');
    params.append('send_sms', sendSms ? '1' : '0');
    params.append('csrf_token', csrfToken);

    const res = await fetch('api/register_visit.php', { method: 'POST', body: params });
    const result = await res.json();

    if (result.success) {
        let msg = result.message;
        if (result.updated_fields && result.updated_fields.length) {
            msg += ` اطلاعات ${result.updated_fields.join('، ')} بروزرسانی شد.`;
        }
        showToast(msg, 'success');
        if (!sendSms && !repeated) {
            // بدون پیامک و مشتری جدید -> باز کردن پنل
            await loadModal(mobile, 1);
        } else {
            // پاک‌سازی فرم
            document.getElementById('registerForm').reset();
            digitInputs.forEach(d => { d.value = ''; d.classList.remove('filled'); });
            mobileHidden.value = '';
            document.querySelectorAll('.input-field.is-completed').forEach(f => f.classList.remove('is-completed'));
        }
    } else {
        showToast(result.message || 'خطایی رخ داد', 'error');
    }

    btn.disabled = false;
    btn.innerHTML = (btn === submitBtn)
        ? '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span><?= addslashes($btn_main) ?></span>'
        : '<svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499..."/></svg><span><?= addslashes($btn_second) ?></span>';
}

async function handleFormSubmit(mobile, sendSms) {
    const chk = await fetch('api/check_mobile.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `mobile=${encodeURIComponent(mobile)}&csrf_token=${csrfToken}&page=1`
    });
    const data = await chk.json();

    if (!data.exists) {
        await registerVisit(mobile, false, sendSms);
} else if (data.inactive) {
    // ⬅️ حتماً id را ذخیره کن
    currentCustomerId = data.customer_id;

    const deactDate = data.deactivated_date || 'نامشخص';
    appConfirm(
        'مشتری غیرفعال',
        `این مشتری در تاریخ ${deactDate} غیرفعال شده است. آیا مایل به فعال‌سازی مجدد و ثبت مراجعه هستید؟`,
        async () => {
            const reactRes = await modalAction('reactivate');
            if (reactRes.success) {
                showToast('مشتری با موفقیت فعال شد.', 'success');
                await registerVisit(mobile, true, sendSms);
            } else {
                showToast(reactRes.message, 'error');
            }
        }
    );
    } else {
        await loadModal(mobile, 1);
    }
}

// ===== رویدادهای دکمه =====
submitBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    const mobile = mobileHidden.value.trim();
    if (!/^09[1-9][0-9]{8}$/.test(mobile)) { showToast('شماره موبایل معتبر نیست', 'warning'); return; }
    await handleFormSubmit(mobile, true);
});

btnNoSms.addEventListener('click', async () => {
    const mobile = mobileHidden.value.trim();
    if (!/^09[1-9][0-9]{8}$/.test(mobile)) { showToast('شماره موبایل معتبر نیست', 'warning'); return; }
    await handleFormSubmit(mobile, false);
});
</script>
</body>
</html>
