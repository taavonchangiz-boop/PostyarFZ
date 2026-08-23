# Postyar — پُست‌یار

سامانه هوشمند مدیریت و انتشار چندکاناله در تلگرام و بله · Persian RTL SaaS

> این نسخه شامل **بازطراحی کامل رابط کاربری ۲۰۲۵** با سامانه طراحی **«زرّین» (Zarrin)** است — بدون هیچ تغییری در منطق برنامه، جفــتان داده، عملکردهای backend و منطق کسب‌وکار.

## ساختار پروژه

```
├── postyar-private/        # هسته برنامه (خارج از ریشه وب — الگوی استاندارد cPanel)
│   ├── app/
│   │   ├── Api/            # REST API موبایل (/api/v1)
│   │   ├── Controllers/    # کنترلرهای وب
│   │   ├── Core/           # هسته فریم‌ورک (Bootstrap, Router, Auth, ...)
│   │   ├── Domain/         # منطق کسب‌وکار (Sender, GoldTicker, Quota, ...)
│   │   ├── Modules/        # ماژول‌ها
│   │   └── Views/          # ویوهای PHP (بازطراحی‌شده)
│   ├── config/  migrations/  docs/  tests/  tools/
│   └── public/             # نسخه درون‌ریپویی assetها (همگام با public_html)
├── public_html/            # ریشه وب (assetهای استقرار)
│   └── assets/{css,js,fonts,images,icons,plans}
└── DESIGN-SYSTEM.md        # 📐 مستندات کامل پالت رنگی و سامانه طراحی
```

## ✨ خلاصه بازطراحی «زرّین»

| محور | توضیح |
|---|---|
| پالت | طلایی گرم `#E5B44E` + فیروزه‌ای `#4AD6BE` روی سطوح اسپرسوی `#0D0B08` — مستندات کامل HEX/RGB/HSL در `DESIGN-SYSTEM.md` |
| فونت | فقط **Vazirmatn** (۸ وزن woff2) |
| صفحات | لندینگ · داشبورد کاربر · پنل مدیریت · راهنما · حریم خصوصی · خطا + ۶ partial |
| ریسپانسیو | موبایل عمودی/افقی · تبلت عمودی/افقی · دسکتاپ ۱۳″ تا اولتراواید ۲۵۶۰px |
| دسترس‌پذیری | فوکوس‌رینگ طلایی، کنتراست AAA متن بدنه، `prefers-reduced-motion`، اهداف لمسی ≥ 44px |
| بدون تغییر | منطق PHP، IDها، name فرم‌ها، data-attributeها، APIها، دیتابیس، هوک‌های JS |

### فایل‌های کلیدی بازطراحی‌شده

- `public_html/assets/css/components.css` — توکن‌های طراحی + فونت + پایه مشترک
- `public_html/assets/css/dashboard.css` — داشبورد کاربر (کاملاً بازنویسی)
- `public_html/assets/css/admin.css` — پنل مدیریت (کاملاً بازنویسی)
- `public_html/assets/css/home.css` — اجزای اختصاصی لندینگ
- `public_html/assets/css/tailwind-home.css` — کامپایل مجدد Tailwind v3.4.17 با پالت نگاشت‌شده
- `app/Views/*.php` + `app/Views/partials/*.php` — بازنگاری رنگ‌های اینلاین (۸۹۲+ توکن)
- `manifest.json` / `service-worker.js` — تم زرّین + ارتقای کش به v6

## 🔧 ساخت مجدد Tailwind لندینگ

پیکربندی کامپایل در `.tailwind-build/tailwind.config.js` (نگاشت indigo→طلایی، purple→مسی، pink→مرجانی، neutral→سنگ گرم):

```bash
cd .tailwind-build
bun install                       # tailwindcss@3.4.17
echo '@tailwind base; @tailwind components; @tailwind utilities;' > input.css
bunx tailwindcss -c tailwind.config.js -i input.css \
  -o ../public_html/assets/css/tailwind-home.css --minify
```

## 🚀 استقرار (cPanel)

ساختار فعلی همان استقرار تولید است: `postyar-private` خارج از ریشه وب و `public_html` به‌عنوان ریشه وب. پس از pull:

1. هیچ مهاجرت دیتابیسی لازم نیست (فقط UI تغییر کرده است).
2. کش سرویس‌ورکر خودکار به v6 ارتقا می‌یابد (بازدیدکنندگان CSS جدید را دریافت می‌کنند).
3. در صورت استفاده از CDN، کش `assets/css/*` را پاک کنید (نسخه‌های `?v=15` نیز ارتقا یافته‌اند).
