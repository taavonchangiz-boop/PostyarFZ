# Postyar — پُست‌یار

سامانه هوشمند مدیریت و انتشار چندکاناله در تلگرام و بله · Persian RTL SaaS

> این نسخه شامل **بازطراحی کامل رابط کاربری بر پایه قالب [Gentelella v4](https://github.com/ColorlibHQ/gentelella) (ColorlibHQ)** است — بدون هیچ تغییری در منطق برنامه، جریان داده، عملکردهای backend و منطق کسب‌وکار.

## ساختار پروژه

```
├── postyar-private/        # هسته برنامه (خارج از ریشه وب — الگوی استاندارد cPanel)
│   ├── app/
│   │   ├── Api/            # REST API موبایل (/api/v1)
│   │   ├── Controllers/    # کنترلرهای وب
│   │   ├── Core/           # هسته فریم‌ورک (Bootstrap, Router, Auth, ...)
│   │   ├── Domain/         # منطق کسب‌وکار (Sender, GoldTicker, Quota, ...)
│   │   ├── Modules/        # ماژول‌ها
│   │   └── Views/          # ویوهای PHP (بازطراحی‌شده با پوسته Gentelella)
│   ├── config/  migrations/  docs/  tests/  tools/
│   └── public/             # نسخه درون‌ریپویی assetها (همگام با public_html)
├── public_html/            # ریشه وب (assetهای استقرار)
│   └── assets/{css,js,fonts,images,icons,plans}
└── DESIGN-SYSTEM.md        # 📐 مستندات کامل پالت Gentelella (HEX/RGB/HSL)
```

## ✨ خلاصه بازطراحی Gentelella v4

| محور | توضیح |
|---|---|
| منبع طراحی | `github.com/ColorlibHQ/gentelella` — توکن‌ها و کالبد از `src/scss/v4` استخراج و RTL-first پورت شد |
| پالت لوکس | «اونیکس و شامپاین» — زمینه `#0C0A08` · سطوح `#171310` · طلایی `#D6AC63` + جید `#55C9A4` · کامل در `DESIGN-SYSTEM.md` |
| چیدمان | سایدبار ثابت تیره ۲۵۲px + تاپ‌بار شیشه‌ای ۵۶px + کارت‌های سفید + کاشی آماری + فوتر |
| سایدبار جمع‌شونده | دسکتاپ: rail ۶۴px با tooltip و ذخیره وضعیت (هر دو پنل) · موبایل: دراور + backdrop |
| فونت | فقط **Vazirmatn** (۸ وزن woff2) — جایگزین Inter قالب |
| صفحات | لندینگ · داشبورد کاربر · پنل مدیریت · راهنما · حریم خصوصی · خطا + ۶ partial |
| بدون تغییر | منطق PHP، IDها، name فرم‌ها، data-attributeها، APIها، دیتابیس، هوک‌های JS |

### فایل‌های کلیدی

- `assets/css/gentelella.css` — **قلب طراحی**: پورت کامل سیستم Gentelella v4 (توکن‌ها، سایدبار، تاپ‌بار، rail، کارت، جدول، فرم، مودال…) + RTL
- `assets/css/components.css` — فونت Vazirmatn + پوسته روشن تقویم شمسی + بلوبانک
- `assets/css/dashboard.css` / `admin.css` — لایه‌های اختصاصی صفحات
- `assets/css/home.css` + `tailwind-home.css` — لندینگ Gentelella (کامپایل مجدد Tailwind v3.4.17 با پالت نگاشت‌شده)
- `assets/js/gentelella.js` — رفتارهای پوسته: جمع‌شدن سایدبار (rail) + دراور موبایل + breadcrumb
- `app/Views/*.php` — پوسته‌ها با ساختار Gentelella بازسازی؛ ۹۴۰+ توکن رنگ اینلاین بازنگاشت

## 🔧 ساخت مجدد Tailwind لندینگ

```bash
cd .tailwind-build
bun install
echo '@tailwind base; @tailwind components; @tailwind utilities;' > input.css
bunx tailwindcss -c tailwind.config.js -i input.css \
  -o ../public_html/assets/css/tailwind-home.css --minify
```

## 🚀 استقرار (cPanel)

ساختار همان استقرار تولید است: `postyar-private` خارج از ریشه وب، `public_html` ریشه وب. پس از pull:

1. هیچ مهاجرت دیتابیسی لازم نیست (فقط UI).
2. کش سرویس‌ورکر خودکار به v7 ارتقا می‌یابد.
3. در صورت CDN، کش `assets/css/*` را پاک کنید (نسخه‌ها به v16 ارتقا یافته‌اند).
