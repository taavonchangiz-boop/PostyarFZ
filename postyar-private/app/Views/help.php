<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?php echo htmlspecialchars($title ?? 'آموزش استفاده از پُست‌یار'); ?> | پُست‌یار</title>
    <meta name="theme-color" content="#1E1A14">
    <?php $baseUrl = rtrim(str_replace(['/assets', '/public/assets'], '', \WHCM\Core\Bootstrap::getAssetsUrl()), '/'); ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $baseUrl; ?>/assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $baseUrl; ?>/assets/icons/favicon-16x16.png">
    <style>
        @font-face { font-family:'Vazirmatn'; src:url('<?php echo $baseUrl; ?>/assets/fonts/Vazirmatn-Regular.woff2') format('woff2'); font-weight:400; font-style:normal; font-display:swap; }
        @font-face { font-family:'Vazirmatn'; src:url('<?php echo $baseUrl; ?>/assets/fonts/Vazirmatn-Medium.woff2') format('woff2'); font-weight:500; font-style:normal; font-display:swap; }
        @font-face { font-family:'Vazirmatn'; src:url('<?php echo $baseUrl; ?>/assets/fonts/Vazirmatn-Bold.woff2') format('woff2'); font-weight:700; font-style:normal; font-display:swap; }
        @font-face { font-family:'Vazirmatn'; src:url('<?php echo $baseUrl; ?>/assets/fonts/Vazirmatn-Black.woff2') format('woff2'); font-weight:900; font-style:normal; font-display:swap; }
        * { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }
        body {
            font-family:'Vazirmatn',system-ui,-apple-system,sans-serif;
            background-color:#0C0A08;
            background-image:radial-gradient(ellipse 60% 40% at 85% -5%,rgba(214,172,99,.07),transparent);
            color:#F5EFE3; line-height:1.9; direction:rtl;
            min-height:100vh; display:flex; flex-direction:column;
        }
        a { color:#E9C77E; text-decoration:none; transition:color 0.2s; }
        a:hover { color:#D6AC63; }
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#0C0A08; }
        ::-webkit-scrollbar-thumb { background:#c9ced6; border-radius:99px; }
        ::-webkit-scrollbar-thumb:hover { background:#7A7062; }
        .container { max-width:860px; margin:0 auto; padding:0 1rem; }
        @media (min-width:640px) { .container { padding:0 1.5rem; } }
        @media (min-width:768px) { .container { padding:0 2rem; } }
        .step-section {
            background:#171310; border:1px solid #2B241B; border-radius:8px;
            padding:1.4rem; margin-bottom:1rem;
            box-shadow:rgba(10,15,26,.04) 0 2px 4px 0;
            transition:box-shadow .2s, transform .2s, border-color .2s;
            position:relative; overflow:hidden;
        }
        .step-section:hover { border-color:rgba(214,172,99,.35); box-shadow:rgba(10,15,26,.07) 0 4px 10px 0; transform:translateY(-1px); }
        .step-header { display:flex; align-items:center; gap:0.85rem; margin-bottom:0.9rem; }
        .step-icon {
            display:flex; align-items:center; justify-content:center;
            width:42px; height:42px; border-radius:6px; font-size:1.15rem; flex-shrink:0;
        }
        .step-num { font-size:0.7rem; color:#A99E8E; font-weight:600; letter-spacing:.3px; }
        .step-title { font-size:1.02rem; font-weight:800; color:#F5EFE3; line-height:1.5; }
        .step-body { color:#DCD3C4; font-size:0.87rem; line-height:2.1; }
        .step-body strong { color:#F5EFE3; }
        .step-body ul { padding-right:1.25rem; margin:0.5rem 0; }
        .step-body li { margin-bottom:0.3rem; }
        .tip-box {
            background:rgba(214,172,99,.06); border:1px solid rgba(214,172,99,.2);
            border-radius:6px; padding:0.85rem 1rem; margin-top:0.8rem;
            font-size:0.8rem; color:#E9C77E; line-height:1.9;
        }
        .warn-box {
            background:rgba(239,164,91,.06); border:1px solid rgba(239,164,91,.25);
            border-radius:6px; padding:0.85rem 1rem; margin-top:0.8rem;
            font-size:0.8rem; color:#FFC078; line-height:1.9;
        }
        @media (max-width:480px) {
            .step-section { padding:1.1rem; border-radius:8px; }
            .step-title { font-size:0.95rem; }
            .step-body { font-size:0.84rem; }
            .step-icon { width:36px; height:36px; font-size:1rem; border-radius:6px; }
        }
    </style>
</head>
<body>

<!-- Header -->
<header style="position:sticky; top:0; z-index:100; background:rgba(10,15,26,0.1); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border-bottom:1px solid #2B241B; padding:0.75rem 0;">
    <div class="container" style="display:flex; align-items:center; justify-content:space-between;">
        <a href="<?php echo \WHCM\Core\Bootstrap::getRouteUrl('/dashboard'); ?>" style="display:flex; align-items:center; gap:0.5rem; color:#DCD3C4; font-size:0.85rem; font-weight:500; padding:0.4rem 0.8rem; border-radius:8px; border:1px solid #2B241B; transition:all 0.2s;"
           onmouseover="this.style.borderColor='#E9C77E'; this.style.color='#F5EFE3';"
           onmouseout="this.style.borderColor='#2B241B'; this.style.color='#DCD3C4';">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="transform:scaleX(-1);"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            بازگشت
        </a>
        <span style="font-size:0.78rem; color:#7A7062;">پُست‌یار</span>
    </div>
</header>

<main style="flex:1; padding:1.5rem 0 3rem;">
    <div class="container">

        <!-- Hero -->
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="margin-bottom:1rem;">
                <img src="<?php echo $baseUrl; ?>/assets/images/asovin.webp" alt="آسوین - پُست‌یار" style="height:140px; width:auto; filter:drop-shadow(0 8px 24px rgba(214,172,99,0.3));">
            </div>
            <div style="display:inline-flex; align-items:center; justify-content:center; width:52px; height:52px; border-radius:14px; background:linear-gradient(135deg, #E9C77E 0%, #C0A8E8 100%); box-shadow:0 8px 32px rgba(214,172,99,0.3); margin-bottom:1rem;">📖</div>
            <h1 style="font-size:1.5rem; font-weight:900; color:#F5EFE3; margin-bottom:0.4rem;">راهنمای استفاده از داشبورد</h1>
            <p style="font-size:0.88rem; color:#DCD3C4; max-width:500px; margin:0 auto; line-height:1.8;">آموزش گام‌به‌گام تمام امکانات پنل مدیریت کانال‌های شما</p>
        </div>

        <!-- فهرست -->
        <div style="background:#1E1A14; border:1px solid #2B241B; border-radius:14px; padding:1.25rem; margin-bottom:2rem;">
            <div style="font-size:0.88rem; font-weight:700; color:#E9C77E; margin-bottom:0.75rem;">📑 فهرست مطالب</div>
            <div style="display:grid; grid-template-columns:1fr; gap:0.35rem;" id="toc-list"></div>
        </div>

        <!-- ===== مرحله ۱: افزودن کانال ===== -->
        <section class="step-section" id="s1">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #E9C77E, #E9C77E);">📻</div>
                <div><div class="step-num">مرحله ۱</div><div class="step-title">افزودن کانال تلگرام و بله</div></div>
            </div>
            <div class="step-body">
                <p>برای شروع کار، ابتدا باید کانال‌های تلگرام یا بله خود را به سامانه متصل کنید:</p>
                <ul>
                    <li>از منوی سمت راست (دسکتاپ) یا نوار پایین (موبایل) بخش <strong>«مدیریت کانال‌ها»</strong> را انتخاب کنید.</li>
                    <li>برای تلگرام: <strong>توکن بات</strong> کانال خود را وارد کنید. (توکن را از <strong>Botty</strong> یا <strong>BotFather</strong> دریافت کنید)</li>
                    <li>برای بله: <strong>توکن بات</strong> و <strong>شناسه کانال</strong> را وارد کنید.</li>
                </ul>
                <div class="tip-box">💡 <strong>نکته:</strong> بات باید مدیر (Admin) کانال باشد تا بتواند پست ارسال کند. پس از افزودن، کانال در لیست کانال‌های شما نمایش داده می‌شود.</div>
            </div>
        </section>

        <!-- ===== مرحله ۲: تنظیم لینک ===== -->
        <section class="step-section" id="s2">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #55C47E, #55C47E);">🔗</div>
                <div><div class="step-num">مرحله ۲</div><div class="step-title">تنظیم لینک‌ها و دکمه‌های تعاملی</div></div>
            </div>
            <div class="step-body">
                <p>هر کانال می‌تواند لینک‌ها و دکمه‌های اختصاصی خود را داشته باشد:</p>
                <ul>
                    <li>در بخش <strong>«مدیریت کانال‌ها»</strong> روی دکمه ویرایش کانال مورد نظر کلیک کنید.</li>
                    <li><strong>۳ لینک پایین محتوا:</strong> لینک کانال تلگرام، کانال بله، و سایت شما که زیر هر پست نمایش داده می‌شوند.</li>
                    <li><strong>دکمه‌های شیشه‌ای:</strong> دکمه‌های تعاملی مثل «خرید آنلاین» یا «پشتیبانی» که کاربر می‌تواند روی آن‌ها کلیک کند.</li>
                </ul>
                <div class="tip-box">💡 همچنین در <strong>تنظیمات پیشرفته</strong> می‌توانید لینک‌ها و دکمه‌های <strong>سراسری</strong> تعریف کنید که برای همه کانال‌ها اعمال شوند.</div>
            </div>
        </section>

        <!-- ===== مرحله ۳: ارسال پست ===== -->
        <section class="step-section" id="s3">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #F5BC82, #F5BC82);">✉</div>
                <div><div class="step-num">مرحله ۳</div><div class="step-title">ارسال پست جدید</div></div>
            </div>
            <div class="step-body">
                <p>از بخش <strong>«ارسال پست جدید»</strong> می‌توانید محتوا منتشر کنید:</p>
                <ul>
                    <li><strong>متن پیام:</strong> متن پست خود را وارد کنید (پشتیبانی از ایموجی و فرمت‌بندی).</li>
                    <li><strong>تصاویر و ویدیو:</strong> فایل‌های چندرسانه‌ای را آپلود کنید (پشتیبانی از چند فایل همزمان).</li>
                    <li><strong>انتخاب کانال:</strong> یک یا چند کانال را برای انتشار انتخاب کنید.</li>
                    <li><strong>ارسال فوری:</strong> دکمه «ارسال» را بزنید تا پست بلافاصله منتشر شود.</li>
                </ul>
                <div class="tip-box">💡 اگر کپشن هوشمند فعال باشد، می‌توانید از دکمه <strong>AI</strong> برای تولید خودکار کپشن حرفه‌ای استفاده کنید.</div>
            </div>
        </section>

        <!-- ===== مرحله ۴: زمانبندی ===== -->
        <section class="step-section" id="s4">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #E4686F, #E4686F);">⏰</div>
                <div><div class="step-num">مرحله ۴</div><div class="step-title">زمانبندی ارسال پست‌ها</div></div>
            </div>
            <div class="step-body">
                <p>نیازی نیست در لحظه پست بگذارید! از زمانبندی استفاده کنید:</p>
                <ul>
                    <li>در فرم ارسال پست، تاریخ و ساعت مورد نظر را با <strong>تقویم شمسی</strong> انتخاب کنید.</li>
                    <li>پست در زمان مشخص شده به صورت خودکار ارسال خواهد شد.</li>
                    <li>پست‌های زمان‌بندی شده با برچسب <strong>«در انتظار ارسال»</strong> در لیست پست‌ها نمایش داده می‌شوند.</li>
                </ul>
                <div class="warn-box">⚠ <strong>توجه:</strong> مطمئن شوید تاریخ و ساعت آینده انتخاب شده باشد. همچنین سامانه باید فعال باشد تا پست در زمان مقرر ارسال شود.</div>
            </div>
        </section>

        <!-- ===== مرحله ۵: صندوق پیام ===== -->
        <section class="step-section" id="s5">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #AEC4DC, #AEC4DC);">📩</div>
                <div><div class="step-num">مرحله ۵</div><div class="step-title">صندوق پیام کانال‌ها</div></div>
            </div>
            <div class="step-body">
                <p>پیام‌هایی که کاربران به کانال‌های شما ارسال می‌کنند در این بخش قابل مشاهده است:</p>
                <ul>
                    <li>از منو بخش <strong>«صندوق پیام»</strong> را انتخاب کنید.</li>
                    <li>پیام‌های دریافتی از تمام کانال‌ها اینجا نمایش داده می‌شوند.</li>
                    <li>می‌توانید مستقیماً از اینجا به پیام‌ها پاسخ دهید.</li>
                </ul>
                <div class="tip-box">💡 اگر <strong>پاسخگوی خودکار</strong> فعال باشد، سامانه به پیام‌های کلمه‌کلیدی به صورت خودکار پاسخ می‌دهد و نیازی به پاسخ دستی نیست.</div>
            </div>
        </section>

        <!-- ===== مرحله ۶: تیکت ===== -->
        <section class="step-section" id="s6">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #C0A8E8, #C0A8E8);">🎫</div>
                <div><div class="step-num">مرحله ۶</div><div class="step-title">سیستم تیکت پشتیبانی</div></div>
            </div>
            <div class="step-body">
                <p>برای ارتباط با پشتیبانی از تیکت استفاده کنید:</p>
                <ul>
                    <li>از منو بخش <strong>«پشتیبانی و تیکت‌ها»</strong> را انتخاب کنید.</li>
                    <li>دکمه <strong>«ثبت تیکت جدید»</strong> را بزنید، موضوع و پیام خود را وارد کنید.</li>
                    <li>پاسخ‌های مدیر در هر تیکت نمایش داده می‌شود و می‌توانید ادامه گفتگو دهید.</li>
                </ul>
                <div class="tip-box">💡 فقط تیکت‌های <strong>باز</strong> در صندوق نمایش داده می‌شوند. تیکت‌های بسته‌شده در بخش «بایگانی» قابل مشاهده هستند.</div>
            </div>
        </section>

        <!-- ===== مرحله ۷: اشتراک ===== -->
        <section class="step-section" id="s7">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #55C47E, #82D9A2);">💎</div>
                <div><div class="step-num">مرحله ۷</div><div class="step-title">خرید و تمدید اشتراک</div></div>
            </div>
            <div class="step-body">
                <p>برای استفاده از تمام امکانات، اشتراک فعال نیاز دارید:</p>
                <ul>
                    <li>از منو بخش <strong>«خرید اشتراک»</strong> را انتخاب کنید.</li>
                    <li>پلن مورد نظر را انتخاب و دکمه <strong>«انتخاب این پلن»</strong> را بزنید.</li>
                    <li><strong>شماره کارت</strong> مدیر سامانه نمایش داده می‌شود — با کلیک روی کارت کپی می‌شود.</li>
                    <li>مبلغ را واریز کرده، <strong>کد رهگیری</strong> و <strong>تصویر رسید</strong> را بارگذاری کنید.</li>
                    <li>پس از تأیید توسط مدیر، اشتراک فعال خواهد شد.</li>
                </ul>
                <div class="tip-box">💡 اگر <strong>بلو لینک</strong> فعال باشد، می‌توانید مستقیماً از داخل سامانه پرداخت آنلاین انجام دهید.</div>
            </div>
        </section>

        <!-- ===== مرحله ۸: زیرمجموعه و کیف پول ===== -->
        <section class="step-section" id="s8">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #F5BC82, #F5BC82);">🎯</div>
                <div><div class="step-num">مرحله ۸</div><div class="step-title">زیرمجموعه‌گیری و کیف پول</div></div>
            </div>
            <div class="step-body">
                <p>با دعوت دوستان، امتیاز و پاداش کسب کنید:</p>
                <ul>
                    <li><strong>کد معرف و لینک دعوت:</strong> لینک خود را کپی و به اشتراک بگذارید.</li>
                    <li>هر شخصی که با لینک شما ثبت‌نام کند، در لیست زیرمجموعه‌ها نمایش داده می‌شود.</li>
                    <li>هنگامی که زیرمجموعه شما اشتراک بخرد، <strong>پاداش</strong> به کیف پول شما واریز می‌شود.</li>
                    <li><strong>تبدیل امتیاز:</strong> امتیازات را می‌توانید به موجودی کیف پول تبدیل و از آن برای پرداخت اشتراک استفاده کنید.</li>
                </ul>
            </div>
        </section>

        <!-- ===== مرحله ۹: تنظیمات پیشرفته ===== -->
        <section class="step-section" id="s9">
            <div class="step-header">
                <div class="step-icon" style="background:linear-gradient(135deg, #E9C77E, #E9C77E);">⚙</div>
                <div><div class="step-num">مرحله ۹</div><div class="step-title">تنظیمات پیشرفته</div></div>
            </div>
            <div class="step-body">
                <p>در این بخش تنظیمات حرفه‌ای سامانه قرار دارد:</p>
                <ul>
                    <li><strong>لینک‌های سراسری:</strong> ۳ لینک و ۳ دکمه تعاملی که برای همه کانال‌ها اعمال می‌شوند.</li>
                    <li><strong>تنظیمات ارسال:</strong> قالب متن (ساده یا HTML) و روش دریافت پیام‌ها (Polling یا Webhook).</li>
                    <li><strong>هوش مصنوعی:</strong> تنظیم سرویس AI و مدل برای تولید کپشن خودکار.</li>
                    <li><strong>ربات طلا:</strong> تنظیمات خودکار نرخ ارز طلا و سکه (اگر پلن شما شامل این ویژگی باشد).</li>
                </ul>
                <div class="warn-box">⚠ تغییر در تنظیمات پیشرفته فقط روی پست‌های <strong>جدید</strong> اعمال می‌شود و پست‌های قبلی تحت تأثیر قرار نمی‌گیرند.</div>
            </div>
        </section>

    </div>
</main>

<!-- Footer -->
<footer style="background:#1E1A14; border-top:1px solid #2B241B; padding:1.25rem 0; text-align:center; margin-top:auto;">
    <div class="container">
        <p style="color:#3A3025; font-size:0.75rem;">© تمامی حقوق محفوظ است | پُست‌یار</p>
    </div>
</footer>

<script>
(function(){
    const sections = document.querySelectorAll('.step-section');
    const tocContainer = document.getElementById('toc-list');
    const colors = ['#E9C77E','#55C47E','#F5BC82','#E4686F','#AEC4DC','#C0A8E8','#55C47E','#F5BC82','#E9C77E'];
    sections.forEach(function(sec, i){
        const title = sec.querySelector('.step-title');
        if(!title) return;
        const a = document.createElement('a');
        a.href = '#' + sec.id;
        a.style.cssText = 'display:flex;align-items:center;gap:0.6rem;padding:0.45rem 0.7rem;border-radius:8px;font-size:0.85rem;color:#DCD3C4;transition:all 0.2s;';
        a.innerHTML = '<span style="display:flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:7px;background:' + colors[i] + '22;color:' + colors[i] + ';font-size:0.7rem;font-weight:700;flex-shrink:0;">' + (i+1) + '</span>' + title.textContent;
        a.onmouseover = function(){ this.style.background=colors[i]+'15'; this.style.color='#F5EFE3'; };
        a.onmouseout = function(){ this.style.background='transparent'; this.style.color='#DCD3C4'; };
        tocContainer.appendChild(a);
    });
})();
</script>

</body>
</html>